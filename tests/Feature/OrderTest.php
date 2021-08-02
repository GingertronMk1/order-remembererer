<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use App\Models\Vendor;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class OrderTest extends TestCase
{
    private $admin;
    private $user1;
    private $user2;
    private $vendor;
    private $team;
    private $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vendor = Vendor::factory()->create();
        $this->admin = User::factory()->admin()->withPersonalTeam()->create();
        [
            $this->user1,
            $this->user2
        ] = User::factory(2)->withPersonalTeam()->create();
        $this->team = Team::factory()->create();
        $this->order = $this->user1->orders()->create([
            'vendor_id' => $this->vendor->id,
            'food' => 'test food',
        ]);
    }

    public function testUsersMustBeOnSameTeamToLookAtEachOthersOrders()
    {
        foreach ([
            [
                'user' => $this->user2,
                'expected' => 403,
            ],
            [
                'user' => $this->user1,
                'expected' => 200,
            ],
            [
                'user' => $this->admin,
                'expected' => 200,
            ],
        ] as $val) {
            $this->actingAs($val['user']);

            $response = $this->get(route('vendor.order.show', [
                'vendor' => $this->vendor,
                'order' => $this->order,
            ]));
            $response->assertStatus($val['expected']);
        }

        $this->team->users()->attach([$this->user1->id, $this->user2->id], ['role' => 'editor']);

        foreach ([
            $this->user1,
            $this->user2,
            $this->admin,
        ] as $user) {
            $user->refresh();
            $this->actingAs($user);

            $response = $this->get(route('vendor.order.show', [
                'vendor' => $this->vendor,
                'order' => $this->order,
            ]));
            $response->assertStatus(200);
        }
    }

    public function testUsersCannotDeleteEachOthersOrders()
    {
        foreach ([
            [
                'user' => $this->user1,
                'fn' => 'assertRedirect',
                'expected' => route('vendor.order.index', ['vendor' => $this->vendor]),
            ],
            [
                'user' => $this->user2,
                'fn' => 'assertStatus',
                'expected' => 403,
            ],
            [
                'user' => $this->admin,
                'fn' => 'assertRedirect',
                'expected' => route('vendor.order.index', ['vendor' => $this->vendor]),
            ],
        ] as $val) {
            $order = $this->user1->orders()->create([
                'vendor_id' => $this->vendor->id,
                'food' => 'test food',
            ]);

            $val['user']->refresh();
            $response = $this
                ->actingAs($val['user'])
                ->delete(route('vendor.order.destroy', [
                    'vendor' => $this->vendor->id,
                    'order' => $order->id,
                ]))
            ;
            call_user_func([$response, $val['fn']], $val['expected']);
        }
    }

    public function testValidCreation()
    {
        $this->user1->refresh();
        $this->actingAs($this->user1);
        $response = $this->get(route('vendor.order.show', [
            'vendor' => $this->vendor,
            'order' => $this->order,
        ]));

        // $response->assertStatus(200);

        $response = $this
            ->post(
            route(
                'vendor.order.store',
                ['vendor' => $this->vendor]
            ));

        echo $response->getContent();
    }
}

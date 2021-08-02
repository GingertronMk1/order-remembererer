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
            // Create an Order for User 1
            $order = $this->user1->orders()->create([
                'vendor_id' => $this->vendor->id,
                'food' => 'test food',
            ]);

            // Refresh the current user
            $val['user']->refresh();

            // First try to update User 1's Order
            $response = $this
                ->actingAs($val['user'])
                ->put(route('vendor.order.update', [
                    'vendor' => $this->vendor->id,
                    'order' => $order->id,
                ]), ['food' => 'test food'])
            ;

            // If they are User 1 or the admin they should be able to update the Order
            // Otherwise they would get a 403
            call_user_func([$response, $val['fn']], $val['expected']);

            // Same for deleting
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

    public function testValidCreationAndUpdating()
    {
        // Pretending to be User 1
        $this->actingAs($this->user1);

        // Try to create an empty order
        $response = $this
            ->post(
                route(
                    'vendor.order.store',
                    ['vendor' => $this->vendor]
                )
            )
        ;

        // Should have errors
        $response->assertStatus(302)->assertSessionHasErrors(['food', 'drink', 'other']);

        // Try to update an order to make it empty
        $response = $this
            ->put(
                route(
                    'vendor.order.update',
                    [
                        'vendor' => $this->vendor,
                        'order' => $this->order,
                    ]
                )
            )
        ;

        // Should have errors
        $response->assertStatus(302)->assertSessionHasErrors(['food', 'drink', 'other']);

        // Now go through creating/updating orders with each individual field filled in
        // They should all be fine
        foreach ([
            ['food' => 'test food'],
            ['drink' => 'test drink'],
            ['other' => 'test other'],
        ] as $data) {
            $response = $this
                ->post(
                    route(
                        'vendor.order.store',
                        ['vendor' => $this->vendor]
                    ),
                    $data
                )
            ;

            $response->assertRedirect(route('vendor.order.index', ['vendor' => $this->vendor]));

            $response = $this
                ->put(
                    route(
                        'vendor.order.update',
                        [
                            'vendor' => $this->vendor,
                            'order' => $this->order,
                        ]
                    ),
                    $data
                )
            ;

            $response->assertRedirect(route('vendor.order.index', ['vendor' => $this->vendor]));
        }
    }
}

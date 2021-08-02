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
class CuisineTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testUsersMustBeOnSameTeamToLookAtEachOthersOrders()
    {
        $vendor = Vendor::factory()->create();
        [$user1, $user2] = User::factory(2)->withPersonalTeam()->create();

        $order = $user1->orders()->create([
            'vendor_id' => $vendor->id,
            'ford' => 'test food',
        ]);

        echo $order->user_id.PHP_EOL;

        foreach ([200 => $user1, 403 => $user2] as $expectedStatus => $user) {
            $this->actingAs($user);

            $response = $this->get(route('vendor.order.show', compact('vendor', 'order')));
            $response->assertStatus($expectedStatus);
        }

        $team = Team::factory()->create();

        $team->users()->attach([$user1->id, $user2->id], ['role' => 'editor']);

        $user1 = $user1->fresh();       // Grab fresh DB copies of the users
        $user2 = $user2->fresh();

        foreach ([$user1, $user2] as $user) {
            $this->actingAs($user);

            $response = $this->get(route('vendor.order.show', compact('vendor', 'order')));
            $response->assertStatus(200);
        }
    }
}

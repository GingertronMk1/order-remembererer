<?php

namespace Tests\Feature;

use App\Models\Purchase;
use App\Models\Team;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class PurchaseTest extends TestCase
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
        $this->team->user_id = $this->admin->id;
        $this->team->save();
        $this->order = $this->user1->orders()->create([
            'vendor_id' => $this->vendor->id,
            'food' => 'test food',
        ]);
    }

    public function testValidation()
    {
        $this->actingAs($this->admin);

        // Test empty input
        $response = $this->post(route('purchase.store'), []);
        $response->assertSessionHasErrors([
            'vendor_id', 'expires_at', 'user_ids',
        ]);

        // Test expiry date before now
        $response = $this->post(route('purchase.store'), [
            'expires_at' => Carbon::now()->subDay()->toISOString(),
        ]);
        $response->assertSessionHasErrors([
            'vendor_id', 'expires_at', 'user_ids',
        ]);

        // Test correct expiry date
        $response = $this->post(route('purchase.store'), [
            'expires_at' => Carbon::now()->addDay()->toISOString(),
        ]);
        $response->assertSessionHasErrors([
            'vendor_id', 'user_ids',
        ]);

        // Test correct expiry and vendor
        $response = $this->post(route('purchase.store'), [
            'vendor_id' => $this->vendor->id,
            'expires_at' => Carbon::now()->addDay()->toISOString(),
        ]);

        $response->assertSessionHasErrors([
            'user_ids',
        ]);

        // Test correct expiry and vendor and wrong users
        $response = $this->post(route('purchase.store'), [
            'vendor_id' => $this->vendor->id,
            'expires_at' => Carbon::now()->addDay()->toISOString(),
            'user_ids' => [
                $this->user1->id,
                $this->user2->id,
            ],
        ]);
        $response->assertSessionHasErrors([
            'user_ids.*',
        ]);

        $this->team->users()->attach([
            $this->user1->id => ['role' => 'editor'],
            $this->user2->id => ['role' => 'editor'],
        ]);
        $this->admin->switchTeam($this->team);

        // Test correct expiry and vendor and users
        $response = $this->post(route('purchase.store'), [
            'vendor_id' => $this->vendor->id,
            'expires_at' => Carbon::now()->addDay()->toISOString(),
            'user_ids' => [
                $this->user1->id,
                $this->user2->id,
            ],
        ]);
        $response->assertSessionHasNoErrors();
    }

    public function testInvitations()
    {
        $this->actingAs($this->admin);

        $purchase = Purchase::create([
            'vendor_id' => $this->vendor->id,
            'expires_at' => Carbon::now()->addHour(),
        ]);

        $purchase_invitation = $purchase->invitations()->create([
            'user_id' => $this->user1->id,
        ]);

        $response = $this->get(route('purchase-invitation.edit', compact('purchase_invitation')));
        $response->assertStatus(200);

        $response = $this->get(route('purchase-invitation.edit', compact('purchase_invitation')));
        $response->assertStatus(403);

        $purchase = Purchase::create([
            'vendor_id' => $this->vendor->id,
            'expires_at' => Carbon::now()->subHour(),
        ]);

        $purchase_invitation = $purchase->invitations()->create([
            'user_id' => $this->user1->id,
        ]);

        $response = $this->get(route('purchase-invitation.edit', compact('purchase_invitation')));
        $response->assertStatus(403);
    }
}

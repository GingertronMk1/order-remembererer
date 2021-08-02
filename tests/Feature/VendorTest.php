<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VendorTest extends TestCase
{
    private $admin;
    private $user1;
    private $user2;
    private $vendor;
    private $team;
    private $unverified;

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
        $this->unverified = User::factory()->unverified()->withPersonalTeam()->create();
    }

    public function testCreateVendors()
    {
        // Admin's fine to create vendor
        $response = $this
            ->actingAs($this->admin)
            ->post(route('vendor.store'), ['name' => 'Italian'])
        ;
        $response->assertRedirect(route('vendor.index'));

        // Verified user's fine to create vendor
        $response = $this
            ->actingAs($this->user1)
            ->post(route('vendor.store'), ['name' => 'Italian'])
        ;
        $response->assertRedirect(route('vendor.index'));

        // Unverified user's not fine to create vendor
        $response = $this
            ->actingAs($this->unverified)
            ->post(route('vendor.store'), ['name' => 'Italian'])
        ;
        $response->assertStatus(403);
    }

    public function testUpdateVendors()
    {
        $vendor = $this->user1->vendors()->create([
            'name' => 'Italian',
        ]);

        // Admin's fine to update vendor
        $response = $this
            ->actingAs($this->admin)
            ->put(route('vendor.update', compact('vendor')), ['name' => 'Italianer'])
        ;
        $response->assertRedirect(route('vendor.index'));

        // Creator's fine to update vendor
        $response = $this
            ->actingAs($this->user1)
            ->put(route('vendor.update', compact('vendor')), ['name' => 'Italianer'])
        ;
        $response->assertRedirect(route('vendor.index'));

        // Other user's not fine to update vendor
        $response = $this
            ->actingAs($this->user2)
            ->put(route('vendor.update', compact('vendor')), ['name' => 'Italianer'])
        ;
        $response->assertStatus(403);
    }

    public function testDeleteVendors() {
        $response = $this->actingAs($this->user1)->delete(route('vendor.destroy', ['vendor' => $this->vendor]));
        $response->assertStatus(403);
        $response = $this->actingAs($this->user2)->delete(route('vendor.destroy', ['vendor' => $this->vendor]));
        $response->assertStatus(403);
        $response = $this->actingAs($this->unverified)->delete(route('vendor.destroy', ['vendor' => $this->vendor]));
        $response->assertStatus(403);
        $response = $this->actingAs($this->admin)->delete(route('vendor.destroy', ['vendor' => $this->vendor]));
        $response->assertStatus(302);
    }

    public function testVendorValidation()
    {
        $this->actingAs($this->admin);

        // Creating new Vendors
        $response = $this->post(route('vendor.store'), []);
        $response->assertSessionHasErrors(['name']);

        $response = $this->post(route('vendor.store'), ['description' => 1]);
        $response->assertSessionHasErrors(['name']);

        $response = $this->post(route('vendor.store'), ['name' => 1]);
        $response->assertSessionHasErrors(['name']);

        $response = $this->post(route('vendor.store'), ['name' => 'test', 'description' => 1]);
        $response->assertSessionHasErrors(['description']);

        $response = $this->post(route('vendor.store'), ['name' => 'test', 'description' => 'testing']);
        $response->assertSessionHasNoErrors();

        // Updating an exsiting Vendor
        $response = $this->put(route('vendor.update', ['vendor' => $this->vendor]), []);
        $response->assertSessionHasErrors(['name']);

        $response = $this->put(route('vendor.update', ['vendor' => $this->vendor]), ['description' => 1]);
        $response->assertSessionHasErrors(['name']);

        $response = $this->put(route('vendor.update', ['vendor' => $this->vendor]), ['name' => 1]);
        $response->assertSessionHasErrors(['name']);

        $response = $this->put(route('vendor.update', ['vendor' => $this->vendor]), ['name' => 'test', 'description' => 1]);
        $response->assertSessionHasErrors(['description']);

        $response = $this->put(route('vendor.update', ['vendor' => $this->vendor]), ['name' => 'test', 'description' => 'testing']);
        $response->assertSessionHasNoErrors();
    }


}

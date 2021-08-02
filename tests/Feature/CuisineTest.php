<?php

namespace Tests\Feature;

use App\Models\Cuisine;
use App\Models\User;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class CuisineTest extends TestCase
{
    private $admin;
    private $user1;
    private $user2;
    private $unverified;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->withPersonalTeam()->create();
        [$this->user1, $this->user2] = User::factory(2)->withPersonalTeam()->create();
        $this->unverified = User::factory()->unverified()->withPersonalTeam()->create();
        $this->cuisine = Cuisine::factory()->create();
    }

    public function testCreateCuisines()
    {
        // Admin's fine to create cuisine
        $response = $this
            ->actingAs($this->admin)
            ->post(route('cuisine.store'), ['name' => 'Italian'])
        ;
        $response->assertRedirect(route('cuisine.index'));

        // Verified user's fine to create cuisine
        $response = $this
            ->actingAs($this->user1)
            ->post(route('cuisine.store'), ['name' => 'Italian'])
        ;
        $response->assertRedirect(route('cuisine.index'));

        // Unverified user's not fine to create cuisine
        $response = $this
            ->actingAs($this->unverified)
            ->post(route('cuisine.store'), ['name' => 'Italian'])
        ;
        $response->assertStatus(403);
    }

    public function testCuisineValidation()
    {
        $this->actingAs($this->admin);

        // Creating new Cuisines
        $response = $this->post(route('cuisine.store'), []);
        $response->assertSessionHasErrors(['name']);

        $response = $this->post(route('cuisine.store'), ['description' => 1]);
        $response->assertSessionHasErrors(['name']);

        $response = $this->post(route('cuisine.store'), ['name' => 1]);
        $response->assertSessionHasErrors(['name']);

        $response = $this->post(route('cuisine.store'), ['name' => 'test', 'description' => 1]);
        $response->assertSessionHasErrors(['description']);

        $response = $this->post(route('cuisine.store'), ['name' => 'test', 'description' => 'testing']);
        $response->assertSessionHasNoErrors();

        // Updating an exsiting Cuisine
        $response = $this->put(route('cuisine.update', ['cuisine' => $this->cuisine]), []);
        $response->assertSessionHasErrors(['name']);

        $response = $this->put(route('cuisine.update', ['cuisine' => $this->cuisine]), ['description' => 1]);
        $response->assertSessionHasErrors(['name']);

        $response = $this->put(route('cuisine.update', ['cuisine' => $this->cuisine]), ['name' => 1]);
        $response->assertSessionHasErrors(['name']);

        $response = $this->put(route('cuisine.update', ['cuisine' => $this->cuisine]), ['name' => 'test', 'description' => 1]);
        $response->assertSessionHasErrors(['description']);

        $response = $this->put(route('cuisine.update', ['cuisine' => $this->cuisine]), ['name' => 'test', 'description' => 'testing']);
        $response->assertSessionHasNoErrors();
    }

    public function testUpdateCuisines()
    {
        $cuisine = $this->user1->cuisines()->create([
            'name' => 'Italian',
        ]);

        // Admin's fine to update cuisine
        $response = $this
            ->actingAs($this->admin)
            ->put(route('cuisine.update', compact('cuisine')), ['name' => 'Italianer'])
        ;
        $response->assertRedirect(route('cuisine.index'));

        // Creator's fine to update cuisine
        $response = $this
            ->actingAs($this->user1)
            ->put(route('cuisine.update', compact('cuisine')), ['name' => 'Italianer'])
        ;
        $response->assertRedirect(route('cuisine.index'));

        // Other user's not fine to update cuisine
        $response = $this
            ->actingAs($this->user2)
            ->put(route('cuisine.update', compact('cuisine')), ['name' => 'Italianer'])
        ;
        $response->assertStatus(403);
    }
}

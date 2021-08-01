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
    /**
     * A basic feature test example.
     */
    public function testCuisinesMustBeLoggedIn()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $cuisine = Cuisine::factory()->create();
        $modifiers = [
            'index' => [],
            'store' => [],
            'create' => [],
            'show' => compact('cuisine'),
            'update' => compact('cuisine'),
            'edit' => compact('cuisine'),
            'destroy' => compact('cuisine'),
        ];
        foreach ($modifiers as $modifier => $params) {
            $response = $this->get(route('cuisine.'.$modifier, $params));

            $response->assertRedirect(route('login'));
        }

        $this->actingAs($user);

        foreach ($modifiers as $modifier => $params) {
            $response = $this->get(route('cuisine.'.$modifier, $params));

            $response->assertStatus(200);
        }
    }
}

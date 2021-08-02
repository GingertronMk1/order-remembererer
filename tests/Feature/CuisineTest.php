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
        $cuisine = Cuisine::factory()->create();

        $tests = [
            'index' => function () {
                return $this->get(route('cuisine.index'));
            },
            'create' => function () {
                return $this->get(route('cuisine.create'));
            },
            'store' => function () {
                return $this->post(route('cuisine.store'), []);
            },
            'show' => function () use ($cuisine) {
                return $this->get(route('cuisine.show', compact('cuisine')));
            },
            'edit' => function () use ($cuisine) {
                return $this->get(route('cuisine.edit', compact('cuisine')));
            },
            'update' => function () use ($cuisine) {
                return $this->put(route('cuisine.update', compact('cuisine')), []);
            },
            'destroy' => function () use ($cuisine) {
                return $this->delete(route('cuisine.destroy', compact('cuisine')));
            },
        ];

        foreach ($tests as $test) {
            $response = $test();
            echo $response->getContent().PHP_EOL.'---'.PHP_EOL;
            $response->assertRedirect(route('login'));
        }

        $user = User::factory()->withPersonalTeam()->create();
        echo print_r($user, true).PHP_EOL.'---'.PHP_EOL;
        $this->actingAs($user);

        foreach ($tests as $test) {
            $response = $test();
            $response->assertStatus(200);
        }
    }
}

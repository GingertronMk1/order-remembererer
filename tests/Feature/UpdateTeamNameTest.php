<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UpdateTeamNameTest extends TestCase
{
    public function testTeamNamesCanBeUpdated()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $response = $this->put('/teams/'.$user->currentTeam->id, [
            'name' => 'Test Team',
        ]);

        $this->assertCount(1, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->currentTeam->fresh()->name);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class RemoveTeamMemberTest extends TestCase
{


    public function testTeamMembersCanBeRemovedFromTeams()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'admin']
        );

        $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id);

        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function testOnlyTeamOwnerCanRemoveTeamMembers()
    {
        $user = User::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$user->id);

        $response->assertStatus(403);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @internal
 * @coversNothing
 */
class UpdateTeamMemberRoleTest extends TestCase
{


    public function testTeamMemberRolesCanBeUpdated()
    {
        $this->actingAs($user = User::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'admin']
        );

        $response = $this->put('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id, [
            'role' => 'editor',
        ]);

        $this->assertTrue($otherUser->fresh()->hasTeamRole(
            $user->currentTeam->fresh(),
            'editor'
        ));
    }

    public function testOnlyTeamOwnerCanUpdateTeamMemberRoles()
    {
        $user = User::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = User::factory()->create(),
            ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $response = $this->put('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id, [
            'role' => 'editor',
        ]);

        $this->assertTrue($otherUser->fresh()->hasTeamRole(
            $user->currentTeam->fresh(),
            'admin'
        ));
    }
}

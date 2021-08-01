<?php

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAdminUser extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $user = new User();
        $user->name = 'ADMIN';
        $user->email = 'jackellis1504+order-remembererer@gmail.com';
        $user->password = bcrypt('P4ssWord!');
        $user->email_verified_at = now();
        $user->admin = true;
        $user->save();

        $team = new Team();
        $team->name = 'TEAM ADMIN';
        $team->user_id = $user->id;
        $team->personal_team = false;
        $team->save();
        $team->users()->attach($user);

        $user->current_team_id = $team->id;
        $user->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('admin_user');
    }
}

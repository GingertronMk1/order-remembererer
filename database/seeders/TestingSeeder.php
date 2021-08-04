<?php

namespace Database\Seeders;

use App\Models\Cuisine;
use App\Models\Order;
use App\Models\Team;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class TestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::factory(5)->has(
            User::factory()->withPersonalTeam()->count(5)
        )->create([
            'user_id' => User::factory()->withPersonalTeam()->create()->id
        ]);
        User::get()->each(function(User $user) {
            $user->switchTeam($user->allTeams()->first());
        });

        Vendor::factory(20)->has(
            Cuisine::factory()->count(3)
        )->create();

        Order::factory(100)->create();
    }
}

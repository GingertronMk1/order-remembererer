<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\PurchaseInvitation;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Purchase::factory()->expiryPassed()->hasInvitations(4)->create();
    }
}

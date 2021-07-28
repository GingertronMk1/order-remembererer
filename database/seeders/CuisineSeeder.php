<?php

namespace Database\Seeders;

use App\Models\Cuisine;
use Illuminate\Database\Seeder;

class CuisineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        if (0 === Cuisine::count()) {
            $names = [
                'Fusion cuisine',
                'Haute cuisine',
                'Nouvelle cuisine',
                'Vegan cuisine',
                'Vegetarian cuisine',
            ];

            foreach ($names as $name) {
                $cuisine = new Cuisine(compact('name'));
                $cuisine->system = true;
                $cuisine->save();
            }
        }
    }
}

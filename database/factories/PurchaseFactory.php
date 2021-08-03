<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Purchase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vendor_id' => Vendor::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
            'expires_at' => Carbon::now()->addHours($this->faker->randomDigitNotNull())
        ];
    }
}

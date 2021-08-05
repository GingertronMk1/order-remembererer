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
        $vendor_id = Vendor::pluck('id')->random();
        $user_id = User::pluck('id')->random();

        return [
            'vendor_id' => $vendor_id,
            'user_id' => $user_id,
            'expires_at' => Carbon::now()->addHours($this->faker->randomDigitNotNull()),
        ];
    }

    public function expiryPassed()
    {
        return $this->state(function (array $attributes) {
            return [
                'expires_at' => Carbon::now(),
            ];
        });
    }

    public function forUser($user_id)
    {
        return $this->state(function (array $attributes) use ($user_id) {
            return compact('user_id');
        });
    }
}

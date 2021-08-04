<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $i = 0;

        $user_id = User::pluck('id')->random();
        $vendor_id = Vendor::pluck('id')->random();
        while(Order::where('user_id', $user_id)->where('vendor_id', $vendor_id)->count()) {
            $user_id = User::pluck('id')->random();
            $vendor_id = Vendor::pluck('id')->random();
        }

        return [
            'user_id' => $user_id,
            'vendor_id' => $vendor_id,
            'food' => $this->faker->word(),
            'drink' => $this->faker->word(),
            'other' => $this->faker->word(),
        ];
    }
}

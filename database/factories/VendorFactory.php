<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vendor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->paragraphs(3, true),
            'address' => $this->faker->address(),
            'website' => $this->faker->url(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}

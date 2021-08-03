<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\PurchaseInvitation;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseInvitationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseInvitation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $purchase = Purchase::get()->random();

        return [
            'purchase_id' => $purchase->id,
            'user_id' => $purchase->user->currentTeam->users->random()->id,
            'accepted' => [
                'food' => $this->faker->boolean(),
                'drink' => $this->faker->boolean(),
                'other' => $this->faker->boolean(),
            ],
        ];
    }
}

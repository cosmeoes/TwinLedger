<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ledger>
 */
class LedgerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'concept' => $this->faker->sentence(),
            'amount' => $this->faker->numberBetween(10, 3000),
            'lender_id' => User::factory(),
            'debtor_id' => User::factory(),
        ];
    }
}

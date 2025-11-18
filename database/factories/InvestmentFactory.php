<?php

namespace Database\Factories;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Investment>
 */
class InvestmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Investment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'operator' => $this->faker->randomElement(Investment::getOperators()),
            'investment_type' => $this->faker->randomElement(Investment::getInvestmentTypes()),
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'id_number' => $this->faker->unique()->numerify('##########'),
            'id_photo' => 'investments/id_photos/' . $this->faker->uuid . '.jpg',
            'transaction_phone' => $this->faker->phoneNumber,
            'amount' => $this->faker->numberBetween(10000, 1000000),
            'transaction_proof' => 'investments/transaction_proofs/' . $this->faker->uuid . '.jpg',
            'status' => $this->faker->randomElement(Investment::getStatuses()),
            'admin_notes' => $this->faker->optional()->sentence,
        ];
    }
}

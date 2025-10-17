<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName,
            'prenom' => $this->faker->firstName,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'telephone' => $this->faker->phoneNumber,
            'adresse' => $this->faker->address,
            'date_naissance' => $this->faker->date('Y-m-d', '-18 years'),
            'lieu_naissance' => $this->faker->city,
            'nationalite' => $this->faker->country,
            'profession' => $this->faker->jobTitle,
            'piece_identite' => $this->faker->randomElement(['CNI', 'Passeport', 'Permis']),
            'numero_piece' => $this->faker->unique()->numerify('##########'),
            'date_delivrance' => $this->faker->date('Y-m-d', '-5 years'),
            'lieu_delivrance' => $this->faker->city,
            'notes' => $this->faker->sentence,
            'password' => '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'role' => 'client',
            'statut' => false,
            'code_utilisateur' => 'CLI-'.str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
        ];
    }

    /**
     * Indicate that the client is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => true,
            'date_validation' => now(),
            'valide_par' => 1, // Assuming admin user has ID 1
        ]);
    }

    /**
     * Indicate that the client is unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => false,
            'date_validation' => null,
            'valide_par' => null,
        ]);
    }
}

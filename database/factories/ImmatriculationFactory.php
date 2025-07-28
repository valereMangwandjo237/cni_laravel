<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Immatriculation>
 */
class ImmatriculationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'prenom' => $this->faker->firstName(),
            'date_naissance' => $this->faker->date('Y-m-d', '2005-07-29'), // date avant aujourd'hui
            'lieu_naissance' => $this->faker->city(),
            'numero_cni' => strtoupper($this->faker->bothify('????##??##')), // Exemple : AB123CD45
            'status' => $this->faker->randomElement([0, 1, 2]),
        ];
    }
}

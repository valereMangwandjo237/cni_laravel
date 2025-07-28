<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Définir les paths disponibles pour chaque type
        $recto_paths = [
            'cni/vcNEiRk0Ih2EJxOhsZ9cRSRFEXWkrPq1WqlWOfXM.jpg',
            'cni/aCncLgeAoEsHxYVzJPoZgtZQQgXEX6bTKwuGeZJO.jpg',
            'cni/MsvmPII3mFxGt3klY9cf4LQ8PzvxxKiF6emBm1jI.jpg'
        ];
        $verso_paths = [
            'cni/COVyQflYUZAdnDvE666drXyrsfg5nSPz6dA54uqR.jpg',
            'cni/gPqKq7G1TW9u5MSm9B5tQhUZzQN3xhAbT75kgQiy.jpg',
            'cni/F2IfDRkyS2fUXStJanaXJGBFivqTeiQJSdOkxNbX.jpg'
        ];

        // Choisir un type au hasard
        $type = $this->faker->randomElement(['recto', 'verso']);

        // Sélectionner le path en fonction du type
        $path = $type === 'recto'
            ? $this->faker->randomElement($recto_paths)
            : $this->faker->randomElement($verso_paths);

        return [
            'immat_id' => $this->faker->numberBetween(5, 24),
            'type' => $type,
            'path' => $path,
        ];
    }
}

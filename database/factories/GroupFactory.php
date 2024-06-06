<?php

namespace Database\Factories;

use App\Models\Classifier;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Group>
 */
class GroupFactory extends Factory
{
    protected $model = Group::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classifier = Classifier::inRandomOrder()->first();
        return [
            'code' => $this->faker->unique()->numerify('###'), // Código único generado aleatoriamente
            'name_group' => $this->faker->word, // Nombre generado aleatoriamente
            'state' => $this->faker->randomElement(['activo', 'inactivo']), // Estado válido aleatorio
            'classifier_id' => $classifier->id, // ID de un Classifier existente
        ];
    }
}

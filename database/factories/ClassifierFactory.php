<?php

namespace Database\Factories;

use App\Models\Classifier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classifier>
 */
//Clasificador a partir del 30000 Materiales y Suministros
//Los Clasificadores son: 31000,32000,33000,34000,39000 
class ClassifierFactory extends Factory
{
    protected $model = Classifier::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code_class' => $this->faker->unique()->numerify('###'),
            'nombre' => $this->faker->word,
            'description' => $this->faker->sentence,
        ];
    }
}

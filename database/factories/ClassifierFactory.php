<?php

namespace Database\Factories;

use App\Models\Classifier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classifier>
 */
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

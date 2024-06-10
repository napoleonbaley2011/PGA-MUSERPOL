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
        $classifier = Classifier::inRandomOrder()->first() ?: Classifier::factory()->create();
        return [
            'code' => $this->faker->unique()->numerify('###'), 
            'name_group' => $this->faker->word, 
            'state' => $this->faker->randomElement(['1', '0']),
            'classifier_id' => $classifier->id, 
        ];
    }
}

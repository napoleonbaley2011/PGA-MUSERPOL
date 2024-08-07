<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    protected $model = Material::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $group = Group::inRandomOrder()->first() ?: Group::factory()->create();
        return [
            'code_material' => $this->faker->unique()->numerify('#######'),
            'description' => $this->faker->word,
            'unit_material' => $this->faker->word,
            'state' => $this->faker->randomElement(['Inhabilitado', 'Habilitado']),
            'stock' => $this->faker->randomElement(['0', '10']),
            'min' => $this->faker->randomElement(['5', '10']),
            'barcode' => $this->faker->numerify('####'),
            'type' => $this->faker->randomElement(['Almacen', 'Caja Chica']),
            'group_id' => $group->id,
        ];
    }
}

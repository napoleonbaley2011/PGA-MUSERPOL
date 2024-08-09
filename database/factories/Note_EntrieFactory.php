<?php

namespace Database\Factories;

use App\Models\Note_Entrie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Note_EntrieFactory extends Factory
{
    protected $model = Note_Entrie::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number_note' => $this->faker->randomNumber(5),
            'invoice_number' => $this->faker->randomNumber(5),
            'delivery_date' => $this->faker->date(),
            'state' => $this->faker->randomElement(['Eliminado', 'Creado']),
            'invoice_auth' => $this->faker->unique()->randomNumber(10),
            'user_register' => $this->faker->randomNumber(5),
            'observation' => $this->faker->sentence(),
            'type_id' => $this->faker->randomElement([1, 2]),
        ];
    }
}

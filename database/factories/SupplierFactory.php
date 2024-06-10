<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->word,
            'nit'=>$this->faker->unique()->numerify('######'),
            'cellphone'=>$this->faker->unique()->numerify('######'),
            'sales_representative'=>$this->faker->word,
            'address'=>$this->faker->word,
            'email'=> $this->faker->unique()->safeEmail,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Material;
use App\Models\Note_Entrie;
use App\Models\Supplier;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Note_EntrieFactory extends Factory
{
    protected $model = Note_Entrie::class;
    private static $noteNumber = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number_note' => self::$noteNumber++, // Correlativo
            'invoice_number' => $this->faker->unique()->numberBetween(100000, 999999), // Número de factura de 6 dígitos
            'delivery_date' => Carbon::create(2024, 8, rand(1, 31)), // Fechas en agosto de 2024
            'state' => 'Creado',
            'invoice_auth' => $this->faker->unique()->numberBetween(100000, 999999),
            'user_register' => 25,
            'observation' => $this->faker->sentence,
            'type_id' => 1,
            'suppliers_id' => Supplier::inRandomOrder()->first()->id,
            'name_supplier' => Supplier::inRandomOrder()->first()->name,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Note_Entrie $noteEntrie) {
            $priceOptions = [36.6, 36.2, 36.4];

            $materials = Material::inRandomOrder()->take(rand(5, 10))->get();
            foreach ($materials as $material) {
                $amountEntries = rand(1, 100);
                $material->stock += $amountEntries;
                $material->state = 'Habilitado';
                $material->save();

                $costUnit = $priceOptions[array_rand($priceOptions)];

                $noteEntrie->materials()->attach($material->id, [
                    'amount_entries' => $amountEntries,
                    'request' => $amountEntries,
                    'cost_unit' => $costUnit,
                    'cost_total' => $amountEntries * $costUnit,
                    'name_material' => $material->description,
                ]);
            }
        });
    }
}

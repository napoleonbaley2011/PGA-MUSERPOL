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
    private static $startDate;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        // Set a base start date for the first note
        if (!self::$startDate) {
            self::$startDate = Carbon::create(2024, 2, 1);  // Base start date: 1st February 2024
        }
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Set the delivery date by adding days based on the note number
        $deliveryDate = self::$startDate->copy()->addDays(self::$noteNumber - 1);

        return [
            'number_note' => self::$noteNumber++,
            'invoice_number' => $this->faker->unique()->numberBetween(100000, 999999),
            'delivery_date' => $deliveryDate, // Correlative date based on note number
            'state' => 'Creado',
            'invoice_auth' => $this->faker->unique()->numberBetween(100000, 999999),
            'user_register' => 25,
            'observation' => $this->faker->sentence,
            'type_id' => 1,
            'suppliers_id' => Supplier::inRandomOrder()->first()->id,
            'name_supplier' => Supplier::inRandomOrder()->first()->name,
            'management_id' => 1,
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

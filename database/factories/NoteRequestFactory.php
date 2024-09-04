<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Material;
use App\Models\NoteRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NoteRequest>
 */
class NoteRequestFactory extends Factory
{
    protected $model = NoteRequest::class;
    private static $requestNumber = 1;
    private static $startDate;

    public function __construct(...$args)
    {
        parent::__construct(...$args);
        // Set a base start date for the first request
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
        // Set the request date by adding days based on the request number
        $requestDate = self::$startDate->copy()->addDays(self::$requestNumber - 1);

        return [
            'number_note' => self::$requestNumber++,  // Incrementing request number
            'state' => 'En Revision',
            'observation' => $this->faker->sentence,
            'user_register' => Employee::where('active', true)->inRandomOrder()->first()->id,
            'request_date' => $requestDate,  // Correlative request date
            'management_id' => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (NoteRequest $noteRequest) {
            $materials = Material::inRandomOrder()->take(rand(5, 10))->get();
            foreach ($materials as $material) {
                $noteRequest->materials()->attach($material->id, [
                    'amount_request' => rand(1, 10),
                    'name_material' => $material->description,
                    'delivered_quantity' => 0,
                ]);
            }
        });
    }
}

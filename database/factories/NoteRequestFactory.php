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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number_note' => self::$requestNumber++,
            'state' => 'En Revision',
            'observation' => $this->faker->sentence,
            'user_register' => Employee::where('active', true)->inRandomOrder()->first()->id,
            'request_date' => Carbon::create(2024, 8, rand(1, 31)),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (NoteRequest $noteRequest) {
            $materials = Material::inRandomOrder()->take(rand(5, 10))->get();
            foreach ($materials as $material) {
                $noteRequest->materials()->attach($material->id, [
                    'amount_request' => rand(1, 100),
                    'name_material' => $material->description,
                ]);
            }
        });
    }
}

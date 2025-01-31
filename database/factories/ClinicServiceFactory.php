<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\ClinicService;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClinicService>
 */
class ClinicServiceFactory extends Factory
{
    protected $model = ClinicService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'color' => $this->faker->hexColor(),
            'clinic_id' => Clinic::factory()->create()->id,
            'organization_id' => Organization::factory()->create()->id,
        ];
    }
}

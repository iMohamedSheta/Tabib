<?php

namespace Database\Factories;

use App\Enums\Clinic\ClinicTypeEnum;
use App\Generators\ClinicCodeGenerator;
use App\Models\Organization;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clinic>
 */
class ClinicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plan = Plan::first() ?? Plan::factory()->create();

        return [
            'code' => ClinicCodeGenerator::generate(),
            'name' => fake()->name(),
            'type' => ClinicTypeEnum::DEFAULT,
            'status' => 'new',
            'plan_id' => $plan->id,
            'lease_started_at' => now(),
            'lease_expired_at' => now()->addMonth(),
            'location' => fake()->address(),
            'organization_id' => Organization::factory()->create()->id,
        ];
    }
}

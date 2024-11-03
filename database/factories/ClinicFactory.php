<?php

namespace Database\Factories;

use App\Enums\Clinic\ClinicTypeEnum;
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
            'billing_code' => random_int(100000, 999999),
            'name' => fake()->name(),
            'type' => ClinicTypeEnum::NORMAL,
            'status' => 'new',
            'plan_id' => $plan->id,
            'lease_started_at' => now(),
            'lease_expired_at' => now()->addMonth(),
            'location' => fake()->address(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClinicAdmin>
 */
class ClinicAdminFactory extends Factory
{
    protected $model = ClinicAdmin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'clinic_id' => Clinic::factory()->create()->id,
            'type' => ClinicAdmin::TYPE_SUPER_ADMIN,
        ];
    }
}

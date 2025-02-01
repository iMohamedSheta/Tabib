<?php

namespace Database\Factories;

use App\Models\ClinicAdmin;
use App\Models\Organization;
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
        $org_id = Organization::factory()->create()->id;

        return

            [
                'user_id' => User::factory()->create([
                    'organization_id' => $org_id,
                ])->id,
                'type' => ClinicAdmin::TYPE_SUPER_ADMIN,
                'organization_id' => $org_id,
            ];
    }
}

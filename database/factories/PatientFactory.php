<?php

namespace Database\Factories;

use App\Formatters\AgeFormatter;
use App\Generators\PUIDGenerator;
use App\Models\Clinic;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        $organization = Organization::factory()->create();
        $user = User::factory()->create(['organization_id' => $organization->id]);
        $clinic = Clinic::factory()->create(['organization_id' => $organization->id]);
        $age = $this->faker->numberBetween(1, 100);

        return [
            'age' => $age,
            'birth_date' => AgeFormatter::date($age),
            'puid' => PUIDGenerator::generate(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'clinic_id' => $clinic->id,
            'user_id' => $user->id,
            'organization_id' => $organization->id,
        ];
    }
}

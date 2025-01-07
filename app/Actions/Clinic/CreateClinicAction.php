<?php

namespace App\Actions\Clinic;

use App\DTOs\Auth\RegisterUserDTO;
use App\Enums\User\UserRoleEnum;
use App\Generators\OrganizationBillingCodeGenerator;
use App\Models\ClinicAdmin;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateClinicAction
{
    public function handle(RegisterUserDTO $registerUserDTO, array $clinicData): void
    {
        try {
            DB::beginTransaction();

            // Generate unique billing code
            $code = OrganizationBillingCodeGenerator::generate();

            // Create Organization
            $organization = Organization::create([
                'name' => $clinicData['name'],
                'billing_code' => $code,
            ]);

            // Create Clinic under Organization
            $organization->clinics()->create([
                'code' => $code,
                'name' => $clinicData['name'],
                'type' => $clinicData['type'],
                'plan_id' => 1,
                'lease_expired_at' => now()->addMonth(),
                'lease_started_at' => now(),
            ]);

            // Create User and associate with the organization
            $user = User::create(array_merge($registerUserDTO->userData(), [
                'organization_id' => $organization->id,
            ]));

            // Create ClinicAdmin for the user
            $user->clinicAdmin()->create([
                'organization_id' => $organization->id,
                'type' => ClinicAdmin::TYPE_SUPER_ADMIN,
            ]);

            DB::commit();

            Auth::login($user);

            redirect(UserRoleEnum::authRedirectRouteBasedOnType());
        } catch (\Exception $exception) {
            DB::rollBack();

            dd($exception);
        }
    }
}

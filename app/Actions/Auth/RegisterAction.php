<?php

namespace App\Actions\Auth;

use App\Enums\User\UserRoleEnum;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use IMohamedSheta\Todo\Attributes\TODO;
use IMohamedSheta\Todo\Enums\Priority;

#[TODO]
class RegisterAction
{
    #[TODO('Create a new clinic and clinic admin', Priority::LOW)]
    public function handle(User $user, array $clinicData): void
    {
        try {
            DB::beginTransaction();

            $clinic = $this->createClinic($clinicData);

            $this->createClinicAdmin($clinic, $user->id);

            DB::commit();

            Auth::login($user);

            redirect(UserRoleEnum::authRedirectRouteBasedOnType());
        } catch (\Exception) {
            DB::rollBack();
        }
    }

    #[TODO('Generate a unique billing code for the clinic', Priority::HIGH)]
    private function createClinicAdmin(Clinic $clinic, int $userId): ClinicAdmin
    {
        return ClinicAdmin::create([
            'user_id' => $userId,
            'clinic_id' => $clinic->id,
            'type' => ClinicAdmin::TYPE_SUPER_ADMIN,
        ]);
    }

    #[TODO('Create a new clinic', Priority::CRITICAL)]
    private function createClinic(array $clinicData): Clinic
    {
        return Clinic::create([
            'billing_code' => $this->generateBillingCode(),
            'name' => $clinicData['name'],
            'type' => $clinicData['type'],
            'plan_id' => 1,
            'lease_expired_at' => now()->addMonth(),
            'lease_started_at' => now(),
        ]);
    }

    private function generateBillingCode(): int
    {
        return random_int(100000, 999999);
    }
}

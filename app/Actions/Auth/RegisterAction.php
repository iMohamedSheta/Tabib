<?php

namespace App\Actions\Auth;


class RegisterAction
{
    /**
     * Create a new action instance.
     *
     * @param User $user
     * @param array $clinicData The required fields are:
     *  - 'name' (string): The name of the clinic.
     *  - 'type' (string): The type of clinic.
     */
    public function handle(User $user,array $clinicData)
    {
        try
        {
            DB::beginTransaction();

            $clinic = $this->createClinic($clinicData);

            $this->createClinicAdmin($clinic, $user->id);

            DB::commit();

            Auth::login($user);

            redirect()->route('dashboard');

        } catch (\Exception $e) {
            DB::rollBack();

            dd($e);
        }
    }

    private function createClinicAdmin($clinic, $userId)
    {
        return ClinicAdmin::create([
            'user_id' => $userId,
            'clinic_id' => $clinic->id,
            'type' => ClinicAdmin::TYPE_SUPER_ADMIN
        ]);
    }

    private function createClinic(array $clinicData)
    {
        return Clinic::create([
            'billing_code' => $this->generateBillingCode(),
            'name'=> $clinicData['name'],
            'type' => $clinicData['type'],
            'plan_id' => 1,
            'lease_expired_at' => now()->addMonth(),
            'lease_started_at' => now(),
        ]);
    }

    private function generateBillingCode()
    {
        return random_int(100000, 999999);
    }
}

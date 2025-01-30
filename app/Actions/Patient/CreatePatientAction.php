<?php

namespace App\Actions\Patient;

use App\DTOs\Patient\CreatePatientDTO;
use App\Models\Patient;
use App\Models\User;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CreatePatientAction
{
    use ActionResponseTrait;

    public function handle(CreatePatientDTO $createPatientDTO): ActionResponse
    {
        try {
            if ($this->isNotAuthorized()) {
                return $this->authorizeError('غير مسموح لك باضافة المريض!!');
            }

            DB::beginTransaction();

            $user = User::create($createPatientDTO->userData());

            if ($createPatientDTO->photo) {
                $user->updateProfilePhoto($createPatientDTO->photo);
            }

            $patient = $user->patient()->create($createPatientDTO->patientData());

            $user->update(['role_id' => $patient->id]);

            DB::commit();

            return $this->success(
                message: 'تم انشاء المريض بنجاح',
                data: ['user' => $user],
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            log_error($exception);

            return $this->error('حدث خطأ في عملية أنشاء الطبيب، الرجاء المحاولة لاحقاً');
        }
    }

    private function isNotAuthorized(): bool
    {
        return !Gate::allows('create', Patient::class);
    }
}

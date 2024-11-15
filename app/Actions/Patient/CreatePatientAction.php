<?php

namespace App\Actions\Patient;

use App\DTOs\Patient\CreatePatientDTO;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;

class CreatePatientAction
{
    use ActionResponseTrait;

    public function handle(CreatePatientDTO $dto): ActionResponse
    {
        try
        {
            if ($this->isNotAuthorized()) {
                return $this->authorizeError('غير مسموح لك باضافة الطبيب!!');
            }

            DB::beginTransaction();

            $user = User::create($dto->userData());

            if ($dto->photo) {
                $user->updateProfilePhoto($dto->photo);
            }

            $user->patient()->create($dto->patientData());

            DB::commit();

            return $this->success(
                message: 'تم انشاء المريض بنجاح',
                data: ['user' => $user]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            log_error($e);
            return $this->error("حدث خطأ في عملية أنشاء الطبيب، الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized(): bool
    {
        return !Gate::allows('create', Patient::class);
    }
}

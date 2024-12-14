<?php

namespace App\Actions\Doctor;

use App\DTOs\Doctor\UpdateDoctorDTO;
use App\Helpers\Helper;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;

class UpdateDoctorAction
{
    use ActionResponseTrait;

    public function handle(Doctor $doctor, UpdateDoctorDTO $dto): ActionResponse
    {
        try
        {
            if ($this->isNotAuthorized($doctor)) {
                return $this->authorizeError('غير مسموح لك بتعديل الطبيب!!');
            }

            DB::beginTransaction();

            $doctor->user->update($dto->userData());

            if ($dto->photo) {
                $doctor->user->updateProfilePhoto($dto->photo);
            }

            $doctor->update($dto->doctorData());

            DB::commit();

            return $this->success(
                message: 'تم انشاء الطبيب بنجاح',
                data: ['doctor' => $doctor]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            log_error($e);
            return $this->error("حدث خطأ في عملية تعديل الطبيب، الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized(Doctor $doctor): bool
    {
        return !Gate::allows('update', $doctor);
    }
}

<?php

namespace App\Actions\Doctor;

use App\DTOs\Doctor\UpdateDoctorDTO;
use App\Models\Doctor;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UpdateDoctorAction
{
    use ActionResponseTrait;

    public function handle(Doctor $doctor, UpdateDoctorDTO $updateDoctorDTO): ActionResponse
    {
        try {
            if ($this->isNotAuthorized($doctor)) {
                return $this->authorizeError('غير مسموح لك بتعديل الطبيب!!');
            }

            DB::beginTransaction();

            $doctor->user->update($updateDoctorDTO->userData());

            if ($updateDoctorDTO->photo) {
                $doctor->user->updateProfilePhoto($updateDoctorDTO->photo);
            }

            $doctor->update($updateDoctorDTO->doctorData());

            DB::commit();

            return $this->success(
                message: 'تم انشاء الطبيب بنجاح',
                data: ['doctor' => $doctor],
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            log_error($exception);

            return $this->error('حدث خطأ في عملية تعديل الطبيب، الرجاء المحاولة لاحقاً');
        }
    }

    private function isNotAuthorized(Doctor $doctor): bool
    {
        return ! Gate::allows('update', $doctor);
    }
}

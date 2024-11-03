<?php

namespace App\Actions\Doctor;

use App\Collections\ActionResponseCollection;
use App\DTOs\Doctor\UpdateDoctorDTO;
use App\Helpers\Helper;
use App\Models\Doctor;
use App\Traits\ActionTraits\ActionResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UpdateDoctorAction
{
    use ActionResponse;

    public function handle(Doctor $doctor, UpdateDoctorDTO $dto): ActionResponseCollection
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
            Helper::log($e);
            return $this->error("حدث خطأ في عملية تعديل الطبيب، الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized(Doctor $doctor): bool
    {
        return !Gate::allows('update', $doctor);
    }
}

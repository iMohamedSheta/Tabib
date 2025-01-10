<?php

namespace App\Actions\Doctor;

use App\Models\Doctor;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DeleteDoctorAction
{
    use ActionResponseTrait;

    public function handle(Doctor $doctor): ActionResponse
    {
        try {
            if ($this->isNotAuthorized($doctor)) {
                return $this->authorizeError('غير مسموح لك بحذف الطبيب!!');
            }

            DB::beginTransaction();
            $doctor->user->deleteProfilePhoto();
            $doctor->user->tokens->each->delete();
            $doctor->delete();
            DB::commit();

            return $this->success(
                message: 'تم حذف الطبيب بنجاح',
                data: [],
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            log_error($exception);

            return $this->error('حدث خطأ في عملية حذف الطبيب الرجاء المحاولة لاحقاً');
        }
    }

    private function isNotAuthorized(Doctor $doctor): bool
    {
        return ! Gate::allows('delete', $doctor);
    }
}

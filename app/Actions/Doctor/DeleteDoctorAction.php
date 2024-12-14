<?php

namespace App\Actions\Doctor;

use App\Helpers\Helper;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;

class DeleteDoctorAction
{
    use ActionResponseTrait;

    public function handle(Doctor $doctor): ActionResponse
    {
        try
        {
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
                data: []
            );
        } catch (\Exception $e) {
            DB::rollBack();
            log_error($e);
            return $this->error("حدث خطأ في عملية حذف الطبيب الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized($doctor): bool
    {
        return !Gate::allows('delete', $doctor);
    }
}

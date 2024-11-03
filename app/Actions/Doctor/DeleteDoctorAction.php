<?php

namespace App\Actions\Doctor;

use App\Collections\ActionResponseCollection;
use App\Helpers\Helper;
use App\Models\Doctor;
use App\Traits\ActionTraits\ActionResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use PhpParser\Comment\Doc;

class DeleteDoctorAction
{
    use ActionResponse;
    use AuthorizesRequests;

    public function handle(Doctor $doctor): ActionResponseCollection
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
            Helper::log($e);
            return $this->error("حدث خطأ في عملية حذف الطبيب الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized($doctor): bool
    {
        return !Gate::allows('delete', $doctor);
    }
}

<?php

namespace App\Actions\Patient;

use App\Models\Patient;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DeletePatientAction
{
    use ActionResponseTrait;

    public function handle(Patient $patient): ActionResponse
    {
        try {
            if ($this->isNotAuthorized($patient)) {
                return $this->authorizeError('غير مسموح لك بحذف المريض!!');
            }

            DB::beginTransaction();
            $patient->user->deleteProfilePhoto();
            $patient->user->tokens->each->delete();
            $patient->delete();
            DB::commit();

            return $this->success(
                message: 'تم حذف المريض بنجاح',
                data: [],
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            log_error($exception);

            return $this->error('حدث خطأ في عملية حذف المريض الرجاء المحاولة لاحقاً');
        }
    }

    private function isNotAuthorized(Patient $patient): bool
    {
        return !Gate::allows('delete', $patient);
    }
}

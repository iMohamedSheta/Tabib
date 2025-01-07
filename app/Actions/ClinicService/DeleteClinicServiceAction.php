<?php

namespace App\Actions\ClinicService;

use App\Models\ClinicService;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\Gate;

class DeleteClinicServiceAction
{
    use ActionResponseTrait;

    public function handle(ClinicService $clinicService): ActionResponse
    {
        try {
            if ($this->isNotAuthorized($clinicService)) {
                return $this->authorizeError('غير مسموح لك بحذف الخدمة الطبية!!');
            }

            $clinicService->delete();

            return $this->success(
                message: 'تم حذف الخدمة الطبية بنجاح',
                data: [],
            );
        } catch (\Exception $exception) {
            log_error($exception);

            return $this->error('حدث خطأ في عملية حذف الخدمة الطبية الرجاء المحاولة لاحقاً');
        }
    }

    private function isNotAuthorized(ClinicService $clinicService): bool
    {
        return !Gate::allows('delete', $clinicService);
    }
}

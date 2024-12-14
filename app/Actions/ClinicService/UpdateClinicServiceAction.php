<?php

namespace App\Actions\ClinicService;

use App\DTOs\ClinicService\UpdateClinicServiceDTO;
use App\Models\ClinicService;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\Gate;

class UpdateClinicServiceAction
{
    use ActionResponseTrait;

    public function handle(ClinicService $clinicService, UpdateClinicServiceDTO $updateClinicServiceDTO): ActionResponse
    {
        try {
            if ($this->isNotAuthorized($clinicService)) {
                return $this->authorizeError('غير مسموح لك بتعديل الخدمة الطبية!!');
            }

            $clinicService->update(
                $updateClinicServiceDTO->clinicServiceData()
            );

            return $this->success(
                message: 'تم تعديل الخدمة الطبية بنجاح',
                data: []
            );
        } catch (\Exception $e) {
            log_error($e);
            return $this->error("حدث خطأ في عملية تعديل الخدمة الطبية الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized($clinicService): bool
    {
        return !Gate::allows('update', $clinicService);
    }
}

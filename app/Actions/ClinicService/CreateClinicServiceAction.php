<?php

namespace App\Actions\ClinicService;

use App\DTOs\ClinicService\CreateClinicServiceDTO;
use App\Models\ClinicService;
use App\Responses\ActionResponse;
use App\Traits\ActionTraits\ActionResponseTrait;
use Illuminate\Support\Facades\Gate;

class CreateClinicServiceAction
{
    use ActionResponseTrait;

    public function handle(CreateClinicServiceDTO $createClinicServiceDTO): ActionResponse
    {
        try {
            if ($this->isNotAuthorized()) {
                return $this->authorizeError('غير مسموح لك باضافة خدمة طبية!!');
            }

            $clinicService = ClinicService::create($createClinicServiceDTO->clinicServiceData());

            return $this->success(
                message: 'تم انشاء الخدمة الطبية بنجاح',
                data: ['clinic_service' => $clinicService]
            );
        } catch (\Exception $e) {
            log_error($e);
            return $this->error("حدث خطأ في عملية أنشاء الخدمة الطبية الرجاء المحاولة لاحقاً");
        }
    }

    private function isNotAuthorized(): bool
    {
        return !Gate::allows('create', ClinicService::class);
    }
}

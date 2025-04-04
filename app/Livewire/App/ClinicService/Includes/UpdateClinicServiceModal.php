<?php

namespace App\Livewire\App\ClinicService\Includes;

use App\Actions\ClinicService\UpdateClinicServiceAction;
use App\DTOs\ClinicService\UpdateClinicServiceDTO;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Http\Requests\ClinicService\UpdateClinicServiceRequest;
use App\Models\ClinicService;
use Livewire\Component;

class UpdateClinicServiceModal extends Component
{
    public $showName = 'showUpdate';

    public $withButton = false;

    public $clinics;

    public $clinicServiceId;

    public $name;

    public $price;

    public $description;

    public $color;

    public $clinic_id;

    public function mount($clinicService, array $clinics): void
    {
        $this->clinicServiceId = $clinicService->id;

        $this->name = $clinicService->name;
        $this->price = $clinicService->price;
        $this->description = $clinicService->description;
        $this->color = $clinicService->color;
        $this->clinic_id = $clinicService->clinic_id;

        $this->clinics = $clinics;
    }

    public function render()
    {
        return view('livewire.app.clinic-service.includes.update-clinic-service-modal');
    }

    public function updateClinicServiceAction(): void
    {
        $validatedData = $this->validate();
        try {
            $actionResponse = app(UpdateClinicServiceAction::class)->handle(
                ClinicService::find($this->clinicServiceId),
                new UpdateClinicServiceDTO(...$validatedData),
            );

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) {
                return;
            }

            $this->resetForm();

            $this->dispatch('updated');
        } catch (\Exception $exception) {
            log_error($exception);
            flash()->error($this->matchStatus());
        }
    }

    protected function rules(): array
    {
        return (new UpdateClinicServiceRequest(array_keys($this->clinics)))->rules();
    }

    protected function prepareForValidation($attributes): array
    {
        $attributes['clinic_id'] = empty($this->clinic_id) ? null : $this->clinic_id;

        return $attributes;
    }

    protected function matchStatus($status = null): string
    {
        return match ($status) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك بتعديل خدمة طبية!!',
            ActionResponseStatusEnum::SUCCESS => 'تم تعديل الخدمة الطبية بنجاح',
            default => 'حدث خطاء في عملية تعديل الخدمة الطبية الرجاء المحاولة لاحقاً',
        };
    }

    protected function resetForm()
    {
        $this->name = null;
        $this->clinicServiceId = null;
        $this->color = null;
        $this->clinic_id = null;
        $this->price = null;
        $this->description = null;
    }
}

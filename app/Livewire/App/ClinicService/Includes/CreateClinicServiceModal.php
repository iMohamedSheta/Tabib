<?php

namespace App\Livewire\App\ClinicService\Includes;

use App\Actions\ClinicService\CreateClinicServiceAction;
use App\DTOs\ClinicService\CreateClinicServiceDTO;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Http\Requests\ClinicService\CreateClinicServiceRequest;
use Livewire\Component;

class CreateClinicServiceModal extends Component
{
    public $withButton = true;

    public $showName = 'show';

    public $clinics;

    public $name;

    public $clinic_id;

    public $price;

    public $description;

    public $color = '#9C27B0';

    protected function rules(): array
    {
        return (new CreateClinicServiceRequest(array_keys($this->clinics)))->rules();
    }

    public function createClinicServiceAction(): void
    {
        $validatedData = $this->validate();
        try {
            $actionResponse = (new CreateClinicServiceAction())->handle(
                new CreateClinicServiceDTO(...$validatedData),
            );

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) {
                return;
            }

            $this->resetForm();
            $this->dispatch('added');
        } catch (\Exception $exception) {
            log_error($exception);
            flash()->error($this->matchStatus());
        }
    }

    protected function matchStatus($actionResponseStatus = null): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك باضافة خدمة طبية!!',
            ActionResponseStatusEnum::SUCCESS => 'تم انشاء الخدمة الطبية بنجاح',
            default => 'حدث خطاء في عملية انشاء الخدمة الطبية الرجاء المحاولة لاحقاً',
        };
    }

    protected function resetForm()
    {
        $this->name = null;
        $this->clinic_id = null;
        $this->price = null;
        $this->description = null;
    }

    public function render()
    {
        return view('livewire.app.clinic-service.includes.create-clinic-service-modal');
    }
}

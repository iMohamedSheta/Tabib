<?php

namespace App\Livewire\App\Doctor\Includes;

use App\Actions\Doctor\CreateDoctorAction;
use App\DTOs\Doctor\CreateDoctorDTO;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Enums\Helpers\Dates\DaysEnum;
use App\Helpers\Helper;
use App\Http\Requests\Doctor\CreateDoctorRequest;
use App\Traits\LivewireTraits\WithSteps;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateDoctorModal extends Component
{
    use WithFileUploads;
    use WithSteps;

    #[Locked]
    public $clinics;
    public $days;

    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $specialization;
    public $clinic_ids;
    public $phone;
    public $other_phone;
    public $photo;
    public $selected_days;
    public $license_number;
    public $qualifications;
    public $available_days;
    public $start_time;
    public $end_time;
    public $telehealth_phone;
    public $notes;

    public function mount(array $clinics)
    {
        $this->days = DaysEnum::getDaysLabels();
        $this->maxSteps = 4;
        $this->clinics = $clinics;
    }

    protected function rules(): array
    {
        return (new CreateDoctorRequest)->rules();
    }


    public function addDoctorAction()
    {
        $validatedData = $this->validate();
        try {
            $actionResponse = (new CreateDoctorAction())->handle(
                new CreateDoctorDTO(...$validatedData)
            );

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) return;

            $this->resetForm();
            $this->dispatch('added');
        } catch (\Exception $e) {
            Helper::log($e);
        }
    }

    public function matchStatus($actionResponseStatus): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك باضافة طبيب!!',
            ActionResponseStatusEnum::SUCCESS => 'تم انشاء الطبيب بنجاح',
            default => 'حدث خطاء في عملية انشاء الطبيب الرجاء المحاولة لاحقاً'
        };
    }

    private function resetForm()
    {
        $this->username = $this->password = $this->first_name = $this->last_name = $this->specialization = $this->phone = $this->photo = $this->other_phone = null;
    }

    public function render()
    {
        return view('livewire.app.doctor.includes.create-doctor-modal');
    }
}

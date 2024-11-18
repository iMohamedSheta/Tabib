<?php

namespace App\Livewire\App\Doctor\Includes;

use App\Actions\Doctor\UpdateDoctorAction;
use App\DTOs\Doctor\UpdateDoctorDTO;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Helpers\Helper;
use Livewire\Component;
use App\Http\Requests\Doctor\UpdateDoctorRequest;
use App\Models\Doctor;
use App\Traits\LivewireTraits\ActionResponseHandlerTrait;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;

class UpdateDoctorModal extends Component
{
    use WithFileUploads;
    use ActionResponseHandlerTrait;

    #[Locked]
    public $doctor;

    #[Locked]
    public $clinics;

    #[Validate]
    public $username;
    public $first_name;
    public $last_name;
    public $specialization;
    public $organization_id;
    public $phone;
    public $other_phone;
    public $photo;

    public $password;
    public $password_confirmation;

    public function mount($doctor, array $clinics)
    {
        $this->clinics = $clinics;
        $this->username = $doctor->username;
        $this->first_name = $doctor->first_name;
        $this->last_name = $doctor->last_name;
        $this->specialization = $doctor->specialization;
        $this->organization_id = $doctor->organization_id;
        $this->phone = $doctor->phone;
        $this->other_phone = $doctor->other_phone;
    }

    protected function rules(): array
    {
        return (new UpdateDoctorRequest($this->doctor, array_keys($this->clinics)))->rules();
    }

    public function updateDoctorAction()
    {
        $validatedData = $this->validate();
        try
        {
            $doctor = Doctor::find($this->doctor->id);

            $validatedData['old_password'] = $doctor->user->password;

            $actionResponse = (new UpdateDoctorAction())->handle(
                $doctor,
                new UpdateDoctorDTO(...$validatedData)
            );

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) return;

            $this->dispatch('updated');

        } catch (\Exception $e) {
            log_error($e);
            flash()->error();
        }
    }

    public function matchStatus($actionResponseStatus = null): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك بتعديل الطبيب!!',
            ActionResponseStatusEnum::SUCCESS => 'تم تعديل الطبيب بنجاح',
            default => 'حدث خطاء في عملية تعديل الطبيب، الرجاء المحاولة لاحقاً'
        };
    }

    public function render()
    {
        return view('livewire.app.doctor.includes.update-doctor-modal');
    }
}

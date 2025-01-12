<?php

namespace App\Livewire\App\Patient\Includes;

use App\Actions\Patient\CreatePatientAction;
use App\DTOs\Patient\CreatePatientDTO;
use App\Enums\Actions\ActionResponseStatusEnum;
use App\Http\Requests\Patient\CreatePatientRequest;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePatientModal extends Component
{
    use WithFileUploads;

    public $withButton = true;
    public $showName = 'show';

    public $clinics;

    public $first_name;
    public $last_name;
    public $age;
    public $clinic_id;
    public $phone;
    public $other_phone;
    public $gender;
    public $address;
    public $allergies;
    public $height;
    public $weight;
    public $national_card_id;
    public $nationality;
    public $notes;
    public $photo;
    public $chronic_diseases;
    public $family_medical_history;
    public $blood_type;
    public $marital_status;
    public $insurance_number;
    public $insurance_provider;
    public $occupation;

    public function mount(array $clinics): void
    {
        $this->clinics = $clinics;
        $this->clinic_id = array_key_first($this->clinics);
    }

    public function render()
    {
        return view('livewire.app.patient.includes.create-patient-modal');
    }

    protected function rules(): array
    {
        return (new CreatePatientRequest(array_keys($this->clinics)))->rules();
    }

    public function addPatientAction(): void
    {
        $validatedData = $this->validate();
        try {
            $actionResponse = (new CreatePatientAction())->handle(
                new CreatePatientDTO(...$validatedData),
            );

            flash()->{$actionResponse->success ? 'success' : 'error'}($this->matchStatus($actionResponse->status));

            if (!$actionResponse->success) {
                return;
            }

            $this->resetForm();
            $this->dispatch('added');
        } catch (\Exception $exception) {
            log_error($exception);
            flash()->error($this->matchStatus('server_error'));
        }
    }

    public function matchStatus($actionResponseStatus): string
    {
        return match ($actionResponseStatus) {
            ActionResponseStatusEnum::AUTHORIZE_ERROR => 'غير مسموح لك باضافة مريض!!',
            ActionResponseStatusEnum::SUCCESS => 'تم انشاء المريض بنجاح',
            default => 'حدث خطاء في عملية انشاء المريض، الرجاء المحاولة لاحقاً',
        };
    }

    private function resetForm(): void
    {
        $this->gender = null;
        $this->address = null;
        $this->allergies = null;
        $this->notes = null;
        $this->height = null;
        $this->weight = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->age = null;
        $this->phone = null;
        $this->photo = null;
        $this->other_phone = null;
        $this->national_card_id = null;
        $this->clinic_id = array_key_first($this->clinics);
    }
}

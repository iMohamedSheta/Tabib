<?php

namespace App\Livewire\Auth\Register;

use App\Actions\Clinic\CreateClinicAction;
use App\DTOs\Auth\RegisterUserDTO;
use App\Http\Requests\Clinic\CreateClinicRequest;
use App\Models\ClinicAdmin;
use App\Models\User;
use App\Traits\LivewireTraits\WithSteps;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Register extends Component
{
    use WithSteps;

    public $name;

    public $type;

    public $first_name;

    public $last_name;

    public $phone;

    public $username;

    public $password;

    public $password_confirmation;

    // User
    public $policy = true;

    public function mount(): void
    {
        $this->maxSteps = 3;
    }

    protected function stepOneRules(): array
    {
        return (new CreateClinicRequest())->stepOneRules();
    }

    protected function stepTwoRules(): array
    {
        return (new CreateClinicRequest())->stepTwoRules();
    }

    protected function stepThreeRules(): array
    {
        return (new CreateClinicRequest())->stepThreeRules();
    }

    public function submitStepOne(): void
    {
        $this->validate($this->stepOneRules());

        $this->nextStep();
    }

    public function submitStepTwo(): void
    {
        $this->validate($this->stepTwoRules());
        $this->nextStep();
    }

    public function submitStepThree(): void
    {
        $this->validate($this->stepThreeRules());

        try {
            $clinicData = [
                'name' => $this->name,
                'type' => $this->type,
            ];

            $registerUserDTO = new RegisterUserDTO(
                first_name: $this->first_name,
                last_name: $this->last_name,
                phone: $this->phone,
                username: $this->username,
                password: $this->password,
                role: ClinicAdmin::class,
            );

            (new CreateClinicAction())->handle($registerUserDTO, $clinicData);
        } catch (\Exception) {
            DB::rollBack();
        }
    }

    public function createClinicAction(): void
    {
        $this->validate();
    }

    public function render()
    {
        return view('livewire.auth.register.register');
    }
}

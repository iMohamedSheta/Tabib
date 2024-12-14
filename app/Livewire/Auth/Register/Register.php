<?php

namespace App\Livewire\Auth\Register;

use App\Actions\Clinic\CreateClinicAction;
use App\DTOs\Auth\RegisterUserDTO;
use App\Http\Requests\Clinic\CreateClinicRequest;
use App\Models\ClinicAdmin;
use App\Models\User;
use App\Traits\LivewireTraits\WithSteps;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    use WithSteps;

    public $name;
    public $type;
    public $first_name, $last_name, $phone, $username, $password, $password_confirmation; # User
    public $policy = true;

    public function mount()
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

    public function submitStepOne()
    {
        $this->validate($this->stepOneRules());

        $this->nextStep();
    }

    public function submitStepTwo()
    {
        $this->validate($this->stepTwoRules());
        $this->nextStep();
    }

    public function submitStepThree()
    {
        $this->validate($this->stepThreeRules());


        try {
            $clinicData = [
                'name' => $this->name,
                'type' => $this->type
            ];

            $userDTO = new RegisterUserDTO(
                first_name: $this->first_name,
                last_name: $this->last_name,
                phone: $this->phone,
                username: $this->username,
                password: $this->password,
                role: ClinicAdmin::class
            );

            (new CreateClinicAction())->handle($userDTO, $clinicData);
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function createClinicAction()
    {
        $this->validate();
    }

    public function render()
    {
        return view('livewire.auth.register.register');
    }
}

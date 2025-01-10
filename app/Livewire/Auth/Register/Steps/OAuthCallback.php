<?php

namespace App\Livewire\Auth\Register\Steps;

use App\Actions\Clinic\CreateClinicAction;
use App\DTOs\Auth\RegisterUserDTO;
use App\Http\Requests\Clinic\CreateClinicRequest;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OAuthCallback extends Component
{
    public $userData;

    public $name;

    public $type;

    public $policy = true;

    public function mount(array $userData): void
    {
        $this->userData = $userData;
    }

    protected function rules(): array
    {
        return (new CreateClinicRequest())->stepOneRules();
    }

    public function render()
    {
        return view('livewire.auth.register.steps.o-auth-callback');
    }

    public function createClinicAction(): void
    {
        $this->validate();

        try {
            $clinicData = [
                'name' => $this->name,
                'type' => $this->type,
            ];

            $registerUserDTO = new RegisterUserDTO(...$this->userData);

            (new CreateClinicAction())->handle($registerUserDTO, $clinicData);
        } catch (\Exception $exception) {
            DB::rollBack();

            dd($exception);
        }
    }
}

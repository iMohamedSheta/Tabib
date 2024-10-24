<?php

namespace App\Livewire\Auth\Register\Steps;

use App\Actions\Clinic\CreateClinicAction;
use App\Enums\Clinic\ClinicTypeEnum;
use App\Http\Requests\Clinic\CreateClinicRequest;
use App\Models\Clinic;
use App\Models\ClinicAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OAuthCallback extends Component
{
    public $user;
    public $name;
    public $type;
    public $policy = true;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    protected function rules(): array
    {
        return (new CreateClinicRequest())->stepOneRules();
    }

    public function render()
    {
        return view('livewire.auth.register.steps.o-auth-callback');
    }

    public function createClinicAction()
    {
        $this->validate();

        try
        {
            $clinicData = [
                'name' => $this->name,
                'type' => $this->type
            ];

            (new CreateClinicAction())->handle($this->user, $clinicData);

        } catch (\Exception $e) {
            DB::rollBack();

            dd($e);
        }
    }




}

<?php

namespace App\Livewire\App\Clinic;

use App\Enums\User\UserRoleEnum;
use Livewire\Component;

class ClinicTable extends Component
{
    public function render()
    {
        return view('livewire.app.clinic.clinic-table');
    }

    public function getAuthUserPrefix(): string
    {
        return UserRoleEnum::getAuthPrefix();
    }
}

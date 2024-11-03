<?php

namespace App\Livewire\App\Clinic;

use App\Enums\User\UserRoleEnum;
use App\Models\Clinic;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ClinicTable extends Component
{

    protected function getPaginatedData()
    {
        return DB::table('clinics')->where('deleted_at', null)->where('id', auth()->user()->clinicAdmin->clinic_id)->get();
    }

    public function render()
    {
        return view('livewire.app.clinic.clinic-table', [
            'clinics' => $this->getPaginatedData()
        ]);
    }

    public function getAuthUserPrefix(): string
    {
        return UserRoleEnum::getAuthPrefix();
    }
}

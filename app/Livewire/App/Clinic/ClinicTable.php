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
        return DB::table('clinics')
                ->select(['clinics.*', 'plans.id as plan_id', 'plans.name as plan_name'])
                ->join('plans', 'clinics.plan_id', '=', 'plans.id')
                ->where('deleted_at', null)
                // ->where('clinics.id', auth()->user()->clinicAdmin->clinic_id)
                ->paginate();
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

<?php

namespace App\Livewire\App\Clinic;

use App\Enums\User\UserRoleEnum;
use App\Models\Clinic;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ClinicTable extends Component
{

    protected function getClinics()
    {
        return DB::table('clinics')
            ->sameOrganization()
            ->select(['clinics.*', 'plans.id as plan_id', 'plans.name as plan_name'])
            ->join('plans', 'clinics.plan_id', '=', 'plans.id')
            ->where('deleted_at', null)
            ->paginate();
    }

    public function render()
    {
        return view('livewire.app.clinic.clinic-table', [
            'clinics' => $this->getClinics()
        ]);
    }

    public function getAuthUserPrefix(): string
    {
        return UserRoleEnum::getAuthPrefix();
    }
}

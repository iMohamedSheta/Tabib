<?php

namespace App\Livewire\App\Clinic;

use App\Enums\User\UserRoleEnum;
use App\Models\Clinic;
use App\Proxy\QueryBuilders\ClinicQueryBuilderProxy;
use App\Traits\Pagination\WithCustomPagination;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ClinicTable extends Component
{
    use WithCustomPagination;

    protected function getClinics()
    {
        return ClinicQueryBuilderProxy::getClinicsForTable($this->perPage, $this->page);
    }

    public function render()
    {
        return view('livewire.app.clinic.clinic-table', [
            'clinics' => $this->getClinics()
        ]);
    }
}

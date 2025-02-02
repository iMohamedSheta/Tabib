<?php

namespace App\Livewire\App\Clinic;

use App\Proxy\QueryBuilders\ClinicQueryBuilderProxy;
use App\Traits\Pagination\WithCustomPagination;
use Livewire\Component;

class ClinicTable extends Component
{
    use WithCustomPagination;

    public function render()
    {
        return view('livewire.app.clinic.clinic-table', [
            'clinics' => $this->getClinics(),
        ]);
    }

    protected function getClinics(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return ClinicQueryBuilderProxy::getClinicsForTable($this->perPage, $this->page);
    }
}

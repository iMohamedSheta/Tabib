<?php

namespace App\Livewire\App\Patient;

use App\Models\Clinic;
use App\Models\Patient;
use App\Proxy\QueryBuilders\PatientQueryBuilderProxy;
use App\Traits\Pagination\WithCustomPagination;
use Livewire\Attributes\On;
use Livewire\Component;

#[On(['added', 'updated', 'deleted'])]
class PatientTable extends Component
{
    use WithCustomPagination;

    public $search = null;

    public function getPatients()
    {

        return PatientQueryBuilderProxy::getPatientsForTable($this->perPage, $this->page, $this->search);
    }

    public function getClinics()
    {
        return Clinic::list();
    }

    public function render()
    {
        return view('livewire.app.patient.patient-table', [
            'patients' => $this->getPatients(),
            'clinics' => $this->getClinics()
        ]);
    }
}

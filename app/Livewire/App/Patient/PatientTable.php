<?php

namespace App\Livewire\App\Patient;

use App\Models\Clinic;
use App\Models\Patient;
use App\Traits\Pagination\WithCustomPagination;
use Livewire\Attributes\On;
use Livewire\Component;

#[On(['added', 'updated', 'deleted'])]
class PatientTable extends Component
{
    use WithCustomPagination;
    public function getPatients()
    {
        // return DB::table('patients')->where('clinic_id', auth()->user()->clinicAdmin->clinic_id)->paginate(perPage: $this->perPage, page: $this->page);
        return Patient::paginate(perPage: $this->perPage, page: $this->page);
    }

    public function getClinics()
    {
        return Clinic::pluck('name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.app.patient.patient-table',[
            'patients' => $this->getPatients(),
            'clinics' => $this->getClinics()
        ]);
    }
}

<?php

namespace App\Livewire\App\Patient;

use App\Enums\Helpers\Dates\DaysEnum;
use App\Models\Clinic;
use App\Models\Patient;
use Livewire\Component;

class ShowPatient extends Component
{
    public Patient $patient;

    public function render()
    {
        $clinics = Clinic::list();
        $days = DaysEnum::getDaysLabels();

        return view('livewire.app.patient.show-patient', [
            'clinics' => $clinics,
            'days' => $days,
        ]);
    }
}

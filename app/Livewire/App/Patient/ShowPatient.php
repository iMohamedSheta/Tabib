<?php

declare(strict_types=1);

namespace App\Livewire\App\Patient;

use App\Enums\Helpers\Dates\DaysEnum;
use App\Models\Clinic;
use App\Models\Patient;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowPatient extends Component
{
    use WithFileUploads;

    public Patient $patient;
    public $uploaded_attached_file;

    public function render(): View
    {
        $clinics = Clinic::list();
        $days = DaysEnum::getDaysLabels();

        return view('livewire.app.patient.show-patient', [
            'clinics' => $clinics,
            'days' => $days,
        ]);
    }
}

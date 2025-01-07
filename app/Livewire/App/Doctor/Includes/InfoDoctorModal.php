<?php

namespace App\Livewire\App\Doctor\Includes;

use Livewire\Attributes\Locked;
use Livewire\Component;

class InfoDoctorModal extends Component
{
    #[Locked]
    public $doctor;

    public $clinics;

    public function mount($doctor, array $clinics): void
    {
        $this->doctor = $doctor;
        $this->clinics = $clinics;
    }

    public function render()
    {
        return view('livewire.app.doctor.includes.info-doctor-modal');
    }
}

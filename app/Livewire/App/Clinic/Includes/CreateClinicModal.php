<?php

namespace App\Livewire\App\Clinic\Includes;

use App\Traits\LivewireTraits\WithSteps;
use Livewire\Component;

class CreateClinicModal extends Component
{
    use WithSteps;

    public function render()
    {
        return view('livewire.app.clinic.includes.create-clinic-modal');
    }

    public function addClinicAction(): string
    {
        return 'addClinic';
    }
}

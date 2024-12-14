<?php

namespace App\Livewire\App\ClinicService\Includes;

use Livewire\Component;

class InfoClinicServiceModal extends Component
{
    public $clinicService;

    public function render()
    {
        return view('livewire.app.clinic-service.includes.info-clinic-service-modal');
    }
}

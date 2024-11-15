<?php

namespace App\Livewire\App\Queue;

use App\Models\Clinic;
use App\Models\Patient;
use App\Traits\Pagination\WithCustomPagination;
use Livewire\Component;

class QueueTable extends Component
{
    use WithCustomPagination;

    public function getQueues()
    {
        return Patient::query()->paginate(perPage: $this->perPage, page: $this->page);
    }

    public function getClinics()
    {
        return Clinic::pluck('name', 'id')->toArray();
    }


    public function render()
    {
        return view('livewire.app.queue.queue-table', [
            'queues' => $this->getQueues(),
            'clinics' => $this->getClinics()
        ]);
    }
}

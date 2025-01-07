<?php

namespace App\Livewire\App\Queue;

use App\Models\Clinic;
use App\Proxy\QueryBuilders\PatientQueryBuilderProxy;
use App\Traits\Pagination\WithCustomPagination;
use Livewire\Component;

class QueueTable extends Component
{
    use WithCustomPagination;

    public $search = '';

    public function getQueues(): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return PatientQueryBuilderProxy::getPatientsForTable($this->perPage, $this->page, $this->search);
    }

    public function getClinics()
    {
        return Clinic::pluck('name', 'id')->toArray();
    }

    public function render()
    {
        return view('livewire.app.queue.queue-table', [
            'queues' => $this->getQueues(),
            'clinics' => $this->getClinics(),
        ]);
    }
}

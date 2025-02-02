<?php

namespace App\Livewire\App\Reception;

use App\Proxy\QueryBuilders\PatientQueryBuilderProxy;
use App\Traits\LivewireTraits\WithProfilePhotoTrait;
use Livewire\Component;

class ReceptionGlobalSearchModal extends Component
{
    use WithProfilePhotoTrait;

    public $show = 'showReceptionGlobalSearchModal';

    public $search = '';

    public $searchType = 'patient';

    public function render()
    {
        $searchResults = $this->getSearchResults();

        return view('livewire.app.reception.reception-global-search-modal', ['searchResults' => $searchResults]);
    }

    public function getSearchResults(): \Illuminate\Support\Collection|array
    {
        if (!blank($this->search)) {
            return PatientQueryBuilderProxy::searchPatients($this->search);
        }

        return [];
    }

    public function getSearchResultUrl($searchResultId)
    {
        return match ($this->searchType) {
            'patient' => route('app.admin.patient.show', $searchResultId),
            default => '#',
        };
    }
}

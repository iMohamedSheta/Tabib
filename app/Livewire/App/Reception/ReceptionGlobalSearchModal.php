<?php

namespace App\Livewire\App\Reception;

use App\Proxy\QueryBuilders\PatientQueryBuilderProxy;
use App\QueryBuilders\PatientQueryBuilder;
use App\Traits\LivewireTraits\withProfilePhotoTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReceptionGlobalSearchModal extends Component
{
    use withProfilePhotoTrait;

    public $show = 'showReceptionGlobalSearchModal';
    public $search = '';
    public $searchType = 'patient';

    public function render()
    {
        $searchResults = $this->getSearchResults();
        return view('livewire.app.reception.reception-global-search-modal', compact('searchResults'));
    }

    public function getSearchResults()
    {
        if (! blank($this->search)) {
            return PatientQueryBuilderProxy::searchPatients($this->search);
        }

        return [];
    }
}

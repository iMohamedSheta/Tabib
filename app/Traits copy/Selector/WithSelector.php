<?php

namespace App\Traits\Selector;

trait WithSelector
{
    public array $selector = [];


    protected function resetSelector() : void
    {
        $this->selector = [];
        $this->dispatch('clearCheckboxes');
    }



    /*
    |------------------------------------------------------------
    |  WithSearchAbleQuery clear Methods:                       |
    |------------------------------------------------------------
    |  These clear method help you to reset frontend
    |  because there is many bugs can happen
    |  when working selectors with search
    |  so i added these just use clearSelectorsAfterSearch
    |
    */

    protected function clearSelectorWhenSearch(string $searchPropertyName = 'search') {
        if ($this->isNewSearch($this->$searchPropertyName)) {
            $this->resetSelector();
        }
    }

    protected function clearSelectorAfterSearch(string $searchPropertyName = 'search') {
        if ($this->$searchPropertyName === '') {
            $this->resetSelector();
            $this->$searchPropertyName = null;
        }
    }
}

<?php

namespace App\Traits\Sorting;

use App\Traits\Helper\isClassUseTrait;
use App\Traits\Selector\WithSelector;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait WithSorting
{
    use isClassUseTrait;

    const ASC = 'asc';
    const DESC = 'desc';

    public ?string $sortField = null;
    public array $sortDirections = [];

    public ?array $lastSortField = [];


    protected function initializeSortingDirections()
    {
        foreach ($this->sortFields() as $field) {
            if (!isset($this->sortDirections[$field])) {
                $this->sortDirections[$field] = self::ASC;
            }
        }
    }

    protected function sort(QueryBuilder|EloquentBuilder &$builder)
    {
        $this->initializeSortingDirections();
        $builder->when($this->sortField && in_array($this->sortField, $this->sortFields()),
            function($query) {
                $query->orderBy($this->sortField, $this->sortDirections[$this->sortField]);
        });
    }



    public function setSortField($field, $sortDirection) {
        if(!blank($field) && in_array($field, $this->sortFields()) && $this->isNewSort($field, $sortDirection)) {
            $this->resetWithSortingTrait();
            $this->sortField = $field;
            $this->sortDirections[$field] = $sortDirection === self::ASC ? self::ASC : self::DESC;
        }
    }


    public function isSortFieldDirectionAsc(string $field): bool {
        return array_key_exists($field, $this->sortDirections) && $this->sortDirections[$field] == self::ASC && $field == $this->sortField;
    }

    public function isNotCurrentSortField(string $field) {
        return $field != $this->sortField;
    }

    private function isNewSort($field, $sortDirection): bool {
        return ($this->sortField == null) || ($field != $this->sortField || $sortDirection != $this->sortDirections[$field]);
    }


    private function resetWithSortingTrait()
    {
        if($this->isClassUseTrait(WithSelector::class))
        {
            $this->resetSelector();
        }
    }


    /**
     * Get the fields that are sortable.
     *
     * @return array
     */

    abstract protected function sortFields() : array;
}

<?php

namespace App\Traits\Search;

use App\Traits\Helper\isClassUseTrait;
use App\Traits\Pagination\WithCustomPagination;
use Illuminate\Database\Query\Builder as QueryBuilder;
use App\Traits\Selector\WithSelector;

trait WithSearchAbleQuery
{
    use isClassUseTrait;

    public ?string $lastSearch = null;

    /*
    |--------------------------------------------------------------------------
    | WithSearchAbleQuery Trait
    |--------------------------------------------------------------------------
    |
    | Adds search functionality to a Livewire component. Implement the
    | `searchFields` method to specify searchable fields. Supports both simple
    | and nested queries. Use the `search` method with a query builder
    | and search term to filter results.
    |
    | Usage:
    | 1. Include the trait in your Livewire component.
    | 2. Define the `searchFields` method in your component to return an array
    |    of searchable fields.
    | 3. Call the `search` method with a query builder instance and the search
    |    term to filter results based on the specified search fields.
    |
    | The trait also supports nested search queries for related models.
    |--------------------------------------------------------------------------
    */


    public function search(QueryBuilder $builder, ?string $search, string $searchPropertyName = 'search'): QueryBuilder
    {
        $searchColumns = $this->searchFields();

        if (blank($search) || blank($searchColumns)) {
            return $builder;
        }

        $this->resetTraitsWhenSearch($searchPropertyName);

        $this->lastSearch = $search;

        $searchColumns = undotArray($searchColumns);
        return $builder->where(function($query) use($search, $searchColumns)
        {
            foreach($searchColumns as $searchColumn)
            {
                // Check if the column is nested
                if (is_array($searchColumn)) {
                    $query->orWhere(function ($query) use ($search, $searchColumn) {
                        $this->buildNestedSearchQuery($query, $search, $searchColumn);
                    });
                } else {
                    // Handle non-nested columns directly
                    $query->orWhere($searchColumn, 'like', "%{$search}%");
                }
            }
        });
    }


    private function buildNestedSearchQuery($query, $search, $searchColumns)
    {
        foreach ($searchColumns as $column => $nestedColumns) {
            if (is_array($nestedColumns)) {
                $query->whereHas($column, function ($query) use ($search, $nestedColumns) {
                    $this->buildNestedSearchQuery($query, $search, $nestedColumns);
                });
            } else {
                $query->orWhere($column, 'like', "%{$search}%");
            }
        }
    }

    protected function isNewSearch($search): bool {
        return  $this->lastSearch != $search;
    }

    private function resetTraitsWhenSearch($searchPropertyName)
    {
        if($this->isClassUseTrait(WithCustomPagination::class))
        {
            //WithCustomPagination Trait Method
            $this->clearPaginationWhenSearch();
        }

        if($this->isClassUseTrait(WithSelector::class))
        {
            //WithSelector Trait Method
            $this->clearSelectorWhenSearch($searchPropertyName);
        }
    }


    /**
     * Get the fields that are SearchAble.
     *
     * @return array
     */

    abstract protected function searchFields() : array;
}

<?php

namespace App\Traits\Search;

use Illuminate\Database\Eloquent\Builder;

trait SearchAbleModel
{
    public function scopeSearch(Builder $builder, $search): Builder
    {
        $searchColumns = $this->searchColumns();

        if (blank($search) || blank($searchColumns)) {
            return $builder;
        }
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


    protected function buildNestedSearchQuery($query, $search, $searchColumns)
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

    abstract protected function searchColumns(): array;
}

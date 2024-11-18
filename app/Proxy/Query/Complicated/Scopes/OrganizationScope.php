<?php

namespace App\Proxy\Query\Complicated\Scopes;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class OrganizationScope
{
    /**
     * Apply the scope to a given query builder.
     */
    public static function apply(Builder $builder)
    {
        if ($builder->from === 'organizations') {
            $builder->where('id', Auth::user()->organization_id);
        }

        $builder->where($builder->from . '.organization_id', Auth::user()->organization_id);

        return $builder;
    }
}

<?php

namespace App\Proxy\Query\Scopes;

use App\Models\Clinic;
use Illuminate\Database\Query\Builder;

class ClinicIdScope
{
    /**
     * Apply the scope to a given query builder.
     */
    public static function apply(Builder $builder)
    {
        $clinicId = auth()->user()->clinicAdmin->clinic_id;

        if ($builder->from === 'clinics')
        {
            $builder->where('id', $clinicId)
                    ->orWhere('parent_clinic_id', $clinicId);
        } else {
            $builder->where('clinic_id', $clinicId);
        }

        return $builder;
    }
}

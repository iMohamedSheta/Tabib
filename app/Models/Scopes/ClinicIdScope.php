<?php

namespace App\Models\Scopes;

use App\Models\Clinic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ClinicIdScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $clinicId = auth()->user()->clinicAdmin->clinic_id;
        if ($model instanceof Clinic) {
            $builder->where('id', $clinicId)
                    ->orWhere('parent_clinic_id', $clinicId);
        } else {
            $builder->where('clinic_id', $clinicId);
        }
    }
}

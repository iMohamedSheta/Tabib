<?php

namespace App\QueryBuilders;

use App\QueryBuilders\Base\QueryBuilderWrapper;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PatientQueryBuilder extends QueryBuilderWrapper
{
    protected function initializeQuery(): Builder
    {
        return DB::table('patients');
    }

    public function getOrganizationPatients()
    {
        $this->query
            ->sameOrganization()
            ->isPatient()
            ->notDeleted()
            ->select(
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.username',
                'users.phone',
                'users.other_phone',
                'users.profile_photo_path',
                'users.created_at',
                'patients.id as patient_id',
                'patients.clinic_id',
                'patients.age',
                'patients.address',
                'patients.gender',
                'clinics.name as clinic_name',
                'clinics.id as clinic_id'
            )
            ->join('users', 'users.id', '=', 'patients.user_id')
            ->join('clinics', 'patients.clinic_id', '=', 'clinics.id');

        return $this;
    }

    public function searchPatients($search)
    {
        $this->query->when($search, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->likeIn(['users.first_name', 'users.last_name', 'users.phone', 'users.other_phone'], $search)
                    ->likeUserFullName($search);
            });
        });

        return $this;
    }
}

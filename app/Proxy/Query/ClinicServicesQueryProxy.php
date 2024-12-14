<?php

namespace App\Proxy\Query;

use App\Proxy\Query\Base\QueryProxy;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ClinicServicesQueryProxy extends QueryProxy
{
    protected function initializeQuery(): Builder
    {
        return DB::table('clinic_services');
    }

    public function getOrganizationClinicServices()
    {
        $this->query
            ->sameOrganization()
            ->select([
                'clinic_services.*'
            ]);

        return $this;
    }

    public function subQueryPatientsCount()
    {
        $patientCountQuery = DB::table('calendars')
            ->select('clinic_service_id', DB::raw('COUNT(id) as patients_count'))
            ->groupBy('clinic_service_id');

        $this->query
            ->addSelect([
                'calendars_temp.patients_count'
            ])
            ->leftJoinSub($patientCountQuery, 'calendars_temp', function ($join) {
                $join->on('clinic_services.id', '=', 'calendars_temp.clinic_service_id');
            });

        return $this;
    }
}

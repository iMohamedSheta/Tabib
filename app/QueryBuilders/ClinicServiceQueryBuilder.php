<?php

namespace App\QueryBuilders;

use App\QueryBuilders\Base\QueryBuilderWrapper;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ClinicServiceQueryBuilder extends QueryBuilderWrapper
{
    protected function initializeQuery(): Builder
    {
        return DB::table('clinic_services');
    }

    public function getOrganizationClinicServices(): static
    {
        $this->query
            ->sameOrganization()
            ->select([
                'clinic_services.*',
            ]);

        return $this;
    }

    public function withPatientsCount(): static
    {
        $builder = DB::table('events')
            ->select('clinic_service_id', DB::raw('COUNT(id) as patients_count'))
            ->groupBy('clinic_service_id');

        $this->query
            ->addSelect([
                'events_temp.patients_count',
            ])
            ->leftJoinSub($builder, 'events_temp', function ($join): void {
                $join->on('clinic_services.id', '=', 'events_temp.clinic_service_id');
            });

        return $this;
    }
}

<?php

namespace App\QueryBuilders;

use App\QueryBuilders\Base\QueryBuilderWrapper;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ClinicQueryBuilder extends QueryBuilderWrapper
{
    protected function initializeQuery(): Builder
    {
        return DB::table('clinics');
    }

    public function getOrganizationClinics(): static
    {
        $this->query
            ->sameOrganization()
            ->select('clinics.*')
            ->notDeleted();

        return $this;
    }

    public function withPlans(): static
    {
        $this->query
            ->addSelect(['plans.id as plan_id', 'plans.name as plan_name'])
            ->join('plans', 'clinics.plan_id', '=', 'plans.id');

        return $this;
    }
}

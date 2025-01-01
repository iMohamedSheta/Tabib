<?php

namespace App\Proxy\QueryBuilders;

use App\Attributes\UsedIn;
use App\Livewire\App\Clinic\ClinicTable;
use App\QueryBuilders\ClinicQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClinicQueryBuilderProxy
{
    #[UsedIn(ClinicTable::class)]
    public static function getClinicsForTable($perPage, $page): LengthAwarePaginator
    {
        return ClinicQueryBuilder::Instance()
            ->getOrganizationClinics()
            ->withPlans()
            ->paginate(perPage: $perPage, page: $page);
    }
}

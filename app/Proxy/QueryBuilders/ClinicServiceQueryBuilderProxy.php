<?php

namespace App\Proxy\QueryBuilders;

use App\Attributes\UsedIn;
use App\Livewire\App\ClinicService\ClinicServiceTable;
use App\QueryBuilders\ClinicServiceQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ClinicServiceQueryBuilderProxy
{
    #[UsedIn(ClinicServiceTable::class)]
    public static function getClinicServicesForTable($perPage, $page): LengthAwarePaginator
    {
        return ClinicServiceQueryBuilder::Instance()
            ->getOrganizationClinicServices()
            ->withPatientsCount()
            ->paginate(perPage: $perPage, page: $page);
    }
}

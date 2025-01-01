<?php

namespace App\Proxy\QueryBuilders;

use App\Attributes\UsedIn;
use App\Livewire\App\Calendar\Includes\AddEventModal;
use App\Livewire\App\Patient\PatientTable;
use App\Livewire\App\Reception\ReceptionGlobalSearchModal;
use App\QueryBuilders\PatientQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PatientQueryBuilderProxy
{
    #[UsedIn(ReceptionGlobalSearchModal::class, AddEventModal::class)]
    public static function searchPatients($search): Collection
    {
        return PatientQueryBuilder::Instance()
            ->getOrganizationPatients()
            ->searchPatients($search)
            ->take(5)
            ->get();
    }

    #[UsedIn(PatientTable::class)]
    public static function getPatientsForTable($perPage, $page, $search = null): LengthAwarePaginator
    {
        return PatientQueryBuilder::Instance()
            ->getOrganizationPatients()
            ->searchPatients($search)
            ->paginate(perPage: $perPage, page: $page);
    }
}

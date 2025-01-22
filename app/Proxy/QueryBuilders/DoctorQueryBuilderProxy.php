<?php

namespace App\Proxy\QueryBuilders;

use App\Attributes\UsedIn;
use App\Livewire\App\Calendar\Includes\AddEventModal;
use App\Livewire\App\Doctor\DoctorTable;
use App\QueryBuilders\DoctorQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DoctorQueryBuilderProxy
{
    #[UsedIn(DoctorTable::class)]
    public static function getDoctorsForTable($perPage, $page): LengthAwarePaginator
    {
        return DoctorQueryBuilder::Instance()
            ->getOrganizationDoctors()
            ->paginate(perPage: $perPage, page: $page);
    }

    #[UsedIn(AddEventModal::class)]
    public static function searchDoctors($search): Collection
    {
        return DoctorQueryBuilder::Instance()
            ->getOrganizationDoctors()
            ->searchDoctors($search)
            ->take(5)
            ->get();
    }
}

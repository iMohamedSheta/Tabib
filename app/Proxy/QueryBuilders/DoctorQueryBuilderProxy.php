<?php

namespace App\Proxy\QueryBuilders;

use App\Attributes\UsedIn;
use App\Livewire\App\Doctor\DoctorTable;
use App\QueryBuilders\DoctorQueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DoctorQueryBuilderProxy
{
    #[UsedIn(DoctorTable::class)]
    public static function getDoctorsForTable($perPage, $page): LengthAwarePaginator
    {
        return DoctorQueryBuilder::Instance()
            ->getOrganizationDoctors()
            ->paginate(perPage: $perPage, page: $page);
    }
}

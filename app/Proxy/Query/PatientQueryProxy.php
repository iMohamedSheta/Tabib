<?php

namespace App\Proxy\Query;

use App\Proxy\Query\QueryProxy;
use Illuminate\Support\Facades\DB;

class PatientQueryProxy extends QueryProxy
{

    protected function __construct()
    {
        parent::__construct(DB::table('patients'));
    }

    public function postProcessor(): void
    {
        //
    }

    public function globalScopes(): array
    {
        return [
            //
        ];
    }
}

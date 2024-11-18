<?php

namespace App\Proxy\Query\Complicated;

use App\Proxy\Query\Complicated\base\QueryProxy as BaseQueryProxy;
use Illuminate\Support\Facades\DB;

class PatientQueryProxy extends BaseQueryProxy
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

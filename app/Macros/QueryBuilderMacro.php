<?php

namespace App\Macros;

use App\Contracts\MacroInterface;
use App\Models\Patient;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;

class QueryBuilderMacro implements MacroInterface
{

    public static function boot(): void
    {
        self::registerLikeIn();
        self::registerIsPatient();
        self::registerSameOrganization();
    }

    public static function register(): void
    {
        //
    }

    public static function registerLikeIn()
    {
        Builder::macro('likeIn', function (array $fields, $value) {
            $value = trim($value);
            // in macro world this reference to Builder class not QueryBuilderMacro (this) class so ignore $this error
            foreach ($fields as $index => $field) {
                $this->{$index === 0 ? 'where' : 'orWhere'}($field, 'LIKE', "%$value%");
            }

            return $this;
        });
    }

    public static function registerIsPatient()
    {
        Builder::macro('isPatient', function () {
            $this->where('role', Patient::class);
            return $this;
        });
    }

    public static function registerSameOrganization()
    {
        Builder::macro('sameOrganization', function () {
            $this->where($this->from .'.organization_id', Auth::user()->organization_id);
            return $this;
        });
    }
}

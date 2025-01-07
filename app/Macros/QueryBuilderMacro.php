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
        self::registerNotDeleted();
        self::registerLikeUserFullName();
    }

    public static function register(): void
    {
    }

    public static function registerLikeIn(): void
    {
        Builder::macro('likeIn', function (array $fields, $value): object {
            $value = trim($value);
            // in macro world this reference to Builder class not QueryBuilderMacro (this) class so ignore $this error
            foreach ($fields as $index => $field) {
                $this->{0 === $index ? 'where' : 'orWhere'}($field, 'LIKE', sprintf('%%%s%%', $value));
            }

            return $this;
        });
    }

    public static function registerIsPatient(): void
    {
        Builder::macro('isPatient', function (): object {
            $this->where('users.role', Patient::class);

            return $this;
        });
    }

    public static function registerSameOrganization(): void
    {
        Builder::macro('sameOrganization', function (): object {
            $this->where($this->from.'.organization_id', Auth::user()->organization_id);

            return $this;
        });
    }

    public static function registerNotDeleted(): void
    {
        Builder::macro('notDeleted', function ($isDeleted = true): object {
            ($isDeleted)
                ? $this->where($this->from.'.deleted_at', null)
                : $this->where($this->from.'.deleted_at', '!=', null);

            return $this;
        });
    }

    public static function registerLikeUserFullName(): void
    {
        Builder::macro('likeUserFullName', function ($value): object {
            $value = trim($value);
            $value = explode(' ', $value, 2);
            if (2 == count($value)) {
                $this->where('users.first_name', 'LIKE', sprintf('%%%s%%', $value[0]))
                    ->orWhere('users.last_name', 'LIKE', sprintf('%%%s%%', $value[1]));
            } else {
                $this->where('users.first_name', 'LIKE', sprintf('%%%s%%', $value[0]));
            }

            return $this;
        });
    }
}

<?php

namespace App\Macros;

use App\Contracts\MacroInterface;
use App\Models\Patient;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QueryBuilderMacro implements MacroInterface
{
    public static function boot(): void
    {
        self::registerLikeIn();
        self::registerIsPatient();
        self::registerSameOrganization();
        self::registerNotDeleted();
        self::registerOrLikeUserFullName();
        self::registerWhereConcat();
    }

    public static function register(): void {}

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
            $this->where($this->from . '.organization_id', Auth::user()->organization_id);

            return $this;
        });
    }

    public static function registerNotDeleted(): void
    {
        Builder::macro('notDeleted', function ($isDeleted = true): object {
            ($isDeleted)
                ? $this->where($this->from . '.deleted_at', null)
                : $this->where($this->from . '.deleted_at', '!=', null);

            return $this;
        });
    }

    public static function registerOrLikeUserFullName(): void
    {
        Builder::macro('orLikeUserFullName', function ($value): object {
            $this->orWhereConcat(['users.first_name', 'users.last_name'], 'LIKE', $value);

            return $this;
        });
    }

    public static function registerWhereConcat(): void
    {
        Builder::macro('whereConcat', function (array $columns, string $operator, ?string $value = null, $boolean = 'and') {
            // If only two arguments are provided, shift them correctly
            if ($value === null) {
                $value = $operator;
                $operator = 'LIKE';
            }

            // Allowed operators
            $validOperators = ['LIKE', 'NOT LIKE', '=', '!=', '>', '<', '>=', '<='];

            // Validate operator
            if (!in_array(strtoupper($operator), $validOperators)) {
                Log::error('Invalid operator provided. Supported operators are: ' . implode(', ', $validOperators));
                throw new \InvalidArgumentException('Invalid operator provided. Supported operators are: ' . implode(', ', $validOperators));
            }

            // Remove spaces from the value
            $value = preg_replace('/\s+/', '', $value);

            // Detect the database driver
            $driver = config('database.default');

            // Build the concatenated column expression
            $columnExpression = implode(" || ' ' || ", $columns); // Default for PostgreSQL, SQLite

            if ($driver === 'mysql') {
                $columnExpression = 'CONCAT(' . implode(", ' ', ", $columns) . ')';
            }

            // Convert to lowercase and remove spaces
            $columnExpressionWithTrimAndLowercase = "LOWER(REPLACE({$columnExpression}, ' ', ''))";

            // Adjust the value for LIKE operator
            $queryValue = $operator === 'LIKE' || $operator === 'NOT LIKE' ? "%{$value}%" : $value;

            // Apply the condition using the correct boolean (`and` or `or`)
            return $this->whereRaw("{$columnExpressionWithTrimAndLowercase} {$operator} ?", [$queryValue], $boolean);
        });

        // Add `orWhereConcat` by calling `whereConcat` with `'or'`
        Builder::macro('orWhereConcat', function (array $columns, $operator, $value = null) {
            return $this->whereConcat($columns, $operator, $value, 'or');
        });
    }
}

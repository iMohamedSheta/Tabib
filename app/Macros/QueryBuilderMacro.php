<?php

namespace App\Macros;

use Illuminate\Database\Query\Builder;

class QueryBuilderMacro
{

    public static function register()
    {
        self::registerLikeIn();
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

}

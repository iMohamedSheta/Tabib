<?php

namespace App\QueryBuilders\Base;

use Illuminate\Database\Query\Builder;

abstract class QueryBuilderWrapper
{
    protected Builder $query;

    public function __construct()
    {
        $this->query = $this->initializeQuery();
    }

    public static function Instance(): static
    {
        return new static();
    }

    // Abstract method that forces the subclass to define how the query should be initialized
    abstract protected function initializeQuery(): Builder;

    public function __call($method, $parameters)
    {
        if (!method_exists($this->query, $method)) {
            throw new \BadMethodCallException("Method {$method} does not exist on the query builder.");
        }

        // if the method doesn't exists in the class then it's builder method and will modify the query
        $result = $this->query->$method(...$parameters);
        // return $this object if the return is builder object else return result
        return $result === $this->query ? $this : $result;
    }
}

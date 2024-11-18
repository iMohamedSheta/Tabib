<?php

namespace App\Proxy\Query\Complicated\base;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

abstract class QueryProxy
{
    protected ?QueryBuilder $query;
    protected $data;
    protected $cacheKey;
    protected $isDataFromCache = false;
    public $cachingAllowed = false;
    private static $cacheTTL = 10;

    public function __construct(?QueryBuilder $query = null)
    {
        $this->query = $query ?? DB::query();
    }


    public function allowCache($allow = true, $minutes = null)
    {
        self::$cacheTTL = $minutes ?? self::$cacheTTL;

        $this->cachingAllowed = $allow;

        return $this;
    }

    public static function Instance()
    {
        return new static();
    }

    public function __call($method, $parameters)
    {
        $result = $this->query->$method(...$parameters);

        return $result === $this->query ? $this : $result;
    }

    public function cacheKey($key)
    {
        $this->cacheKey = $key;
        return $this;
    }

    public function cache()
    {
        $minutes = self::$cacheTTL;

        if($this->cachingAllowed && $this->data && $this->cacheKey && !$this->isDataFromCache) {
            Cache::put($this->cacheKey, $this->data, $minutes * 60);
        }

        return $this;
    }

    private function isDataCached()
    {
        if($this->cachingAllowed && $this->cacheKey && Cache::has($this->cacheKey)) {
            $this->data = Cache::get($this->cacheKey);
            $this->isDataFromCache = true;
            return true;
        }

        $this->isDataFromCache = false;

        return false;
    }

    public function paginate($perPage = 100, $page = 1)
    {
        if(!$this->isDataCached()) {
            $this->data = $this->query->paginate(perPage: $perPage, page: $page);
        }

        return $this->getData();
    }

    public function get($columns = ['*'])
    {
        if(!$this->isDataCached()) {
            $this->data = $this->query->get($columns);
        }

        return $this->getData();
    }


    public function getData()
    {
        $this->cache();

        $this->postProcessor();

        return $this->data;
    }

    public function withRelations($relations = [])
    {
        foreach ($relations as $relation) {
            $this->$relation();
        }

        return $this;
    }

    abstract public function postProcessor(): void;

    abstract public function globalScopes(): array;


    public function applyGlobalScopes(array $globalScopes = null)
    {

        $scopes = $globalScopes ?? $this->globalScopes();

        foreach ($scopes as $scope) {
            $this->query = $scope::apply($this->query);
        }

        return $this;
    }
}

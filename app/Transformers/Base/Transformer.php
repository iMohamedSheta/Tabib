<?php

namespace App\Transformers\Base;

class Transformer
{
    protected $item;

    public function __construct($item = null)
    {
        $this->item = $item;
    }

    public static function transform(&$item)
    {
        return (new static($item));
    }

    public static function transformCollection(&$items, array $methods = [])
    {
        $transformer = new static();

        $items->transform(function($item) use ($transformer, $methods) {
            $transformer->item = $item;

            foreach ($methods as $method) {
                if (!empty($method) && is_string($method)) {
                    $transformer->{$method}();
                }
            }

            return $transformer->item;
        });
    }
}

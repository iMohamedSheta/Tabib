<?php

namespace App\Transformers\Base;

class Transformer
{
    public function __construct(protected $item = null)
    {
    }

    public static function transform(&$item): static
    {
        return new static($item);
    }

    public static function transformCollection(&$items, array $methods = []): void
    {
        $static = new static();

        $items->transform(function ($item) use ($static, $methods) {
            $static->item = $item;

            foreach ($methods as $method) {
                if (!empty($method) && is_string($method)) {
                    $static->{$method}();
                }
            }

            return $static->item;
        });
    }
}

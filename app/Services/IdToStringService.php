<?php

namespace App\Services;

use Illuminate\Support\Collection;

class IdToStringService
{
    public static function idToString(Collection $products): Collection
    {
        $products->map(function ($product) {
            $product->sku = sprintf("%06d", $product->sku);
        });
        return $products;
    }
}

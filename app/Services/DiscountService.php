<?php

namespace App\Services;

use Illuminate\Support\Collection;
use stdClass;

class DiscountService
{
    public static function applyDiscount(Collection $products): Collection
    {
        $products->map(function ($product) {
            $product->price = (object) [
                'original' => $product->price, 
                'final' => $product->price, 
                'discount_percentage' => null, 
                'currency' => 'EUR'
            ];
            if ($product->category == 'boots') {
                $product->price->discount_percentage = '30%';
                $product->price->final = $product->price->original - (($product->price->original * 30)/100);
            }
            elseif($product->sku == '000003'){
                $product->price->discount_percentage = '15%';
                $product->price->final = $product->price->original - (($product->price->original * 15)/100);
            }
        });
        return $products;
    }
}

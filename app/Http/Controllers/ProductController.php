<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\DiscountService;
use App\Services\IdToStringService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $builder = Product::query();
        $request->whenHas('category', function ($input) use ($builder) {
            $builder->where('category', $input);
        });
        $request->whenHas('priceLessThan', function($input) use ($builder){
            $builder->where('price', '<=', $input);
        });
        $products = $builder->paginate(5)->getCollection();
        $products = IdToStringService::idToString($products);
        $products = DiscountService::applyDiscount($products);
        return $products;
    }
}

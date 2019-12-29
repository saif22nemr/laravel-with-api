<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $buyers = $product
        ->transactions()
        ->with('buyers')
        ->get()
        ->pluck('buyers')
        ->unique('id')
        ->values();
        // $buyers[] = 
        // [    'links' => 
        //     [
        //         'rel' => 'self',
        //         'href'=> route('products.buyers.index',$product->id)
        //     ]
        // ];
        return $this->showAll($buyers);
    }

    
}

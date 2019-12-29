<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions->pluck('products'); //for get product that have transaction of this buyer only
        $products = $buyer->transactions()->with('products')->with('buyers')->get(); // this for get all information that have transaction and product and buyer too in same request from database
        return $this->showAll($products);
    }

}

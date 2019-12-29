<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class BuyerSellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // $sellers = Seller::find(2);
        // return $sellers->products()->with('sellers')->get();
        $sellers = $buyer->transactions()->with('products.sellers')->get();
        return $this->showAll($sellers);
    }

}

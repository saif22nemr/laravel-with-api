<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Seller;
use Illuminate\Http\Request;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $buyers = $seller->products()
        ->whereHas('transactions') //here for check if this product is have transactions or not.
        ->with('transactions.buyers') //then here get in my query
        ->get()
        ->pluck('transactions') //just get only transaction table
        ->collapse() //it must be collapse here // for remove array
        ->pluck('buyers') //here get buyers from the transactions
        ->unique('id')
        ->values();
        return $this->showAll($buyers);
    }

    
}

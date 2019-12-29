<?php

namespace App\Http\Controllers\Transaction;

use App\Buyer;
use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\Transaction;
use App\transactions;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        return $this->showAll($transactions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    public function test(){
        




        $products = Product::find(3);
        //echo 'test';
        return $products->transactions->pluck('buyers'); //error in seller
        $sellers = Seller::find(3);
        //return $sellers->products;
        $categories = Category::find(1);
        $buyers = $categories->products()->whereHas('transactions')->with('transactions.buyers')->get()
            ->pluck('transactions')
            ->collapse()
            ->pluck('buyers') //[pluck] this for get buyer from transaction from this category
            ->unique('id') // [unique] for not dublicate rows
            ->values(); //[values] for not get empty rows
        return $buyers;
        $transactions = Transaction::find(2);
        //return $transactions->buyers;
        $buyers = Buyer::all();
        //return $buyers;
        $sellers = Seller::find(1);
        //return $sellers;
        $sellersFromUser = User::all();
        return $sellersFromUser->sellers;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return $this->showOne($transaction);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}

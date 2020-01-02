<?php

namespace App\Http\Controllers\Transaction;


use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionProductController extends ApiController
{
    
    public function index(Transaction $transaction)
    {
        $product = $transaction->products;
        return $this->showOne($product);
    }

}

<?php

namespace App\Http\Controllers\Transaction;

use App\Buyer;
use App\Http\Controllers\ApiController;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionBuyerController extends ApiController
{
    
    public function index(Transaction $transaction)
    {
        $buyer = $transaction->buyers;
        return $this->showOne($buyer);
    }

    
}

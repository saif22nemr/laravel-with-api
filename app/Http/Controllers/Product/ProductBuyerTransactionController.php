<?php

namespace App\Http\Controllers\Product;

use App\Buyer;
use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{
    
    public function store(Request $request,Product $product,User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];
        if($buyer->id == $product->seller_id)
            return $this->errorResponse('This buyer must be deffirent from the seller!',409);
        if(!$buyer->isVerified())
            return $this->errorResponse('This buyer must be verified !',409);
        if(!$product->sellers->isVerified())
            return $this->errorResponse('This seller must be verified !',409);
        if(!$product->isAvailable())
            return $this->errorResponse('This product not avaliavle !',409);
        if($product->quantity < $request->quantity){
            return $this->errorResponse('This product does not have enough units for buy',409);
        }
        return DB::transaction(function() use ($request,$product,$buyer){
            $product->quantity -= $request->quantity;
            if($product->quantity == 0) $product->status = Product::UnavailableProduct;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);
            return $this->showOne($transaction);
        });

    }

    
}

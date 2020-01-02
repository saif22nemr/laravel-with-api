<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Seller;
use App\Transformers\ProductTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends ApiController
{
    public function __construct(){
        parent::__construct();
        $this->middleware('transformer.input:'.ProductTransformer::class)->only(['update','store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,User $seller)
    {
        $roles = [
            'name'=> 'required|min:2',
            'description' => 'required|min:4',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image'
        ];
        $request->validate($roles);
        $data = $request->all();
        $data['status'] = Product::UnavailableProduct;
        $data['seller_id'] = $seller->id;
        $data['image'] = $request->image->store('');
        $product = Product::create($data);
        return $this->showOne($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        $products = $seller->products;
        return $this->showAll($products);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller,Product $product)
    {
        $roles = [
            'name'=> 'min:3',
            'description' => 'min:10',
            'quantity' => 'integer|min:1',
            'image' => 'image'
        ];
        $request->validate($roles);
        if($product->seller_id == $seller->id){
            $product->fill($request->only([
                'name','description','quantity'
            ]));
            if($request->has('status')){
                $product->status = $request->status;
                if($product->isAvailable() and $product->categories()->count() == 0)
                    return $this->errorResponse('An active the product it must have at least on category',409);
            }
            if($product->isClean())
                return $this->errorResponse('It must change data to update!',422);
            if($request->hasFile('image')){ // for check if user want to update image or not
                Storage::delete($product->image);
                $product->image = $request->image->store(''); // just keep it empty  [this for path inside img folder]
            }
            $product->save();
            return $this->showOne($product);
        }
        else{
            return $this->errorResponse('You not authorited to update this product!',404);
        }

        // $data = $request->all();
        // $data->save();  
        // return $this->showOne($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller,Product $product)
    {
        //$this->checkSeller($seller,$product);
        if($seller->id != $product->seller_id)
            return $this->errorResponse('You not authorited to delete this product!',404);
        $product->delete();
        if(!Storage::delete($product->image))
            return $this->errorResponse('The image not delete from the server, Please contact the admin?',500);
        return $this->showOne($product);
    }

    private function checkSeller(Seller $seller, Product $product){
        if($seller->id != $product->seller_id)
            return $this->errorResponse('You authorited to controll this product!',422);
            throw new HttpException(422,'The specified seller id is not ');
    }
}

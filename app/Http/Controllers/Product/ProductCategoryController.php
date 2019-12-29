<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\CategoryProduct;
use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }
    public function update(Request $request, Product $product,Category $category)
    {
        // $products = CategoryProduct::where('product_id',$product->id)->get();
        // return $products->categories;
        // // $roles = [

        // // ];
        $product->categories()->attach([$category->id]);
        // return $categories;
        return $this->showAll($product->categories);
    }
    public function destroy( Product $product,Category $category){
        if(!$product->categories()->find($category->id))
            return $this->errorResponse('This category not exit for this product!',404);
        $product->categories()->detach([$category->id]);
        return $this->showAll($product->categories);
    }
  
}

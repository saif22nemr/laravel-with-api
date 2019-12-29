<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


/**
* Category
*/
Route::resource('categories','Category\CategoryController',['except'=>['create','edit']]);
Route::resource('categories.products','Category\CategoryProductController',['only'=>['index']]);
Route::resource('categories.sellers','Category\CategorySellerController',['only'=>['index']]);
Route::resource('categories.transactions','Category\CategoryTransactionController',['only'=>['index']]);
Route::resource('categories.buyers','Category\CategoryBuyerController',['only'=>['index']]);
/**
* Product
*/
Route::resource('products','Product\ProductController',['only'=>['show','index']]);
Route::resource('products.transactions','Product\ProductTransactionController',['only'=>['index']]);
Route::resource('products.buyers','Product\ProductBuyerController',['only'=>['index']]);
Route::resource('products.categories','Product\ProductCategoryController',['except'=>['create','edit']]);
Route::resource('products.buyers.transactions','Product\ProductBuyerTransactionController',['only'=>['store']]);
/**
* Transaction
*/
Route::resource('transactions','Transaction\TransactionController',['only'=>['show','index']]);
Route::resource('transactions.categories','Transaction\TransactionCatrgoryController',['only'=>['index']]);
/**
* Seller
*/
Route::resource('sellers','Seller\SellerController',['only'=>['show','index']]);
Route::resource('sellers.transactions','Seller\SellerTransactionController',['only'=>['index']]);
Route::resource('sellers.categories','Seller\SellerCategoryController',['only'=>['index']]);
Route::resource('sellers.buyers','Seller\SellerBuyerController',['only'=>['index']]);
Route::resource('sellers.products','Seller\SellerProductController',['except'=>['create','edit']]);
/**
* Buyer
*/
Route::resource('buyers','Buyer\BuyerController',['only'=>['show','index']]);
Route::resource('buyers.transactions','Buyer\BuyerTransactionController',['only'=>['index']]);
Route::resource('buyers.products','Buyer\BuyerProductController',['only'=>['index']]);
Route::resource('buyers.sellers','Buyer\BuyerSellerController',['only'=>['index']]);
Route::resource('buyers.categories','Buyer\BuyerCategoryController',['only'=>['index']]);
/**
* User
*/
Route::resource('users','User\UserController',['except'=>['edit','edit']]);
Route::name('verifiy')->get('users/verified/{token}','User\UserController@verifiy');
Route::name('resend')->get('users/{user}/resend','User\UserController@resend');

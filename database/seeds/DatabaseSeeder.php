<?php

use App\Buyer;
use App\Category;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Illuminate\Database\Eloquent\Concerns\flushEventListeners;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // for disable foreign key for some time
        // $this->call(UsersTableSeeder::class);

        // for run seeder you must empty the database
        User::truncate();
        Product::truncate();
        Category::truncate();
        Transaction::truncate();

        //for not sending email createing fake data
        User::flushEventListeners();
        Product::flushEventListeners();
        Category::flushEventListeners();
        Transaction::flushEventListeners();

        DB::table('category_product')->truncate(); //used when the table not have model

        // this varaible for make number of row randomlly in database
        $userQuantity = 1000;
        $productQuantity = 3000;
        $transactionQuantity = 10000;
        $categoryQuantity = 30;
        //this is requie step for make this data.
        factory(User::class,$userQuantity)->create();
        factory(Category::class,$categoryQuantity)->create();
        factory(Product::class,$productQuantity)->create()->each(function($product){
            //[pluck] => when you have several collection and you need one of them , just use pluck('column_name').
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
            $product->categories()->attach($categories);
        });

        factory(Transaction::class,$transactionQuantity)->create();
        
    }
}

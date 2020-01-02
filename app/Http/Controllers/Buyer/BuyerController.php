<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Buyer;
class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = Buyer::has('transactions')->get();
        return $this->showAll($users);
        //return response()->json(['data'=>$users],200);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $users)
    {
        //
        //echo $users->Username;
        //print_r($users);
        //echo 'home';
        //$users = Buyer::has('transactions')->find($id);
        return response()->json(['data'=>$users],200);
    }

  
}

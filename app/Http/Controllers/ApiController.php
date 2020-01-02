<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponse;
class ApiController extends Controller
{
    //
    public function __construct(){
        //parent::__construct();
        
    }
    use ApiResponse;
    
}

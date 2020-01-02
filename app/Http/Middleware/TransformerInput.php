<?php

namespace App\Http\Middleware;

use Closure;

class TransformerInput
{
    /**
     * Handle an incoming request.
     *  
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$transformer)
    {
        //this middleware for transformer column name from to  or to from
        $transformInput = [];
        foreach (request()->all() as $key => $value) {
            $transformInput[$transformer::originalAttribute($key)] = $value;
        }
        $request->replace($transformInput);
        $response = $next($request);
        //from here for transform the original column name to name from transformer.
        if(isset($response->exception) ){ //this condition for check if there error and this error from validation 
            $data = $response->getData(); //get data : like request->all();
            //return $data;
            //print_r($data);
            $transformerErrors = []; //this val for add names of filed and the error message.
            foreach ($data->error as $key => $value) {// key: field , value: error message
                $transformField = $transformer::transformedAttribute($key); //here will transform the [original name ] to [transfrom name].
                //str_replace : there in error message it's content the original name too. so it must convert to the transformer name;
                $transformerErrors[$transformField] = str_replace($key,$transformField,$value);
            }
            $response->setData($transformerErrors);
        }
        return $response;
    }
}

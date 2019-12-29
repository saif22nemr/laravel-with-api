<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use ApiResponse;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException )
            return $this->convertValidationExceptionToResponse($exception,$request);
        if($exception instanceof ModelNotFoundException){
            $modelName = $exception->getModel();
            //return 'home '.$modelName;
            return $this->errorResponse('This model [ '.$modelName.' ] not found in this model',404);
        }
        if($exception instanceof AuthorizationException){
            $this->errorResponse($exception->getMessage(),403);
        }
        if($exception instanceof NotFoundHttpException)
            return $this->errorResponse('This url not found!',404);
        if($exception instanceof MethodNotAllowedHttpException){
            return $this->errorResponse('This d found!',404);
        }
        if($exception instanceof HttpException)
            return $this->errorResponse('Http Exception',404);
        return parent::render($request, $exception);
    }
    protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        /**
         * 
         *  [$e] -> for get message of error and know what field is wrong.
         *  [$request] -> it will return back all data you insert inside your form.
         *  Note: when exception happen, it will stop run the controller and will run this exception. 
         *  -> Here for make custom exception like this exception.   
         *      */
        //return 'error here';
        print_r($request->all());
        //return $e->getMessage();
        
        $error = $e->validator->errors()->getMessages();
        return $this->errorResponse($error, 422);
//        if ($e->response) {
//            return $e->response;
//        }
//
//        return $request->expectsJson()
//                    ? $this->invalidJson($request, $e)
//                    : $this->invalid($request, $e);
    }
}

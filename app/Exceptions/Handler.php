<?php

namespace App\Exceptions;

use Exception;
use View;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
       \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
    ];

  

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
     public function render($request, Exception $exception)
    {
             //session()->flash('alert-class', 'danger');

    //         if ($exception instanceof ModelNotFoundException) {
    //         session()->flash('message', __('errors.500'));

    //          return response()->view('errors/' . $exception->getStatusCode(),500);    
    //         }

    //      if ($this->isHttpException($exception)) {
    //      if ($exception->getStatusCode() == 404) {
    //          session()->flash('message', __('errors.404'));

    //         return response()->make(view('errors.404'), 404);

    //      }
    //      if ($exception->getStatusCode() == 403) {
    //          session()->flash('message', __('errors.403'));

    //         return response()->make(view('errors.403'), 403);

    //      }
    //        if ($exception->getStatusCode() == 500) {
    //          session()->flash('message', __('errors.500'));

    //      return response()->make(view('errors.500'), 500);

    //      }
    //  }else{
    //          session()->flash('message', __('errors.500'));

    //      return view('errors/index');

    //  }
 

        return parent::render($request, $exception);
      //  }
     

   }

 


}

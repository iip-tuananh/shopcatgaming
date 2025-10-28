<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }


    public function render($request, Exception $exception)
    {
        // 404 page when a model is not found
        if ($exception instanceof ModelNotFoundException) {
            return redirect()->route('front.home-page');
        }

        if ($exception instanceof NotFoundHttpException) {
            return redirect()->route('front.home-page');
        }

        // custom error message
        if ($exception instanceof \ErrorException) {
            return redirect()->route('front.home-page');
        } else {
            return parent::render($request, $exception);
        }

    }

}

<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
         * Register the exception handling callbacks for the application.
         *
         * @return void
         */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
  
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException && $request->isJson()) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 403);
        }

        if ($exception instanceof AuthenticationException && $request->isJson()) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 403);
        }

        if ($exception instanceof ModelNotFoundException && $request->isJson()) {
            return response()->json([
                'message' => $exception->getMessage()
            ], 404);
        }

        return parent::render($request, $exception);
    }
}

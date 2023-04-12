<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated user.', 'errorCode' => 4002], 401);
        }

         return redirect()->guest('login');
    //  return Redirect::to($app_url);
       // return redirect()->('/default');
      // return redirect();
    }

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json(['message' => 'Unauthenticated user.', 'errorCode' => 4002], 401);
        });

        $this->renderable(function (QueryException $e, $request) {
            return response()->json(['message' => $e, 'errorCode' => 4001], 500);
        });

        $this->renderable(function (ErrorException $e, $request) {
            return response()->json(['message' => $e, 'errorCode' => 4001], 500);
        });
    }
}

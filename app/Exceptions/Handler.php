<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Dotenv\Exception\ValidationEException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

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
        'current_password',
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
        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json(["status" => false, "error" => "Authentication Error"], 401);
        });

        $this->renderable(function (AuthorizationException $e, $request) {
            return response()->json(["status" => false, "error" => "Authorization Error, you don't have access permission"], 403);
        });

        $this->renderable(function (HttpException $e, $request) {
            return response()->json(["status" => false, "error" => "Path error"], 404);
        });
      
        $this->renderable(function (QueryException $e, $request) {
            return response()->json(["status" => false, "error" => "Database query error", $exception->getMessage()], 500);
        });

        $this->renderable(function (ModelNotFoundException $e, $request) {
            return response()->json(["status" => false, "error" => "Model error"], 400);
        });

        $this->renderable(function (RouteNotFoundException $e, $request) {
            return response()->json(["status" => false, "error" => "Path error"], 404);
        });

    }
}

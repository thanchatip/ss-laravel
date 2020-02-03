<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        //check if exception is an instance of MongoResultException.
        if ($e instanceof \MongoResultException) {
            if ($request->ajax()) {
                return response()->json(['error' => 'MongoResultException'], 501);
            }
            return response()->view('errors.501', [], 501);
        } elseif ($e instanceof \MongoConnectionException) {
            if ($request->ajax()) {
                return response()->json(['error' => 'MongoConnectionException'], 500);
            }
            return response()->view('errors.500', [], 500);
        } elseif ($e instanceof \MongoException) {
            if ($request->ajax()) {
                return response()->json(['error' => 'MongoException'], 503);
            }
            return response()->view('errors.503', [], 503);
        } elseif ($e instanceof \TokenMismatchException) {
            if ($request->ajax()) {
                return response()->json(['error' => 'MongoConnectionException'], 500);
            }
            return response()->view('errors.500', [], 500);
        } elseif ($e instanceof \NotFoundHttpException) {
            if ($request->ajax()) {
                return response()->json(['error' => 'MongoConnectionException'], 500);
            }
            return response()->view('errors.500', [], 500);
        }
        return parent::render($request, $e);
    }
    
}
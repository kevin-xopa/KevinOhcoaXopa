<?php

namespace App\Exceptions;

use Throwable;
use App\Helper\DataResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use DataResponse;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {
        // if (env('APP_ENV') === 'local' && !$request->is('api/*')) {
        //     return parent::render($request, $e);
        // }
        // if ($request->is('api/*')) {
        //     if ($e instanceof NotFoundHttpException) {
        //         return $this->error_response('Resource not fount', 404);
        //     }

        //     if ($e instanceof ValidationException) {
        //         return $this->validation_response($e);
        //     }

        //     if ($e instanceof HttpException) {
        //         return $this->error_response($e);
        //     }

        //     if (env('APP_ENV') === 'local') {
        //         return parent::render($request, $e);
        //     }

        // }
        // if (env('APP_ENV') === 'local') {
        //     return parent::render($request, $e);
        // }
        return parent::render($request, $e);
    }
}

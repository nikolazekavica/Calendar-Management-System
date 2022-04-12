<?php

namespace App\Exceptions;

use App\Helpers\CalendarResponse;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\ErrorHandler\Error\FatalError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
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
     * A list of the inputs that are never flashed for validation exceptions.
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

    public function render($request, Throwable $exception)
    {
        switch ($exception) {
            case $exception instanceof ValidationException:
                return CalendarResponse::multipleError(
                    $exception->validator->errors()->messages(),
                    $exception->status
                );
            case $exception instanceof QueryException:
                return CalendarResponse::error(
                    $exception->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            case $exception instanceof NotFoundHttpException:
                return CalendarResponse::error(
                    'Route not found.',
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            case $exception instanceof FatalError:
                return CalendarResponse::error(
                    $exception->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            case $exception instanceof InvalidFormatException:
                return CalendarResponse::error(
                    $exception->getMessage(),
                    Response::HTTP_BAD_REQUEST
                );
            default:
                return CalendarResponse::error(
                    $exception->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
        }
    }
}

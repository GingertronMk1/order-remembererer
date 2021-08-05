<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
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
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, Throwable $e)
    {
        $response = parent::render($request, $e);
        $status = $response->status();
        $referrer = url()->previous();

        if (!app()->environment(['local', 'testing'])) {
            switch ($status) {
            case 500:
            case 503:
            case 404:
            case 403:
                return inertia('Error', ['status' => $status,
                    'message' => $e->getMessage(),
                    'referrer' => $referrer, ])
                    ->toResponse($request)
                    ->setStatusCode($status)
                ;

            case 419:
                return back()->with([
                    'message' => 'The page expired, please try again.',
                ]);
            }
        }

        return $response;
    }
}

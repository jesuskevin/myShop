<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($e instanceof \Illuminate\Session\TokenMismatchException) {
                info($e);
                return redirect('/login');
            } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                if ($e->getStatusCode() == 419) {
                    info($e);
                    return redirect('/login')->with('error', 'Your session expired due to inactivity. Please login again.');
                } elseif ($e->getStatusCode() == 403) { //The only way to prevent Laravel from displaying 403 page
                    info($e);
                    return redirect('/')->with('error', 'We could not find the page you were trying to access.');
                } elseif ($e->getStatusCode() == 404) {
                    info($e);
                    return redirect('/')->with('error', 'We could not find the page you were trying to access.');
                } elseif ($e->getStatusCode() == 405) { //Invalid http method for route
                    info($e);
                    return redirect('/')->with('error', 'We could not find the page you were trying to access.');
                }
            } elseif ($e instanceof \Illuminate\Validation\ValidationException) {
                if ($request->expectsJson()) {
                    info($e);
                    return response()->json($e->validator->errors()->all(), 422);
                } else {
                    info($e);
                    return back()->withErrors($e->validator)->withInput();
                }
            } elseif ($e instanceof AuthenticationException) {
                if ($request->route()->uri() == '/') {
                    info($e);
                    return redirect('/login');
                }
            } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException) {
                info($e);
                return back()->with('error', 'We could not find the page you were trying to access.');
            } elseif ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                info($e);
                return back()->with('error', 'We could not find the page you were trying to access.');
            } else {
                info($e);
                return back()->with('error', 'An error occured, please try again or contact support if the problem persists.')->withInput();
            }
        });
    }
}

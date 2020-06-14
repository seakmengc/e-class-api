<?php

namespace App\Exceptions;

use Throwable;
use Nuwave\Lighthouse\Execution\ErrorHandler;
use Nuwave\Lighthouse\Exceptions\RendersErrorsExtensions;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use GraphQL\Error\Error;
use Exception;
use Closure;

class Handler extends ExceptionHandler implements ErrorHandler
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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            switch (get_class($exception)) {
                case CustomException::class:
                    return response()->json([
                        'errors' => [
                            'message' => $exception->getMessage(),
                            'extensions' => [
                                'reason' => $exception->getMessage(),
                                'success' => false,
                            ]
                        ]
                    ]);
                default:
                    return response()->json([
                        'errors' => [
                            'message' => 'Internal server error',
                            'extensions' => [
                                'reason' => 'Internal server error',
                                'success' => false,
                            ]
                        ]
                    ]);
            }
        }

        return parent::render($request, $exception);
    }

    public static function handle(Error $error, Closure $next): array
    {
        $underlyingException = $error->getPrevious();

        // dd($underlyingException);
        if (method_exists($underlyingException, 'extensionsContent')) {
            $error = new Error(
                $error->message,
                null,
                null,
                null,
                $error->getPath(),
                $underlyingException,
                array_merge(collect($underlyingException->extensionsContent())->toArray(), [
                    'reason' => $error->message ?? 'Internal server error',
                    'success' => false,
                ])
            );
        } elseif (method_exists($underlyingException, 'getExtensions')) {
            $error = new Error(
                $error->message,
                null,
                null,
                null,
                $error->getPath(),
                $underlyingException,
                array_merge(collect($underlyingException->getExtensions())->toArray(), [
                    'reason' => $error->message ?? 'error',
                    'success' => false,
                ]),
            );
        } else {
            $error = new Error(
                $error->message,
                null,
                null,
                null,
                $error->getPath(),
                $underlyingException,
                [
                    'reason' => $error->message ?? 'error',
                    'success' => false,
                ]
            );
        }
        dd($error);

        return $next($error);
    }
}

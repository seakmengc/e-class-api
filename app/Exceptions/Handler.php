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
                case Exception::class:
                    return response()->json([
                        'message' => $exception->getMessage(),
                        'success' => false,
                    ]);
                case 'Error':
                    return response()->json([
                        'message' => 'Internal server error',
                        'success' => false,
                    ]);
            }
        }

        return parent::render($request, $exception);
    }

    public static function handle(Error $error, Closure $next): array
    {
        $underlyingException = $error->getPrevious();

        if ($underlyingException instanceof RendersErrorsExtensions) {
            // Reconstruct the error, passing in the extensions of the underlying exception
            $error = new Error( // @phpstan-ignore-line TODO remove after graphql-php upgrade
                $error->message,
                null,
                null,
                null,
                null,
                null,
                $underlyingException->extensionsContent()
            );
        }

        return $next($error);
    }
}

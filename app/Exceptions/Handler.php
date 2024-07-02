<?php

namespace App\Exceptions;

use App\Http\Resources\PrecognitionSuccessResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;
use ReflectionClass;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

        $this->renderable(function (Exception $exception, $request) {
            if ($request->is('api/*')) {

                $name = (new ReflectionClass($exception))->getShortName();
                $message = $exception->getMessage() == "" ? $name : $exception->getMessage();
                $exceptionHasData = property_exists($exception, 'data');

                if ($exception instanceof HttpException && $request->headers->has('Precognition-Validate-Only')) {
                    /**
                     * Because if there are no error with precognition
                     * Framework will throw an exception
                     * we override to api resource as success
                     */
                    return new PrecognitionSuccessResource();
                }

                if ($exception instanceof ValidationException) {

                    $response = response()->json([
                        'data' => [
                            'exception' => $name,
                            'errors' => $exception->errors()
                        ],
                        'success' => false,
                        'message' => __($message)
                    ], $exception->status);


                    if ($request->headers->has('Precognition-Validate-Only')) {

                        $response = response()->json([
                            'data' => [
                                'exception' => $name,
                            ],
                            'errors' => $exception->errors(),
                            'success' => false,
                            'message' => __($message)
                        ], $exception->status);

                        $response->withHeaders([
                            'Precognition-Success' => 'false'
                        ]);
                    }

                    return $response;
                }

                if ($exception instanceof AuthenticationException || $exception instanceof AccessDeniedHttpException) {
                    return response()->json([
                        'data' => [
                            'exception' => $name,
                        ],
                        'success' => false,
                        'message' => __($message)
                    ], Response::HTTP_UNAUTHORIZED);
                }

                if ($exception instanceof QueryException) {

                    if (env("APP_ENV") == "production") {
                        $message = explode(":", $message);
                        $message = "Error {$message[0]}, please contact your system administrator";
                    }

                    return response()->json([
                        'data' => [
                            'exception' => $name,
                        ],
                        'success' => false,
                        'message' => $message,
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                $code = method_exists($exception, 'getCode')
                    ?  $exception->getCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR;

                $code = filter_var($code, FILTER_VALIDATE_INT) !== false ? $code : Response::HTTP_INTERNAL_SERVER_ERROR;

                $code = $code > Response::HTTP_NETWORK_AUTHENTICATION_REQUIRED || $code < Response::HTTP_CONTINUE
                    ? Response::HTTP_INTERNAL_SERVER_ERROR
                    : $code;


                $dataResponse = [
                    'exception' => $name
                ];

                if ($exceptionHasData) array_merge($dataResponse, $exception->data);

                return response()->json([
                    'data' => $dataResponse,
                    'success' => false,
                    'message' => __($message),
                ], $code);
            }
        });
    }
}

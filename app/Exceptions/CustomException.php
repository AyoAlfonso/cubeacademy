<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomException extends Exception
{
    use ApiResponser;

    protected $statusCode;

    public static function handle($e)
    {
        if ($e instanceof AuthorizationException) {
            throw CustomException::notAuthorized('You are not authorized to update this resource', 403);
        } elseif ($e instanceof ModelNotFoundException) {
            throw CustomException::notFound('Resource not found');
        } elseif ($e instanceof ValidationException) {
            throw CustomException::validationError($e->validator);
        } else {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function __construct($message = "", $code = 0, $statusCode = 400)
    {
        parent::__construct($message, $code);
        $this->statusCode = $statusCode;
    }

    public function render($request): JsonResponse
    {
        $statusCode = $this->statusCode;
        $message = $this->getMessage();

        if ($this instanceof ModelNotFoundException || $this instanceof NotFoundHttpException) {
            $statusCode = 404;
            $message = 'Resource not found';
        }

        return $this->errorResponse($message, $statusCode);
        /* instead of
    // response()->json([
    //     'status' => 'Error',
    //     'message' => $message,
    //     'data' => null,
    // ], $statusCode);
     */
    }

    private static function notFound($message = 'Resource not found'): self
    {
        return new self($message, 0, 404);
    }

    private static function notAuthorized($message = 'Not authorized', int $statusCode = 403): self
    {
        return new self($message, 0, $statusCode);
    }
    private static function badRequest($message = 'Bad request'): self
    {
        return new self($message, 0, 400);
    }
    public static function validationError($validator): self
    {
        $errors = $validator->errors()->all();
        $message = 'The given data was invalid. Errors: ' . implode(' | ', $errors);
        return new self($message, 0, 422);
    }
    private static function serverError($message = 'Internal server error'): self
    {
        return new self($message, 0, 500);
    }

}

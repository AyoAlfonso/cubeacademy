<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CustomException extends Exception
{
    protected $statusCode;

    public function __construct($message = "", $code = 0, $statusCode = 400)
    {
        parent::__construct($message, $code);
        $this->statusCode = $statusCode;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'status' => 'Error',
            'message' => $this->getMessage(),
            'data' => null
        ], $this->statusCode);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function sendResponse(string $message, mixed $data = null, int $code = 200)
    {
        return response()->json([
            'code' => $code,
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function sendError(string $message, array $errors, int $code = 404)
    {
        return response()->json([
            'code' => $code,
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ]);
    }
}

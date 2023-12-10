<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
            return $this->sendError('Unauthorized', [ 'auth' => 'The provided credentials are incorrect.' ], 401);

        $user = Auth::user();
        $token = $user->createToken('MyApp')->plainTextToken;

        return $this->sendResponse('Authorized', [
            'user' => new UserResource($user),
            'token' => $token
        ]);
    }
}

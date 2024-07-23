<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required|confirmed',
            ]);

            $validatedData['password'] = Hash::make($request->password);

            $user = User::create($validatedData);

            $accessToken = $user->createToken('authToken')->plainTextToken;

            return $this->successResponse([
                'user' => $user,
                'access_token' => $accessToken,
            ], 'User registered successfully');

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 401);
        }
    }

    public function login(Request $request)
    {

        try {
            $loginData = $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            if (!auth()->attempt($loginData)) {
                return $this->errorResponse('Invalid Credentials', 401);
            }

            $accessToken = auth()->user()->createToken('authToken')->plainTextToken;
            $user = auth()->user();
            return $this->successResponse([
                'user' => $user,
                'access_token' => $accessToken,
                'token_type' => 'Bearer',
            ], 'User logged in successfully');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 401);
        }
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Resources\AuthResource;
use Auth;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json([
                'success' => true,
                'message' => 'Login Success!',
                'data' => new AuthResource($user)
            ], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

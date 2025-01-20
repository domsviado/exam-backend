<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use Auth;
use Illuminate\Support\Facades\Http;


class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->accessToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}

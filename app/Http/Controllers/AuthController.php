<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('hospitalpersonneluser')->plainTextToken;
            $success['email'] =  $user->email;

            return response()->json(['token' => $success]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }
}

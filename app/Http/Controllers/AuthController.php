<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

            // Vérifier si l'utilisateur doit changer son mot de passe
            if ($user->must_change_password) {
                return response()->json([
                    'message' => 'Vous devez changer votre mot de passe pour pouvoir continuer.',
                    'must_change_password' => true,
                    'token' => $user->createToken('hospital personnel user')->plainTextToken,
                ], 200);
            }

            $success['token'] = $user->createToken('hospital personnel user')->plainTextToken;
            $success['email'] =  $user->email;

            return response()->json(['token' => $success]);
        }

        return response()->json(['message' => 'login ou password incorrect'], 401);
    }

    // Méthode pour changer le mot de passe
    public function changePassword(Request $request)
    { 
        $request->validate([
            'password' => 'required|confirmed',
        ]);
        
        // Mettre à jour le mot de passe de l'utilisateur authentifié
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->must_change_password = false; // L'utilisateur n'a plus besoin de changer le mot de passe
        $user->save();

        return response()->json([
            'message' => 'Password changed successfully'
        ], 200);
    }
}

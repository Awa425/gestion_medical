<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
/**
 * @OA\Post(
 *      path="/api/login",
 *      operationId="login",
 *      tags={"login"},
 *      summary="Se connecter",
 *      description="Se connecter.", 
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Auth")
 *      ),

 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/Auth")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */
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
                    'token' => $user->createToken('hospital personnel user')->plainTextToken,
                    'must_change_password' => true,
                ], 200);
            }

            $success['token'] = $user->createToken('hospital personnel user')->plainTextToken;
            $success['email'] =  $user->email;

            return response()->json(['token' => $success]);
        }

        return response()->json(['message' => 'login ou password incorrect'], 401);
    }

 /**
 * @OA\Post(
 *      path="/api/password/change",
 *      operationId="resetPassword",
 *      tags={"password/change"},
 *      summary="Reset Password",
 *      description="Reinitialiser votre mot de pass.", 
 *      security={{"sanctumAuth":{}}},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/ResetPassword")
 *      ),

 *      @OA\Response(
 *          response=201,
 *          description="Succès",
 *          @OA\JsonContent(ref="#/components/schemas/ResetPassword")
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Erreur de validation"
 *      )
 * )
 */
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
            'message' => 'Password changed successfully',
            'data' => $user
        ], 200);
    }
}

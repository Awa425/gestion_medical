<?php

namespace App\Http\Controllers;

use App\Models\User;
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
 *      description="Permet de se connecter avec un email ou un numéro de téléphone, et un mot de passe.", 
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              required={"identifiant", "password"},
 *              @OA\Property(
 *                  property="identifiant",
 *                  type="string",
 *                  example="exemple@email.com",
 *                  description="Email ou numéro de téléphone de l'utilisateur"
 *              ),
 *              @OA\Property(
 *                  property="password",
 *                  type="string",
 *                  example="passer"
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Connexion réussie",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="token", type="string"),
 *              @OA\Property(property="data", type="object")
 *          )
 *      ),
 *      @OA\Response( 
 *          response=401,
 *          description="Identifiants incorrects"
 *      ),
 *      @OA\Response( 
 *          response=422,
 *          description="Erreur de validation"
 *      )
 * )
 */

 public function login(Request $request)
 {
     // Validation des identifiants
     $credentials = $request->validate([
         'identifiant' => 'required', // Peut être email ou téléphone
         'password' => 'required',
     ]);
 
     // Recherche de l'utilisateur par email ou téléphone
     $user = User::where('email', $credentials['identifiant'])
                 ->orWhere('telephone', $credentials['identifiant'])
                 ->first();
 
     // Vérifie si l'utilisateur existe et si le mot de passe est correct
     if (!$user || !Hash::check($credentials['password'], $user->password)) {
         return response()->json(['message' => 'Identifiants incorrects'], 401);
     }
 
     // Chargement des relations nécessaires
     $user->load('roles', 'personnel.service', 'personnel.qualifications', 'personnel.formations', 'personnel.certifications');
 
     // Vérifie si l'utilisateur est un personnel et doit changer son mot de passe
     if ($user->personnel_id !== null && $user->must_change_password) {
         return response()->json([
             'message' => 'Vous devez changer votre mot de passe pour pouvoir continuer.',
             'token' => $user->createToken('hospital personnel user')->plainTextToken,
             'must_change_password' => true,
             'user' => $user,
         ], 200);
     }
 
     // Génère le token
     $token = $user->createToken('hospital user')->plainTextToken;
 
     return response()->json([
         'token' => $token,
         'data' => $user,
     ], 200);
 }


 /**
 * @OA\Post(
 *      path="/api/password/change",
 *      operationId="resetPassword",
 *      tags={"reset Password"},
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

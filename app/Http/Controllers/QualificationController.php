<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Http\Request;

class QualificationController extends Controller
{

  

    public function removeQualificationFromPersonnel($personnelId, $qualificationId)
    {
        $personnel = Personnel::findOrFail($personnelId);
        $personnel->qualifications()->detach($qualificationId);

        return response()->json(['message' => 'Qualification supprimée avec succès.']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Créer le personnel
        $personnel = Personnel::create($request->only([
            'nom', 
            'prenom', 
            'date_naissance', 
            'adresse', 
            'telephone', 
            'email', 
            'type_personnel_id'
        ]));

        // Assigner les qualifications si elles sont présentes
        if ($request->has('qualifications')) {
            foreach ($request->qualifications as $qualification) {
                $personnel->qualifications()->attach($qualification['qualification_id'], [
                    'date_obtention' => $qualification['date_obtention'] ?? null,
                    'expiration' => $qualification['expiration'] ?? null,
                ]);
            }
        }

        return response()->json([
            'message' => 'Personnel créé avec succès.',
            'personnel' => $personnel->load('qualifications'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TypePersonnel;
use Illuminate\Http\Request;
use App\Utils\FormatData;

class TypePersonnelController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = TypePersonnel::all();
        return FormatData::formatResponse(message: 'Liste des types', data: $types);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Utils\FormatData;
use Illuminate\Http\Request;

class CategorieController extends BaseController
{
    public function index()
    {
        $categories = Categorie::all();
        return FormatData::formatResponse(message: 'Liste des CAtegorie', data: $categories);
    }
}

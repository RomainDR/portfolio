<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{
    // Afficher la page d'accueil
    public function index()
    {
        // Récupérer le dernier projet (celui avec l'id le plus grand)
        $latestProject = Project::select('id', 'title', 'description', 'cover_image')
            ->orderBy('id', 'desc') // Trier par id décroissant
            ->first(); // Récupérer le premier résultat (le dernier projet)

        return view('index', compact('latestProject'));
    }
}

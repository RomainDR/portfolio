<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\ProjectMedia;
use App\Models\Tag;

class ProjectController extends Controller
{
    // Afficher le formulaire protégé par mot de passe
    public function showAddProjectForm(Request $request)
    {
        // Vérifier si le mot de passe est déjà validé
        if ($request->session()->get('password_validated') !== true) {
            return view('password-form');
        }

        // Récupérer tous les tags pour la combobox
        $tags = Tag::all();
        return view('add-project', compact('tags'));
    }

    // Valider le mot de passe
    public function validatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        // Vérifier si le mot de passe est correct
        if ($request->password === env('ADMIN_PASSWORD')) {
            // Stocker la validation du mot de passe en session
            $request->session()->put('password_validated', true);
            return redirect()->route('add-project.form');
        }

        // Rediriger avec un message d'erreur si le mot de passe est incorrect
        return back()->withErrors(['password' => 'Mot de passe incorrect.']);
    }

    // Traiter la soumission du formulaire de projet
    public function handleAddProjectForm(Request $request)
    {
        // Vérifier si le mot de passe est déjà validé
        if ($request->session()->get('password_validated') !== true) {
            return redirect()->route('add-project.form');
        }

        // Valider les données du formulaire
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:png,jpg,jpeg,gif', // Validation pour l'image de couverture
            'media.*' => 'nullable|file|mimes:png,jpg,jpeg,gif,mp4,mkv',
            'tag_id' => 'nullable|exists:tags,id',
            'new_tag' => 'nullable|string|max:255',
        ]);

        // Gérer l'upload de l'image de couverture
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            $coverImagePath = $request->file('cover_image')->store('public/project_covers');
        }

        // Créer le projet
        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'cover_image' => $coverImagePath, // Enregistrer le chemin de l'image de couverture
        ]);

        // Gérer les médias
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $filePath = $file->store('public/project_media');
                $fileType = in_array($file->getClientOriginalExtension(), ['mp4', 'mkv']) ? 'video' : 'image';

                ProjectMedia::create([
                    'project_id' => $project->id,
                    'file_path' => $filePath,
                    'file_type' => $fileType,
                ]);
            }
        }

        // Gérer le tag
        if ($request->filled('new_tag')) {
            $tag = Tag::create(['name' => $request->new_tag]);
            $project->tags()->attach($tag->id);
        } elseif ($request->filled('tag_id')) {
            $project->tags()->attach($request->tag_id);
        }

        // Rediriger vers la page d'accueil avec un message de succès
        return redirect()->route('home')->with('success', 'Projet ajouté avec succès !');
    }
}

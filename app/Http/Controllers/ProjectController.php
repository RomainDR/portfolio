<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\ProjectMedia;
use App\Models\Tag;

class ProjectController extends Controller
{
    // Afficher le formulaire d'ajout de projet
    public function showAddProjectForm(Request $request)
    {
        // Vérifier si le mot de passe est validé
        if ($request->session()->get('password_validated') !== true) {
            return view('password-form'); // Rediriger vers le formulaire de mot de passe
        }

        // Récupérer tous les tags pour les afficher dans le formulaire
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
            $request->session()->put('password_validated', true);
            return redirect()->route('add-project.form');
        }

        // Retourner une erreur si le mot de passe est incorrect
        return back()->withErrors(['password' => 'Mot de passe incorrect.']);
    }

    // Traiter le formulaire d'ajout de projet
    public function handleAddProjectForm(Request $request)
    {
        // Vérifier si le mot de passe est validé
        if ($request->session()->get('password_validated') !== true) {
            return redirect()->route('add-project.form');
        }

        // Valider les données du formulaire
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:gif,webp|max:1000', // Limite à 1 Mo
            'media.*' => 'nullable|file|mimes:webp,gif,mkv|max:1000', // Limite à 1 Mo
            'tag_id' => 'nullable|exists:tags,id',
            'new_tag' => 'nullable|string|max:255',
            'github_link' => 'nullable|url'
        ]);

        // Enregistrer l'image de couverture
        $coverImagePath = null;
        if ($request->hasFile('cover_image')) {
            try {
                $coverImagePath = $request->file('cover_image')->store('project_covers', 'public');
                logger('Cover image stored at: ' . $coverImagePath);
            } catch (\Exception $e) {
                logger('Error storing cover image: ' . $e->getMessage());
                return back()->withErrors(['cover_image' => 'Erreur lors de l\'enregistrement de l\'image.']);
            }
        }

        // Créer le projet
        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'cover_image' => $coverImagePath,
            'github_link' => $request->github_link,
        ]);

        // Enregistrer les médias
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                try {
                    $filePath = $file->store('project_media', 'public');
                    $fileType = in_array($file->getClientOriginalExtension(), ['mkv']) ? 'video' : 'image';

                    ProjectMedia::create([
                        'project_id' => $project->id,
                        'file_path' => $filePath,
                        'file_type' => $fileType,
                    ]);
                } catch (\Exception $e) {
                    logger('Error storing media file: ' . $e->getMessage());
                }
            }
        }

        // Gérer les tags
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

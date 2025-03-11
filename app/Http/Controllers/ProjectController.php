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
            'cover_image' => 'nullable|image|mimes:gif,webp|max:5000',
            'media.*' => 'nullable|file|mimes:webp,gif,mkv|max:5000',
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
    // Afficher la liste des projets
    public function index()
    {
        $projects = Project::with('tags', 'media')->get();
        return view('projects.index', compact('projects'));
    }

    // Afficher le formulaire d'édition d'un projet
    public function edit($id)
    {
        $project = Project::with('tags', 'media')->findOrFail($id);
        $tags = Tag::all();
        return view('projects.edit', compact('project', 'tags'));
    }

    // Mettre à jour un projet
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cover_image' => 'nullable|image|mimes:gif,webp|max:5000',
            'media.*' => 'nullable|file|mimes:webp,gif,mkv|max:5000',
            'tag_id' => 'nullable|exists:tags,id',
            'new_tag' => 'nullable|string|max:255',
            'github_link' => 'required|url'
        ]);

        // Mettre à jour l'image de couverture
        if ($request->hasFile('cover_image')) {
            // Supprimer l'ancienne image si elle existe
            if ($project->cover_image && Storage::disk('public')->exists($project->cover_image)) {
                Storage::disk('public')->delete($project->cover_image);
            }
            // Enregistrer la nouvelle image
            $coverImagePath = $request->file('cover_image')->store('project_covers', 'public');
            $project->cover_image = $coverImagePath;
        }

        // Mettre à jour les médias
        if ($request->hasFile('media')) {
            // Supprimer les anciens médias
            foreach ($project->media as $media) {
                if (Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
                $media->delete();
            }
            // Ajouter les nouveaux médias
            foreach ($request->file('media') as $file) {
                $filePath = $file->store('project_media', 'public');
                $fileType = in_array($file->getClientOriginalExtension(), ['mkv']) ? 'video' : 'image';
                ProjectMedia::create([
                    'project_id' => $project->id,
                    'file_path' => $filePath,
                    'file_type' => $fileType,
                ]);
            }
        }

        // Mettre à jour les tags
        if ($request->filled('new_tag')) {
            $tag = Tag::create(['name' => $request->new_tag]);
            $project->tags()->sync([$tag->id]);
        } elseif ($request->filled('tag_id')) {
            $project->tags()->sync([$request->tag_id]);
        } else {
            $project->tags()->detach();
        }

        // Mettre à jour les autres champs
        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'github_link' => $request->github_link,
        ]);

        return redirect()->route('projects.index')->with('success', 'Projet mis à jour avec succès !');
    }

    // Supprimer un projet
    public function destroy($id)
    {
        $project = Project::findOrFail($id);

        // Supprimer l'image de couverture
        Storage::disk('public')->delete($project->cover_image);

        // Supprimer les médias
        foreach ($project->media as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }

        // Supprimer le projet
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Projet supprimé avec succès !');
    }
}

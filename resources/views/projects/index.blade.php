<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des projets</title>
</head>
<body>
<h1>Liste des projets</h1>
<a href="{{ route('add-project.form') }}">Ajouter un projet</a>
<ul>
    @foreach ($projects as $project)
        <li>
            <h2>{{ $project->title }}</h2>
            <p>{{ $project->description }}</p>
            <a href="{{ route('projects.edit', $project->id) }}">Éditer</a>
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </li>
    @endforeach
</ul>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <style>
        .project {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        .project img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<h1>Bienvenue sur mon portfolio</h1>
<p>Voici la page d'accueil.</p>

@if (session('success'))
    <div style="color: green;">
        {{ session('success') }}
    </div>
@endif

<h2>Dernier projet ajouté</h2>
@if ($latestProject)
    <div class="project">
        <h3>{{ $latestProject->title }}</h3>
        @if ($latestProject->cover_image)
            <img src="{{ asset($latestProject->cover_image) }}" alt="{{ $latestProject->title }}">
        @else
            <p>Aucune image de couverture disponible.</p>
        @endif
        <p>{{ $latestProject->description }}</p>
    </div>
@else
    <p>Aucun projet disponible pour le moment.</p>
@endif
</body>
</html>

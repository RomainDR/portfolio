<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<script src="{{ asset('js/app.js') }}" defer></script>
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

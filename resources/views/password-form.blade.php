<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès protégé</title>
</head>
<body>
<h1>Accès protégé</h1>
<form action="{{ route('validate-password') }}" method="POST">
    @csrf
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required>
    <button type="submit">Valider</button>
</form>

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</body>
</html>

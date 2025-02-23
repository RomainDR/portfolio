<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un projet</title>
</head>
<body>
<h1>Ajouter un projet</h1>
<form action="{{ route('add-project.submit') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="cover_image">Image de couverture :</label>
        <input type="file" name="cover_image" id="cover_image" accept="image/*">
    </div>
    <div>
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" required>
    </div>
    <div>
        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>
    </div>
    <div class="form-group">
        <label for="github_link">GitHub Link</label>
        <input type="url" class="form-control" id="github_link" name="github_link" placeholder="Enter GitHub link">
    </div>
    <div>
        <label for="media">Médias (images, vidéos, GIF) :</label>
        <input type="file" name="media[]" id="media" multiple>
    </div>
    <div>
        <label for="tag_id">Tag :</label>
        <select name="tag_id" id="tag_id">
            <option value="">Sélectionner un tag</option>
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
            @endforeach
        </select>
        <button type="button" onclick="addNewTag()">Créer un nouveau tag</button>
    </div>
    <div id="new-tag-container" style="display: none;">
        <label for="new_tag">Nouveau tag :</label>
        <input type="text" name="new_tag" id="new_tag">
    </div>
    <button type="submit">Ajouter le projet</button>
</form>

<script>
    function addNewTag() {
        document.getElementById('new-tag-container').style.display = 'block';
    }
</script>
</body>
</html>

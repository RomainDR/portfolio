<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer un projet</title>
    <style>
        .alert-danger { color: red; }
    </style>
</head>
<body>
<h1>Éditer un projet</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label for="cover_image">Image de couverture :</label>
        <input type="file" name="cover_image" id="cover_image" accept="image/*">
        @if ($project->cover_image)
            <img src="{{ asset('storage/' . $project->cover_image) }}" alt="Cover Image" style="max-width: 200px;">
        @endif
    </div>
    <div>
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" value="{{ $project->title }}" required>
    </div>
    <div>
        <label for="description">Description :</label>
        <textarea name="description" id="description" required>{{ $project->description }}</textarea>
    </div>
    <div>
        <label for="github_link">Lien GitHub :</label>
        <input type="url" name="github_link" id="github_link" value="{{ $project->github_link }}" placeholder="Entrez le lien GitHub">
    </div>
    <div>
        <label for="media">Médias (images, vidéos, GIF) :</label>
        <input type="file" name="media[]" id="media" multiple>
        @foreach ($project->media as $media)
            <div>
                @if ($media->file_type === 'video')
                    <video src="{{ asset('storage/' . $media->file_path) }}" controls style="max-width: 200px;"></video>
                @else
                    <img src="{{ asset('storage/' . $media->file_path) }}" alt="Media" style="max-width: 200px;">
                @endif
            </div>
        @endforeach
    </div>
    <div>
        <label for="tag_id">Tag :</label>
        <select name="tag_id" id="tag_id">
            <option value="">Sélectionner un tag</option>
            @foreach ($tags as $tag)
                <option value="{{ $tag->id }}" {{ $project->tags->contains($tag->id) ? 'selected' : '' }}>{{ $tag->name }}</option>
            @endforeach
        </select>
        <button type="button" onclick="addNewTag()">Créer un nouveau tag</button>
    </div>
    <div id="new-tag-container" style="display: none;">
        <label for="new_tag">Nouveau tag :</label>
        <input type="text" name="new_tag" id="new_tag">
    </div>
    <button type="submit">Mettre à jour le projet</button>
</form>

<script>
    function addNewTag() {
        document.getElementById('new-tag-container').style.display = 'block';
    }
</script>
</body>
</html>

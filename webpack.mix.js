const mix = require('laravel-mix');

// Compiler SCSS en CSS
mix.sass('resources/scss/app.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .options({
        processCssUrls: false // Désactiver le traitement des URLs dans les fichiers CSS
    });

// Activer la versioning pour le cache busting (optionnel)
if (mix.inProduction()) {
    mix.version();
}

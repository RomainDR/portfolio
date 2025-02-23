const mix = require('laravel-mix');
const CopyWebpackPlugin = require('copy-webpack-plugin');

// Configuration pour copier les images
mix.webpackConfig({
    plugins: [
        new CopyWebpackPlugin({
            patterns: [
                {
                    from: 'resources/images', // Dossier source
                    to: 'resources/images', // Dossier de destination
                },
            ],
        }),
    ],
});

// Compiler les assets
mix
    .sass('resources/scss/app.scss', 'public/css')
    .sass('resources/scss/index.scss', 'public/css')
    .js('resources/js/app.js', 'public/js')
    .js('resources/js/index.js', 'public/js')
    .js('resources/js/node-background.js', 'public/js')
;
/*.options({
    processCssUrls: false // Désactiver le traitement des URLs dans les fichiers CSS
});*/
/*
// Activer la versioning pour le cache busting (optionnel)
if (mix.inProduction()) {
    mix.version();
}
*/

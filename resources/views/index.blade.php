<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="{{ asset('resources/css/index.css') }}" rel="stylesheet">
</head>
<body>
<div class="content">
    <canvas id="background-canvas"></canvas> <!-- Canvas pour l'arrière-plan -->
    <script src="{{ asset('resources/js/index.js') }}" defer></script>
    <section id="presentation">
        <div id="information">
            <div id="header-information">
                <h1 class="name space-letter">Romain DROUHOT</h1>
                <p class="about-work space-letter">Développeur Interface Utilisateur (UI) et Outils (Tools)</p>
            </div>
            <div id="about-me">
                <p>Je m’appelle Romain, j’ai <?php echo date("Y") - 2002 ?> ans, et je suis développeur d’interface utilisateur (UI) ainsi que créateur d’outils logiciels dans divers domaines.</p>
                <p>Grâce à ma formation en programmation de jeux vidéos (Gameplay Programmer) et en service informatique aux organisations, j’ai acquis une bonne maîtrise de plusieurs langages, dont le C++, Python, et C#. J’ai également enrichi mes compétences en autodidacte avec d’autres technologies.</p>
                <p>Ce portfolio présente les projets que j’ai pu réaliser pendant ma formation ou divers projets personnels hors formation.</p>
            </div>
        </div>
        <div id="profile">
            <img src="{{ asset('resources/images/pdp.webp') }}" alt="My profile" class="pdp">
        </div>
    </section>
    <section id="last-project">
        <div id="header">
opseofpose
        </div>
    </section>
</div>
</body>
</html>

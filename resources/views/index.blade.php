<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="{{ asset('js/index.js') }}" defer></script>
</head>
<body>
<div class="content">
    <canvas id="background-canvas"></canvas>
    <script src="{{ asset('js/node-background.js') }}" defer></script>

    <section id="presentation">
        <div data-aos="fade-right" data-aos-duration="500" id="information">
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
        <div data-aos="fade-left" data-aos-duration="500" id="profile" >
            <img src="{{ asset('resources/images/pdp.webp') }}" alt="My profile" class="pdp">
        </div>
    </section>
    <section data-aos="fade-up" data-aos-duration="1000" id="last-project">
        <div id="project-header">
            <h1>Mes derniers projets</h1>
        </div>
        <div id="projects">
            <!-- make carrousel here -->
        </div>
    </section>
</div>
</body>
</html>

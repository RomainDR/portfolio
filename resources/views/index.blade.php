<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
                <p>Je m’appelle Romain, j’ai <?php echo date("Y") - 2002 ?> ans, et je suis développeur d’interface
                    utilisateur (UI) ainsi que créateur d’outils logiciels dans divers domaines.</p>
                <p>Grâce à ma formation en programmation de jeux vidéos (Gameplay Programmer) et en service informatique
                    aux organisations, j’ai acquis une bonne maîtrise de plusieurs langages, dont le C++, Python, et C#.
                    J’ai également enrichi mes compétences en autodidacte avec d’autres technologies.</p>
                <p>Ce portfolio présente les projets que j’ai pu réaliser pendant ma formation ou divers projets
                    personnels hors formation.</p>
            </div>
            <div class="more-information">
                <a href="#projects" class="button">
                    Mes projets
                </a>
                <a href="#contact-me" class="button">
                    Me contacter
                </a>
            </div>
        </div>
        <div data-aos="fade-left" data-aos-duration="500" id="profile">
            <img src="{{ asset('resources/images/pdp.webp') }}" alt="My profile" class="pdp">
        </div>
    </section>

    <section id="projects">
        <div id="project-header">
            <h1>Mes projets</h1>
        </div>
        <div id="projects-grid">
            <div class="container">
                @foreach($projects as $project)
                    <div class="project"
                         style="background-image: url('{{ asset('storage/' . $project->cover_image) }}');"
                         data-link="{{ $project->github_link }}">
                        <div class="overlay"></div>
                        <div class="content">
                            <h2 class="title">{{ $project->title }}</h2>
                            <p class="description">{{ $project->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="contact-me">
        <h2>Contactez-moi</h2>
        <div class="content">
            <div class="left-side">
                <div class="contact-info">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:romain.drouhot@orange.fr">romain.drouhot@orange.fr</a>
                </div>
                <div class="contact-info">
                    <i class="fas fa-phone"></i>
                    <a href="tel:+33666617576">06.66.61.75.76</a>
                </div>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i>
                        Campus de Bissy,
                        34980, Saint-Clement-De-Rivière
                    </p>
                </div>
            </div>
            <div class="right-side">
                <iframe width="100%" height="400" id="gmap_canvas"
                        src="https://maps.google.com/maps?width=520&amp;height=400&amp;hl=en&amp;q=Campus%20de%20bissy%20Saint%20clement%20de%20riviere+(Location)&amp;t=&amp;z=13&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
            </div>
        </div>
    </section>
</div>

<script src="{{ asset('js/index.js') }}" defer></script>
</body>
</html>

import './app';

document.addEventListener('DOMContentLoaded', function () {
    const projects = document.querySelectorAll('.project');

    projects.forEach(project => {
        project.addEventListener('click', function () {
            // Récupérer le lien GitHub depuis l'attribut data-link
            const githubLink = project.getAttribute('data-link');

            // Rediriger l'utilisateur vers le lien GitHub
            if (githubLink) {
                window.location.href = githubLink;
            }
        });
    });
});

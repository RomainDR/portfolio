import './app'

document.addEventListener('DOMContentLoaded', function() {
    const projects = document.querySelectorAll('.project');
    const popup = document.getElementById('project-popup');
    const closePopup = document.querySelector('.close-popup');
    const carousel = document.querySelector('.carousel');
    const popupDescription = document.getElementById('popup-description');
    const githubLink = document.getElementById('github-link');

    projects.forEach(project => {
        project.addEventListener('click', function() {
            const media = JSON.parse(project.getAttribute('data-media'));
            const description = project.getAttribute('data-description');
            const link = project.getAttribute('data-link');

            // Clear previous carousel content
            carousel.innerHTML = '';

            // Add new media to carousel
            media.forEach(item => {
                if (item.type === 'image') {
                    const img = document.createElement('img');
                    img.src = item.url;
                    carousel.appendChild(img);
                } else if (item.type === 'video') {
                    const video = document.createElement('video');
                    video.src = item.url;
                    video.controls = true;
                    carousel.appendChild(video);
                }
            });

            // Set description and link
            popupDescription.textContent = description;
            githubLink.href = link;

            // Show popup
            popup.style.display = 'flex';
        });
    });

    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });

    popup.addEventListener('click', function(event) {
        if (event.target === popup) {
            popup.style.display = 'none';
        }
    });
});

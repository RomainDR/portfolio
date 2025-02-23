document.addEventListener('DOMContentLoaded', () => {

    if(window.innerWidth > 1024) {
        const canvas = document.getElementById('background-canvas');
        const ctx = canvas.getContext('2d');

        // Ajuster la taille du canvas à la taille de la fenêtre
        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }

        resizeCanvas();

        // Liste de mots aléatoires
        const words = [
            "Laravel", "JavaScript", "CSS", "HTML", "PHP", "Docker", "C++",
            "Github", "SASS", "API", "SQL", "Git", "Docker", "UI/UX", "Unreal Engine",
            "Unity", "Java", "Minecraft", "Tools", "WPF", "C#", "NoSQL", "Intellij", "Rider", "Datagrip"
        ];

        // Configuration des nœuds
        const nodes = [];
        const numNodes = 50; // Nombre de nœuds
        const maxDistance = 150; // Distance maximale pour relier les nœuds
        const mouse = {x: null, y: null, radius: 300}; // Zone d'influence de la souris

        // Créer des nœuds aléatoires
        class Node {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.vx = Math.random() * 2 - 1; // Vitesse horizontale aléatoire
                this.vy = Math.random() * 2 - 1; // Vitesse verticale aléatoire
                this.word = words[Math.floor(Math.random() * words.length)]; // Mot aléatoire
            }

            // Mettre à jour la position du nœud
            update() {
                // Mettre à jour la position normale
                this.x += this.vx;
                this.y += this.vy;

                // Rebondir sur les bords du canvas
                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
            }

            // Dessiner le nœud (texte au lieu d'un cercle)
            draw() {
                ctx.font = '14px Arial'; // Taille et police du texte
                ctx.fillStyle = '#ffffff'; // Couleur du texte
                ctx.textAlign = 'center'; // Centrer le texte horizontalement
                ctx.textBaseline = 'middle'; // Centrer le texte verticalement
                ctx.fillText(this.word, this.x, this.y); // Dessiner le texte
            }
        }

        // Initialiser les nœuds
        for (let i = 0; i < numNodes; i++) {
            const x = Math.random() * canvas.width;
            const y = Math.random() * canvas.height;
            nodes.push(new Node(x, y));
        }

        // Fonction pour dessiner les liens entre les nœuds
        function drawLinks() {
            // Dessiner les liens entre les nœuds
            for (let i = 0; i < nodes.length; i++) {
                for (let j = i + 1; j < nodes.length; j++) {
                    const dx = nodes[i].x - nodes[j].x;
                    const dy = nodes[i].y - nodes[j].y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < maxDistance) {
                        ctx.beginPath();
                        ctx.moveTo(nodes[i].x, nodes[i].y);
                        ctx.lineTo(nodes[j].x, nodes[j].y);
                        ctx.strokeStyle = `rgba(255, 255, 255, ${1 - distance / maxDistance})`; // Liens blancs
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                }
            }

            // Dessiner des liens entre la souris et les nœuds proches
            if (mouse.x !== null && mouse.y !== null) {
                nodes.forEach(node => {
                    const dx = node.x - mouse.x;
                    const dy = node.y - mouse.y;
                    const distance = Math.sqrt(dx * dx + dy * dy);

                    if (distance < mouse.radius) {
                        ctx.beginPath();
                        ctx.moveTo(node.x, node.y);
                        ctx.lineTo(mouse.x, mouse.y);
                        ctx.strokeStyle = `rgba(255, 255, 255, ${1 - distance / mouse.radius})`; // Liens blancs
                        ctx.lineWidth = 1;
                        ctx.stroke();
                    }
                });
            }
        }

        // Fonction pour animer les nœuds
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Mettre à jour et dessiner chaque nœud
            nodes.forEach(node => {
                node.update();
                node.draw();
            });

            // Dessiner les liens
            drawLinks();

            // Répéter l'animation
            requestAnimationFrame(animate);
        }

        // Démarrer l'animation
        animate();

        // Redimensionner le canvas lorsque la fenêtre est redimensionnée ou lors du défilement
        window.addEventListener('resize', resizeCanvas);
        window.addEventListener('scroll', resizeCanvas);

        // Suivre la position de la souris
        window.addEventListener('mousemove', (e) => {
            mouse.x = e.clientX;
            mouse.y = e.clientY;
        });

        // Réinitialiser la position de la souris lorsqu'elle quitte le canvas
        window.addEventListener('mouseout', () => {
            mouse.x = null;
            mouse.y = null;
        });
    }
});

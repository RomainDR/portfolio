/******/ (() => { // webpackBootstrap
/*!*****************************************!*\
  !*** ./resources/js/node-background.js ***!
  \*****************************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
document.addEventListener('DOMContentLoaded', function () {
  if (window.innerWidth > 1024) {
    // Ajuster la taille du canvas à la taille de la fenêtre
    var resizeCanvas = function resizeCanvas() {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
    };
    // Fonction pour dessiner les liens entre les nœuds
    var drawLinks = function drawLinks() {
      // Dessiner les liens entre les nœuds
      for (var _i = 0; _i < nodes.length; _i++) {
        for (var j = _i + 1; j < nodes.length; j++) {
          var dx = nodes[_i].x - nodes[j].x;
          var dy = nodes[_i].y - nodes[j].y;
          var distance = Math.sqrt(dx * dx + dy * dy);
          if (distance < maxDistance) {
            ctx.beginPath();
            ctx.moveTo(nodes[_i].x, nodes[_i].y);
            ctx.lineTo(nodes[j].x, nodes[j].y);
            ctx.strokeStyle = "rgba(255, 255, 255, ".concat(1 - distance / maxDistance, ")"); // Liens blancs
            ctx.lineWidth = 1;
            ctx.stroke();
          }
        }
      }

      // Dessiner des liens entre la souris et les nœuds proches
      if (mouse.x !== null && mouse.y !== null) {
        nodes.forEach(function (node) {
          var dx = node.x - mouse.x;
          var dy = node.y - mouse.y;
          var distance = Math.sqrt(dx * dx + dy * dy);
          if (distance < mouse.radius) {
            ctx.beginPath();
            ctx.moveTo(node.x, node.y);
            ctx.lineTo(mouse.x, mouse.y);
            ctx.strokeStyle = "rgba(255, 255, 255, ".concat(1 - distance / mouse.radius, ")"); // Liens blancs
            ctx.lineWidth = 1;
            ctx.stroke();
          }
        });
      }
    }; // Fonction pour animer les nœuds
    var _animate = function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      // Mettre à jour et dessiner chaque nœud
      nodes.forEach(function (node) {
        node.update();
        node.draw();
      });

      // Dessiner les liens
      drawLinks();

      // Répéter l'animation
      requestAnimationFrame(_animate);
    }; // Démarrer l'animation
    var canvas = document.getElementById('background-canvas');
    var ctx = canvas.getContext('2d');
    resizeCanvas();

    // Liste de mots aléatoires
    var words = ["Laravel", "JavaScript", "CSS", "HTML", "PHP", "Docker", "C++", "Github", "SASS", "API", "SQL", "Git", "Docker", "UI/UX", "Unreal Engine", "Unity", "Java", "Minecraft", "Tools", "WPF", "C#", "NoSQL", "Intellij", "Rider", "Datagrip"];

    // Configuration des nœuds
    var nodes = [];
    var numNodes = 50; // Nombre de nœuds
    var maxDistance = 200; // Distance maximale pour relier les nœuds
    var mouse = {
      x: null,
      y: null,
      radius: 300
    }; // Zone d'influence de la souris

    // Créer des nœuds aléatoires
    var Node = /*#__PURE__*/function () {
      function Node(x, y) {
        _classCallCheck(this, Node);
        this.x = x;
        this.y = y;
        this.vx = Math.random() * 2 - 1; // Vitesse horizontale aléatoire
        this.vy = Math.random() * 2 - 1; // Vitesse verticale aléatoire
        this.word = words[Math.floor(Math.random() * words.length)]; // Mot aléatoire
      }

      // Mettre à jour la position du nœud
      return _createClass(Node, [{
        key: "update",
        value: function update() {
          // Mettre à jour la position normale
          this.x += this.vx;
          this.y += this.vy;

          // Rebondir sur les bords du canvas
          if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
          if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
        }

        // Dessiner le nœud (texte au lieu d'un cercle)
      }, {
        key: "draw",
        value: function draw() {
          ctx.font = '14px Arial'; // Taille et police du texte
          ctx.fillStyle = '#ffffff'; // Couleur du texte
          ctx.textAlign = 'center'; // Centrer le texte horizontalement
          ctx.textBaseline = 'middle'; // Centrer le texte verticalement
          ctx.fillText(this.word, this.x, this.y); // Dessiner le texte
        }
      }]);
    }(); // Initialiser les nœuds
    for (var i = 0; i < numNodes; i++) {
      var x = Math.random() * canvas.width;
      var y = Math.random() * canvas.height;
      nodes.push(new Node(x, y));
    }
    _animate();

    // Redimensionner le canvas lorsque la fenêtre est redimensionnée ou lors du défilement
    window.addEventListener('resize', resizeCanvas);
    window.addEventListener('scroll', resizeCanvas);

    // Suivre la position de la souris
    window.addEventListener('mousemove', function (e) {
      mouse.x = e.clientX;
      mouse.y = e.clientY;
    });

    // Réinitialiser la position de la souris lorsqu'elle quitte le canvas
    window.addEventListener('mouseout', function () {
      mouse.x = null;
      mouse.y = null;
    });
  }
});
/******/ })()
;
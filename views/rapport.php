<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques et Progressions</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <style>
      :root {
    --primary-color: #4CAF50;
    --secondary-color: #2ecc71;
    --background-color: #f7f7f7;
    --box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #dcb253;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            font-size: 2.5rem;
            margin: 20px 0;
            color: black;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background: RGB( 240, 240, 242 );
            padding: 20px;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-box {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 30%;
            box-shadow: var(--box-shadow);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .stat-box:hover {
            transform: translateY(-5px);
        }

        .stat-box h2 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        canvas {
            margin-top: 40px;
            max-width: 100%;
        }

        .progress-bar-container {
            width: 100%;
            background: #ddd;
            border-radius: 25px;
            margin-top: 40px;
            overflow: hidden;
        }

        .progress-bar {
            height: 30px;
            width: 0;
            background-color: var(--primary-color);
            border-radius: 25px;
            transition: width 1s ease;
            position: relative;
        }

        .progress-bar::after {
            content: attr(data-progress) '%';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
        }

        .floating-menu {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--secondary-color);
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
            box-shadow: var(--box-shadow);
        }

        .floating-menu:hover {
            transform: scale(1.1);
            background-color: #0056b3;
        }

        .floating-menu-items {
            display: none;
            position: absolute;
            right: 70px;
            bottom: 0;
            list-style: none;
            padding: 0;
        }

        .floating-menu-items li {
            margin-bottom: 10px;
        }

        .floating-menu-items a {
            background-color: var(--secondary-color);
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            display: block;
        }

        .floating-menu-items a:hover {
            background-color: #0056b3;
        }

        .floating-menu.active + .floating-menu-items {
            display: block;
        }

        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
            }
            .stat-box {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

    <h1>Statistiques et Progressions</h1>
    <div class="container">
        <div class="stats">
            <div class="stat-box" id="projetsBox">
                <h2 id="compteur1">0</h2>
                <p>Projets réalisés</p>
            </div>
            <div class="stat-box" id="clientsBox">
                <h2 id="compteur2">0</h2>
                <p>Clients satisfaits</p>
            </div>
            <div class="stat-box" id="tachesBox">
                <h2 id="compteur3">0</h2>
                <p>Tâches accomplies</p>
            </div>
        </div>

        <canvas id="myChart"></canvas>

        <div class="progress-bar-container">
            <div class="progress-bar" id="progressBar" data-progress="0"></div>
        </div>
    </div>

    <div class="floating-menu" id="menuBtn">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="floating-menu-items" id="menuItems">
        <li><a href="#projetsBox">Projets</a></li>
        <li><a href="#clientsBox">Clients</a></li>
        <li><a href="#tachesBox">Tâches</a></li>
    </ul>

    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    <script>
        function animateCounter(id, target) {
            let compteur = document.getElementById(id);
            let count = 0;
            gsap.to(compteur, {
                innerHTML: target,
                duration: 2,
                snap: { innerHTML: 1 },
                ease: "power1.inOut"
            });
        }

        function animateProgressBar(target) {
            let progressBar = document.getElementById("progressBar");
            gsap.to(progressBar, {
                width: target + "%",
                duration: 2,
                ease: "power1.inOut",
                onUpdate: function() {
                    progressBar.setAttribute('data-progress', Math.round(this.progress() * target));
                }
            });
        }

        window.onload = function() {
            animateCounter('compteur1', 120);
            animateCounter('compteur2', 300);
            animateCounter('compteur3', 850);
            animateProgressBar(80);

            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'],
                    datasets: [{
                        label: 'Nombre de ventes',
                        data: [10, 20, 30, 40, 50, 60],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 2000,
                        easing: 'easeInOutQuart'
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        };

        const menuBtn = document.getElementById('menuBtn');
        const menuItems = document.getElementById('menuItems');
        menuBtn.addEventListener('click', () => {
            menuBtn.classList.toggle('active');
            gsap.to(menuItems, {
                display: menuItems.style.display === 'block' ? 'none' : 'block',
                opacity: menuItems.style.display === 'block' ? 0 : 1,
                duration: 0.3
            });
        });

        document.querySelectorAll('.stat-box').forEach(box => {
            box.addEventListener('mouseenter', () => {
                gsap.to(box, {
                    y: -10,
                    boxShadow: '0 6px 12px rgba(0,0,0,0.15)',
                    duration: 0.3
                });
            });
            box.addEventListener('mouseleave', () => {
                gsap.to(box, {
                    y: 0,
                    boxShadow: '0 4px 8px rgba(0,0,0,0.1)',
                    duration: 0.3
                });
            });
        });
    </script>
</body>
</html>
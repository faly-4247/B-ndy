<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "Plantation Mangrove"; ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <nav class="bg-mangrove p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="images/web.webp" alt="Logo" class="w-12 h-12 object-contain mr-4">
                <h1 class="text-white text-2xl font-bold">Suivi Mangrove</h1>
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="index.php" class="text-white nav-link">Accueil</a>
                <a href="Plantation_Stock.php" class="text-white nav-link">Stocks et Plantation</a>
                <a href="parcelle_liste.php" class="text-white nav-link">Parcelle</a>
                <a href="rapport.php" class="text-white nav-link">Rapports</a>
            </div>
            <button class="md:hidden text-white">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </nav>

    <main class="container mx-auto mt-8 p-4">
        <!-- En-tête animé -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-4xl font-bold text-mangrove mb-4">Gestion des Plantations de Mangroves</h1>
            <p class="text-black-600 text-lg">Surveillance et suivi écologique pour un avenir durable</p>
        </div>

        <!-- Cartes principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div class="card bg-white rounded-lg shadow-lg p-6 border-l-4 border-mangrove animate-slide-up" style="animation-delay: 0.1s">
                <div class="flex items-center mb-4">
                    <i class="fas fa-seedling text-3xl text-mangrove mr-4"></i>
                    <h2 class="text-xl font-semibold text-mangrove">Gestion des Stocks</h2>
                </div>
                <p class="mb-4 text-gray-600">Suivez en temps réel la disponibilité des plants de mangrove et optimisez votre inventaire.</p>
                <a href="Liste.php" class="bg-mangrove text-white py-2 px-4 rounded hover-bg-mangrove transition-all inline-block">
                    <i class="fas fa-arrow-right mr-2"></i>Voir les stocks
                </a>
            </div>

            <div class="card bg-white rounded-lg shadow-lg p-6 border-l-4 border-mangrove animate-slide-up" style="animation-delay: 0.2s">
                <div class="flex items-center mb-4">
                    <i class="fas fa-tree text-3xl text-mangrove mr-4"></i>
                    <h2 class="text-xl font-semibold text-mangrove">Gestion des Plantations</h2>
                </div>
                <p class="mb-4 text-black-600">Gérez et suivez les différentes parcelles de plantations pour assurer leur croissance optimale.</p>
                <a href="Gestion.php" class="bg-mangrove text-white py-2 px-4 rounded hover-bg-mangrove transition-all inline-block">
                    <i class="fas fa-arrow-right mr-2"></i>Voir les plantations
                </a>
            </div>

               <!-- Nouvelle Carte : Gestion des Parcelles -->
               <div class="card bg-white rounded-lg shadow-lg p-6 border-l-4 border-mangrove animate-slide-up" style="animation-delay: 0.3s">
                <div class="flex items-center mb-4">
                    <i class="fas fa-map-marked-alt text-3xl text-mangrove mr-4"></i>
                    <h2 class="text-xl font-semibold text-mangrove">Gestion des Parcelles</h2>
                </div>
                <p class="mb-4 text-black-600">Supervisez et gérez efficacement vos parcelles de mangroves pour optimiser leur développement.</p>
                <a href="parcelle.php" class="bg-mangrove text-white py-2 px-4 rounded hover-bg-mangrove transition-all inline-block">
                    <i class="fas fa-arrow-right mr-2"></i>Gérer les parcelles
                </a>
            </div>

            <div class="card bg-white rounded-lg shadow-lg p-6 border-l-4 border-mangrove animate-slide-up" style="animation-delay: 0.3s">
                <div class="flex items-center mb-4">
                    <i class="fas fa-chart-line text-3xl text-mangrove mr-4"></i>
                    <h2 class="text-xl font-semibold text-mangrove">Analyse et Rapports</h2>
                </div>
                <p class="mb-4 text-black-600">Générez des graphiques et des rapports détaillés pour une vision claire de vos progrès.</p>
                <a href="rapport.php" class="bg-mangrove text-white py-2 px-4 rounded hover-bg-mangrove transition-all inline-block">
                    <i class="fas fa-arrow-right mr-2"></i>Accéder aux rapports
                </a>
            </div>
        </div>
      


        <!-- Tableau de bord -->
        <h2 class="text-2xl font-bold mb-6 text-mangrove flex items-center">
            <i class="fas fa-tachometer-alt mr-3"></i>Tableau de Bord
        </h2>
        <div class="responsive-grid mb-12">
            <!-- Graphique des stocks -->
            <div class="bg-white rounded-lg shadow-lg p-6 animate-slide-up" style="animation-delay: 0.4s">
                <h3 class="text-lg font-semibold mb-4 text-mangrove flex items-center">
                    <i class="fas fa-chart-bar mr-2"></i>Niveau des Stocks
                </h3>

                <!-- aggrandissement image -->
                <div id="imageContainer" class="chart-container relative">
        <img src="./images/mangrove" alt="Graphique des stocks" class="w-full h-64 object-cover rounded-lg">
        <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center rounded-lg">
            <button id="expandBtn" class="bg-white text-mangrove py-2 px-4 rounded hover:bg-gray-100 transition-all">
                <i class="fas fa-expand-alt mr-2"></i>Agrandir
            </button>
        </div>
    </div>
            </div>

            <!-- Statistiques des plantations -->
            <div class="bg-white rounded-lg shadow-lg p-6 animate-slide-up" style="animation-delay: 0.5s">
                <h3 class="text-lg font-semibold mb-4 text-mangrove flex items-center">
                    <i class="fas fa-clipboard-list mr-2"></i>Statistiques des Plantations
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="stats-card p-4 text-center bg-gray-50 rounded-lg">
                        <i class="fas fa-map-marked-alt text-2xl text-mangrove mb-2"></i>
                        <div class="stats-number">120</div>
                        <p class="text-gray-600">Parcelles</p>
                    </div>
                    <div class="stats-card p-4 text-center bg-gray-50 rounded-lg">
                        <i class="fas fa-seedling text-2xl text-mangrove mb-2"></i>
                        <div class="stats-number">5,70</div>
                        <p class="text-gray-600">Plants ce mois</p>
                    </div>
                    <div class="stats-card p-4 text-center bg-gray-50 rounded-lg">
                        <i class="fas fa-percentage text-2xl text-mangrove mb-2"></i>
                        <div class="stats-number">87%</div>
                        <p class="text-gray-600">Taux de survie</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-mangrove text-white py-6">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">À propos</h3>
                    <p class="text-gray-300">Projet de gestion et suivi des plantations de mangroves pour la préservation de notre écosystème côtier.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="Gestion.php" class="text-gray-300 hover:text-white transition-colors">Stocks</a></li>
                        <li><a href="Liste.php" class="text-gray-300 hover:text-white transition-colors">Plantations</a></li>
                        <li><a href="rapport.php" class="text-gray-300 hover:text-white transition-colors">Rapports</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <p class="text-gray-300"><i class="fas fa-envelope mr-2"></i>falimananajulia@gmail.com</p>
                    <p class="text-gray-300"><i class="fas fa-phone mr-2"></i>0331928036</p>
                </div>
            </div>
            <div class="border-t border-gray-600 mt-8 pt-4 text-center">
                <p>&copy; 2024 Gestion et Suivi de Plantation Mangrove. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des statistiques au survol
            const statsCards = document.querySelectorAll('.stats-card');
            statsCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    const number = this.querySelector('.stats-number');
                    number.style.transform = 'scale(1.1)';
                });
                card.addEventListener('mouseleave', function() {
                    const number = this.querySelector('.stats-number');
                    number.style.transform = 'scale(1)';
                });
            });
        });
    </script>
    <!-- script pour agrandir l'image -->
    <script>
        const imageContainer = document.getElementById('imageContainer');
        const expandBtn = document.getElementById('expandBtn');
        const img = imageContainer.querySelector('img');

        expandBtn.addEventListener('click', () => {
            const fullscreenDiv = document.createElement('div');
            fullscreenDiv.className = 'fullscreen';
            
            const closeBtn = document.createElement('span');
            closeBtn.innerHTML = '&times;';
            closeBtn.className = 'close-btn';
            
            const fullImg = img.cloneNode();
            fullImg.removeAttribute('class');
            
            fullscreenDiv.appendChild(fullImg);
            fullscreenDiv.appendChild(closeBtn);
            document.body.appendChild(fullscreenDiv);

            closeBtn.addEventListener('click', () => {
                document.body.removeChild(fullscreenDiv);
            });
        });
    </script>
</body>
</html>
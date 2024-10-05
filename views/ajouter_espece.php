<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Espèce de Mangrove</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/ajouter_espece.css">
</head>
<body>
    <div class="form-container fade-in">
        <h2><i class="fas fa-leaf"></i> Nouvelle Espèce de Mangrove</h2>
        
        <form action="Backend_ajouter_espece.php" method="POST" enctype="multipart/form-data" id="addSpeciesForm">
            <div class="form-group">
                <label for="nom_espece"><i class="fas fa-signature"></i> Nom de l'espèce :</label>
                <input type="text" id="nom_espece" name="nom_espece" placeholder="Entrez le nom de l'espèce" required>
            </div>
           
            <div class="form-group">
                <label for="file_espece"><i class="fas fa-file-upload"></i> Fichier (Image ou Document) :</label>
                <div class="file-input-wrapper">
                    <div class="file-input-button">Choisir un fichier</div>
                    <input type="file" id="file_espece" name="file_espece" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
                <div class="file-name" id="file-name"></div>
            </div>
           
            <button type="submit"><i class="fas fa-plus-circle"></i> Ajouter l'Espèce</button>
        </form>
    </div>

    <script>
        document.getElementById('file_espece').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            document.getElementById('file-name').textContent = fileName;
        });

        document.getElementById('addSpeciesForm').addEventListener('submit', function(e) {
            // Ne pas empêcher la soumission par défaut du formulaire
            // Le formulaire sera envoyé normalement au backend
        });
    </script>
</body>
</html>
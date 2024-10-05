<?php
// modifier_parcelle.php
session_start();// Assurez-vous que ce fichier contient vos informations de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $surface = $_POST['surface'];

    // Préparez la requête SQL
    $sql = "UPDATE parcelle SET nom = '$nom', surface = '$surface' WHERE id = '$id'";
    
    // Préparez et exécutez la requête

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "La parcelle a été modifiée avec succès.";
        header("Location: parcelle_liste.php"); // Redirigez vers la liste des parcelles
        exit();
    } else {
        echo "Erreur lors de l'ajout : " . $conn->error;
    }
    
    
} else {
    // Si c'est une requête GET, récupérez les informations de la parcelle pour les afficher dans le formulaire
    if (!is_object($conn)) {
        die("Erreur de connexion à la base de données");
    }
    
    $id_espece = isset($_GET['id']) ? $_GET['id'] : null;
    
    if ($id_espece) {
        $sql = "SELECT * FROM parcelle WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_espece);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $parcelle = $result->fetch_assoc();
        } else {
            die("Espèce non trouvée");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une parcelle</title>
    <link rel="stylesheet" href="./assets/css/modifier_parcelle.css">
</head>
<body>
    <div class="container">
        <h1>Modifier une parcelle</h1>
        <form action="Modifierparcelle.php" method="post" id="modifyForm">
            <input type="hidden" name="id" value="<?php echo $parcelle['id']; ?>">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($parcelle['nom']); ?>" required>
            <label for="surface">Surface :</label>
            <input type="number" id="surface" name="surface" value="<?php echo htmlspecialchars($parcelle['surface']); ?>" required>
            <button type="submit">Modifier</button>
        </form>
        <div class="error" id="errorMessage"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('modifyForm');
            const errorMessage = document.getElementById('errorMessage');

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simple validation
                const nom = document.getElementById('nom').value;
                const surface = document.getElementById('surface').value;

                if (nom.trim() === '' || surface.trim() === '') {
                    errorMessage.textContent = 'Veuillez remplir tous les champs.';
                    errorMessage.style.opacity = '1';
                } else {
                    errorMessage.style.opacity = '0';
                    // Si la validation passe, on soumet le formulaire
                    form.submit();
                }
            });

            // Animation des inputs
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.05)';
                    this.style.transition = 'transform 0.3s ease';
                });
                input.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>
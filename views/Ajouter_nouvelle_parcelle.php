<?php
require_once("config/connection.php");

if (!isset($conn) || !$conn) {
    die("La connexion à la base de données n'est pas disponible.");
}

function getParcelles($conn) {
    $sql = "SELECT * FROM parcelle ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Erreur lors de l'exécution de la requête : " . $conn->error);
    }

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

$parcelles = getParcelles($conn);

// Traitement de l'ajout de parcelle
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $localisation = $_POST['localisation'];
    $surface = $_POST['surface'];

    $sql = "INSERT INTO parcelle (nom, localisation, surface) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $nom, $localisation, $surface);

    if ($stmt->execute()) {
        $success_message = "Parcelle ajoutée avec succès !";
        $parcelles = getParcelles($conn); // Rafraîchir la liste
        
        // Ajouter un indicateur de succès dans l'URL
        header("Location: parcelle_liste.php?success=1");

        exit();
    } else {
        $error_message = "Erreur lors de l'ajout : " . $conn->error;
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Parcelles</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/gestion_parcelle.css">
</head>
<body>
    <div class="container">
        <h2>Gestion des Parcelles</h2>

        <?php if (isset($success_message)): ?>
            <div class="message success fade-in"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="message error fade-in"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <div class="card form-container fade-in">
            <h3>Ajouter une nouvelle parcelle</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="addParcelleForm">
                <div class="form-group">
                    <label for="nom">Nom de la parcelle:</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="localisation">Localisation:</label>
                    <input type="text" id="localisation" name="localisation" required>
                </div>
                <div class="form-group">
                    <label for="surface">Surface (ha):</label>
                    <input type="number" id="surface" name="surface" step="0.01" required>
                </div>
                <button type="submit" class="submit-btn">Ajouter la parcelle</button>
            </form>
        </div>
    </div>

    <script>
      document.getElementById('addParcelleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (this.checkValidity()) {
        const formData = new FormData(this);
        fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (response.ok) {
                alert('Parcelle ajoutée avec succès !');
                window.location.href = 'parcelle.php';
            } else {
                throw new Error('Erreur lors de l`ajout de la parcelle');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue lors de l`ajout de la parcelle');
        });
    } else {
        this.reportValidity();
    }
});
    </script>
</body>
</html>
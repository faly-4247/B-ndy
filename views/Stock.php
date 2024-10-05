
<?php
// Inclure la connexion à la base de données
require("config/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $espece = $_POST['espece'];
    $quantite = $_POST['quantite'];

    $stmt = $pdo->prepare("INSERT INTO stocks (espece, quantite) VALUES ('$espece','$quantite )");
    
    $stmt->bindParam(':espece', $espece);
    $stmt->bindParam(':quantite', $quantite);

    if ($stmt->execute()) {
        // Redirection vers la page après succès
        header("Location: confirmation.php");
        exit; // Important pour s'assurer que le script s'arrête ici
    } else {
        echo "Erreur lors de l'ajout du stock.";
    }
}
?>

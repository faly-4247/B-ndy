<?php 
// Inclure la connexion à la base de données
require("config.php");  // Assurez-vous que ce fichier contient la connexion mysqli

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $parcelle = $_POST['parcelle'];
    $espece = $_POST['espece'];
    $quantite_plantee = $_POST['quantite_plantee'];
    $date_plantation = $_POST['date_plantation'];

    // Préparer la requête SQL avec mysqli
    $sql = "INSERT INTO plantations (parcelle, espece, quantite_plantee, date_plantation) 
            VALUES (?, ?, ?, ?)";
    
    // Préparer et exécuter la requête avec mysqli
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssis", $parcelle, $espece, $quantite_plantee, $date_plantation);

    if ($stmt->execute()) {
        echo "Plantation ajoutée avec succès";
    } else {
        echo "Erreur lors de l'ajout : " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

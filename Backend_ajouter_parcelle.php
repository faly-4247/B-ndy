<?php
require("config/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $localisation = $_POST['localisation'];
    $surface = $_POST['surface'];

    // Préparer la requête avec des requêtes préparées pour éviter les injections SQL
    $sql = "INSERT INTO parcelle (nom, localisation, surface) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $nom, $localisation, $surface);

    if ($stmt->execute()) {
        header("Location: Liste_parcelle.php");
        exit();
    } else {
        echo "Erreur lors de l'ajout : " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
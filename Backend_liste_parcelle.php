<?php 
require("config/connection.php");

if (!empty($nom) && !empty($localisation) && !empty($surface) && is_numeric($surface)) {
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
} else {
    echo "Veuillez remplir tous les champs correctement.";
}
?>
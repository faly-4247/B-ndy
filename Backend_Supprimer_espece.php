<?php
// Inclure la connexion à la base de données
require("config/connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    // Préparer la requête de suppression
    $sql = "DELETE FROM espece WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirection vers la page de liste après une suppression réussie
        header("Location: Liste.php");
        exit();
    } else {
        echo "Erreur lors de la suppression : " . $conn->error;
    }
} else {
    echo "ID non spécifié.";
}

$conn->close();
?>

<?php
// supprimer_parcelle.php
session_start();
// Inclure la connexion à la base de données
require("config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    // Préparez la requête SQL
    $sql = "DELETE FROM parcelle WHERE id = '$id'";
    
    // Préparez et exécutez la requête

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "La parcelle a été supprimée avec succès.";
        header("Location: parcelle_liste.php");
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de la suppression de la parcelle : " . $conn->error;
        header("Location: parcelle_liste.php");
    }

    $conn->close();

    // Redirigez vers la liste des parcelles
  
} else {
    // Si ce n'est pas une requête POST, redirigez vers la liste des parcelles
    header("Location: parcelle_liste.php");
    exit();
}
?>
<?php
// Inclure la connexion à la base de données
require("config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['type']) && $_POST['type'] == 'stock') {
        $espece = intval($_POST['espece']);
        $quantite = intval($_POST['quantite']);
        
        $sql = "INSERT INTO stocks (espece_id, quantite) VALUES ('$espece', $quantite)";
        if ($conn->query($sql) === TRUE) {
            header("Location: Plantation_Stock.php");
            exit();
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['type']) && $_POST['type'] == 'plantation') {
        $parcelle = $conn->real_escape_string($_POST['parcelle']);
        $espece = $conn->real_escape_string($_POST['espece']);
        $quantite_plantee = intval($_POST['quantite_plantee']);
        $date_plantation = $conn->real_escape_string($_POST['date_plantation']);
        
        $sql = "INSERT INTO plantations (parcelle_id, espece_id, quantite_plantee, date_plantation) VALUES ('$parcelle', '$espece', $quantite_plantee, '$date_plantation')";
        if ($conn->query($sql) === TRUE) {
            header("Location: Plantation_Stock.php");
            exit();
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
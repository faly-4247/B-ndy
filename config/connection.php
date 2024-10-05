<?php
$servername = "localhost";
$username = "root";
$password = "root";
$database = "gestion";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $database);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Activer le jeu de caractères UTF-8
$conn->set_charset("utf8");

?>

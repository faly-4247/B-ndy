<?php
header('Content-Type: application/json');

// Connexion à la base de données
$host = 'localhost'; // Ou l'adresse de votre serveur
$dbname = 'plantes';
$username = 'root'; // Remplacez par votre nom d'utilisateur MySQL
$password = ''; // Remplacez par votre mot de passe MySQL

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

// Récupérer les stocks de plants
$queryStocks = $conn->query("SELECT espece, quantite FROM stocks");
$stocks = $queryStocks->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les données de plantations
$queryPlantations = $conn->query("SELECT mois, nombre_plants FROM plantations");
$plantations = $queryPlantations->fetchAll(PDO::FETCH_ASSOC);

// Envoyer les données sous format JSON
echo json_encode([
    'stocks' => $stocks,
    'plantations' => $plantations
]);
?>

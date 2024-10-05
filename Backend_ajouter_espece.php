<?php
// Inclure la connexion à la base de données
require("config/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom_espece = $_POST['nom_espece'];
    $file = $_FILES['file_espece'];

    // Vérifier s'il y a un fichier uploadé
    if ($file['error'] === UPLOAD_ERR_OK) {
        // Obtenir le nom du fichier
        $fileName = basename($file['name']);
        
        // Définir le dossier où enregistrer les fichiers
        $uploadDir = 'images/';
        $uploadFile = $uploadDir . $fileName;

        // Déplacer le fichier vers le dossier de destination
        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            // Préparer la requête pour insérer l'espèce dans la base de données
            $sql = "INSERT INTO espece (nom, url_photo) VALUES ('$nom_espece', '$fileName')";

            if ($conn->query($sql) === TRUE) {
                header("Location: Liste.php");
            } else {
                echo "Erreur lors de l'ajout : " . $conn->error;
            }
        } else {
            echo "Échec du téléchargement du fichier.";
        }
    } else {
        echo "Aucun fichier n'a été téléchargé.";
    }
}

$conn->close();
?>

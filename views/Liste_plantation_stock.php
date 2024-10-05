<?php
require_once 'config/connection.php';

// Vérifier si la connexion est établie
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Gestion de la suppression
if (isset($_POST['delete_stock'])) {
    $id = intval($_POST['delete_stock']);
    $conn->query("DELETE FROM stocks WHERE id = $id");
} elseif (isset($_POST['delete_plantation'])) {
    $id = intval($_POST['delete_plantation']);
    $conn->query("DELETE FROM plantations WHERE id = $id");
}

// Récupérer les stocks
$query_stocks = "SELECT stocks.id,espece.nom, espece.url_photo, stocks.quantite
FROM stocks
JOIN espece ON stocks.espece_id = espece.id;
";
$result_stocks = $conn->query($query_stocks);

// Récupérer les plantations
// $query_plantations = "SELECT * FROM plantations ORDER BY id DESC";
$query_plantations = "select parcelle.id as parcelle_id,parcelle.nom as parcelle_nom,parcelle.surface as parcelle_surface,espece.id as espece_id,espece.nom as espece_nom,plantations.id as id,plantations.quantite_plantee,plantations.date_plantation from parcelle, espece, plantations where parcelle.id = plantations.parcelle_id and espece.id = plantations.espece_id";
$result_plantations = $conn->query($query_plantations);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Stocks et Plantations</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
   <link rel="stylesheet" href="./assets/css/listePlantation.css">
</head>
<body>
    <div class="container">
        <h1>Gestion des Stocks et Plantations</h1>
        
        <div class="list-container">
            <div class="list">
                <h2>Stocks</h2>
                <table>
                    <tr>
                        <th>Espèce</th>
                        <th>Quantité</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                    <?php while($row = $result_stocks->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantite']); ?></td>
                        <td><img src="./images/<?=$row['url_photo']; ?>" alt="<?= htmlspecialchars($row['nom']); ?>"></td>
                        <td>
                            <form method="post" style="display: inline;">
                                <button type="button" onclick="window.location.href='modifierStock.php?id=<?php echo $row['id']; ?>'" class="btn btn-edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="submit" name="delete_stock" value="<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce stock ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
                
            </div>
            
            <div class="list">
                <h2>Plantations</h2>
                <table>
                    <tr>
                        <th>Parcelle</th>
                        <th>Surface(ha)</th>
                        <th>Espèce</th>
                        <th>Quantité</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    <?php while($row = $result_plantations->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['parcelle_nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['parcelle_surface']);?></td>
                        <td><?php echo htmlspecialchars($row['espece_nom']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantite_plantee']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_plantation']); ?></td>
                        <td>
                            <form method="post" style="display: inline;">
                                <button type="button" onclick="window.location.href='modifierPlantation.php?id=<?php echo $row['id']; ?>'" class="btn btn-edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="submit" name="delete_plantation" value="<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette plantation ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        
        <a href="Gestion.php" class="back-button">Retour à la gestion</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const lists = document.querySelectorAll('.list');
            lists.forEach((list, index) => {
                list.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>
</body>
</html>
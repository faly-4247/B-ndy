<?php
if (!is_object($conn)) {
    die("Erreur de connexion à la base de données");
}

function getEspeces($conn) {
    $sql = "SELECT * FROM espece";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Erreur lors de l'exécution de la requête : " . $conn->error);
    }

    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

$especes = getEspeces($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Espèces</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2D6A4F;
            font-size: 2.5rem;
            margin: 30px 0;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, #2D6A4F, #1abc9c);
        }

        .add-species-container {
            display: flex;
            justify-content: flex-end;
            margin: 20px 0;
        }

        .add-species-button {
            background: linear-gradient(135deg, #2D6A4F, #1abc9c);
            color: white;
            border: none;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(45, 106, 79, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .add-species-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(45, 106, 79, 0.3);
        }

        table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
        }

        th {
            background: #2D6A4F;
            color: white;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 14px;
            padding: 15px;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        tr {
            transition: all 0.3s ease;
        }

        tr:hover {
            background: #f8f9fa;
        }

        td img {
            max-width: 100px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        td img:hover {
            transform: scale(1.1);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 50px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-modifier {
            background: #2D6A4F;
        }

        .btn-supprimer {
            background: #dc3545;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        tr {
            animation: fadeIn 0.5s ease forwards;
        }

        tr:nth-child(1) { animation-delay: 0.1s; }
        tr:nth-child(2) { animation-delay: 0.2s; }
        tr:nth-child(3) { animation-delay: 0.3s; }
        /* ... ajoutez plus si nécessaire */

    </style>
</head>
<body>
    <div class="container">
        <h2>Liste des Espèces de Mangroves</h2>

        <div class="add-species-container">
            <a href="./ajouter.php" class="add-species-button">
                <i class="fas fa-plus"></i>
                Ajouter une espèce
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Nom de l'espèce</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (count($especes) > 0): ?>
                <?php foreach ($especes as $espece): ?>
                    <tr>
                        <td><?= $espece['id']; ?></td>
                        <td><?= htmlspecialchars($espece['nom']); ?></td>
                        <td><img src="./images/<?=$espece['url_photo']; ?>" alt="<?= htmlspecialchars($espece['nom']); ?>"></td>
                        <td>
                            <div class="action-buttons">
                                <a href="modifierEspece.php?id=<?= $espece['id']; ?>" class="btn btn-modifier">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <a href="Backend_Supprimer_espece.php?id=<?= $espece['id']; ?>" class="btn btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette espèce ?');">
                                    <i class="fas fa-trash"></i> Supprimer
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Aucune espèce trouvée</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
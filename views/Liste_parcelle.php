<?php
require_once("config/connection.php");

if (!isset($conn) || !$conn) {
    die("La connexion à la base de données n'est pas disponible.");
}

function getParcelles($conn) {
    $sql = "SELECT * FROM parcelle ORDER BY id DESC";
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

$parcelles = getParcelles($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Parcelles</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            /* background: #f0f4f8; */
            background-color: #dcb253;
            color: #333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        h1 {
            text-align: center;
            color: #2D6A4F;
            font-size: 2.5rem;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 10px;
        }

        h1::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, #2D6A4F, #1abc9c);
        }

        .btn-ajouter {
            background: linear-gradient(135deg, #2D6A4F, #1abc9c);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 200px;
            text-align: center;
            margin: 0 auto 40px;
            text-decoration: none;
        }

        .btn-ajouter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(45, 106, 79, 0.3);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            background-color: white;
        }

        th {
            background-color: #2D6A4F;
            color: white;
            font-weight: 600;
        }

        tr {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        tr:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        td:first-child, th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        td:last-child, th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
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
            font-size: 0.9rem;
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
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="fade-in">Liste des parcelles</h1>
        
        <a href="index.php" class="btn-ajouter fade-in">
            <i class="fas fa-plus"></i> Ajouter parcelle
        </a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de la parcelle</th>
                    <th>Surface (ha)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parcelles as $index => $parcelle): ?>
                    <tr class="fade-in" style="animation-delay: <?php echo $index * 0.1; ?>s;">
                        <td><?= htmlspecialchars($parcelle['id']); ?></td>
                        <td><?= htmlspecialchars($parcelle['nom']); ?></td>
                        <td><?= htmlspecialchars($parcelle['surface']); ?></td>
                        <td>
                            <a href="./Modifierparcelle.php?id=<?= $parcelle['id']; ?>" class="btn btn-modifier">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <a href="#" class="btn btn-supprimer" onclick="confirmerSuppression(<?= $parcelle['id']; ?>)">
                                <i class="fas fa-trash"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function confirmerSuppression(id) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette parcelle ?')) {
                window.location.href = 'backend_supprimer_parcelle.php?id=' + id;
            }
        }
    </script>
    <script>
        function confirmerSuppression(id) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cette parcelle ?")) {
        var form = document.createElement("form");
        form.method = "POST";
        form.action = "Backend_supprimer_parcelle.php";
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "id";
        input.value = id;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}
    </script>
</body>
</html>
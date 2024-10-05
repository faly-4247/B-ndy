<?php
session_start();
require 'config/connection.php'; // Assurez-vous de remplacer par votre connexion à la base de données.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $parcelle_id = $_POST['parcelle_id'];
    $espece_id = $_POST['espece_id'];
    $quantite_plantee = $_POST['quantite_plantee'];
    $date_plantation = $_POST['date_plantation'];
    
    $sql = "UPDATE plantations SET parcelle_id = ?, espece_id = ?, quantite_plantee = ?, date_plantation = ? WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiisi', $parcelle_id, $espece_id, $quantite_plantee, $date_plantation, $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "La plantation a été modifiée avec succès.";
        header("Location: Plantation_Stock.php"); // Redirige vers la liste des stocks et plantations
        exit();
    } else {
        echo "Erreur lors de la modification : " . $conn->error;
    }
} else {
    if (!is_object($conn)) {
        die("Erreur de connexion à la base de données");
    }
   
    $id_plantation = isset($_GET['id']) ? $_GET['id'] : null;
   
    if ($id_plantation) {
        $sql = "SELECT p.*, pa.nom as parcelle_nom, e.nom as espece_nom 
                FROM plantations p 
                JOIN parcelle pa ON p.parcelle_id = pa.id 
                JOIN espece e ON p.espece_id = e.id 
                WHERE p.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_plantation);
        $stmt->execute();
        $result = $stmt->get_result();
   
        if ($result->num_rows > 0) {
            $plantation = $result->fetch_assoc();
        } else {
            die("Plantation non trouvée");
        }
    }

    // Récupérer la liste des parcelles pour le menu déroulant
    $sql_parcelles = "SELECT id, nom FROM parcelle";
    $result_parcelles = $conn->query($sql_parcelles);

    // Récupérer la liste des espèces pour le menu déroulant
    $sql_especes = "SELECT id, nom FROM espece";
    $result_especes = $conn->query($sql_especes);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une plantation</title>
    <link rel="stylesheet" href="./assets/css/modifier_plantation.css">
    <style>
        /* Styles CSS inclus ici pour une simplicité d'intégration */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        select, input[type="number"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        select:focus, input[type="number"]:focus, input[type="date"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(to right, #4CAF50, #81C784);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button:hover {
            background: linear-gradient(to right, #388E3C, #66BB6A);
        }

        .error {
            color: red;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier une plantation</h1>
        <form action="modifie_plantation.php" method="post" id="modifyForm">
            <input type="hidden" name="id" value="<?php echo $plantation['id']; ?>">
            <label for="parcelle_id">Parcelle :</label>
            <select id="parcelle_id" name="parcelle_id" required>
                <?php while($parcelle = $result_parcelles->fetch_assoc()): ?>
                    <option value="<?php echo $parcelle['id']; ?>" <?php echo ($parcelle['id'] == $plantation['parcelle_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($parcelle['nom']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="espece_id">Espèce :</label>
            <select id="espece_id" name="espece_id" required>
                <?php while($espece = $result_especes->fetch_assoc()): ?>
                    <option value="<?php echo $espece['id']; ?>" <?php echo ($espece['id'] == $plantation['espece_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($espece['nom']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="quantite_plantee">Quantité plantée :</label>
            <input type="number" id="quantite_plantee" name="quantite_plantee" value="<?php echo htmlspecialchars($plantation['quantite_plantee']); ?>" required>
            <label for="date_plantation">Date de plantation :</label>
            <input type="date" id="date_plantation" name="date_plantation" value="<?php echo htmlspecialchars($plantation['date_plantation']); ?>" required>
            <button type="submit">Modifier</button>
        </form>
        <div class="error" id="errorMessage">Veuillez remplir tous les champs.</div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('modifyForm');
            const errorMessage = document.getElementById('errorMessage');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
               
                const parcelle_id = document.getElementById('parcelle_id').value;
                const espece_id = document.getElementById('espece_id').value;
                const quantite_plantee = document.getElementById('quantite_plantee').value;
                const date_plantation = document.getElementById('date_plantation').value;
                if (parcelle_id.trim() === '' || espece_id.trim() === '' || quantite_plantee.trim() === '' || date_plantation.trim() === '') {
                    errorMessage.style.opacity = '1';
                } else {
                    errorMessage.style.opacity = '0';
                    form.submit();
                }
            });
            
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.05)';
                    this.style.transition = 'transform 0.3s ease';
                });
                input.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>

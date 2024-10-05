<?php
// modifier_stock.php
session_start();
require_once 'config/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $espece_id = $_POST['espece_id'];
    $quantite = $_POST['quantite'];
    
    $sql = "UPDATE stocks SET espece_id = ?, quantite = ? WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iii', $espece_id, $quantite, $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Le stock a été modifié avec succès.";
        header("Location: Plantation_Stock.php"); // Redirigez vers la liste des stocks et plantations
        exit();
    } else {
        echo "Erreur lors de la modification : " . $conn->error;
    }
} else {
    if (!is_object($conn)) {
        die("Erreur de connexion à la base de données");
    }
   
    $id_stock = isset($_GET['id']) ? $_GET['id'] : null;
   
    if ($id_stock) {
        $sql = "SELECT s.*, e.nom as espece_nom FROM stocks s JOIN espece e ON s.espece_id = e.id WHERE s.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_stock);
        $stmt->execute();
        $result = $stmt->get_result();
   
        if ($result->num_rows > 0) {
            $stock = $result->fetch_assoc();
        } else {
            die("Stock non trouvé");
        }
    }

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
    <title>Modifier un stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #dcb253;
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

        select, input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        select:focus, input[type="number"]:focus {
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
        <h1>Modifier un stock</h1>
        <form action="modifierStock.php" method="post" id="modifyForm">
            <input type="hidden" name="id" value="<?php echo $stock['id']; ?>">
            <label for="espece_id">Espèce :</label>
            <select id="espece_id" name="espece_id" required>
                <?php while($espece = $result_especes->fetch_assoc()): ?>
                    <option value="<?php echo $espece['id']; ?>" <?php echo ($espece['id'] == $stock['espece_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($espece['nom']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="quantite">Quantité :</label>
            <input type="number" id="quantite" name="quantite" value="<?php echo htmlspecialchars($stock['quantite']); ?>" required>
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
               
                const espece_id = document.getElementById('espece_id').value;
                const quantite = document.getElementById('quantite').value;
                if (espece_id.trim() === '' || quantite.trim() === '') {
                    errorMessage.style.opacity = '1';
                } else {
                    errorMessage.style.opacity = '0';
                    form.submit();
                }
            });

            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.02)';
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

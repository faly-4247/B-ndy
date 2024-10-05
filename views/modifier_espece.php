<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Espèce</title>
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            color: #2D6A4F;
            font-size: 28px;
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, #2D6A4F, #1abc9c);
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2D6A4F;
            transition: all 0.3s ease;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        input[type="text"]:focus {
            border-color: #2D6A4F;
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .file-input-trigger {
            display: block;
            padding: 12px 15px;
            background: #f5f5f5;
            border: 2px dashed #2D6A4F;
            border-radius: 10px;
            text-align: center;
            color: #2D6A4F;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-wrapper:hover .file-input-trigger {
            background: #e8f5e9;
        }

        .current-image {
            margin-top: 15px;
            text-align: center;
        }

        .current-image img {
            max-width: 150px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .current-image img:hover {
            transform: scale(1.05);
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2D6A4F, #1abc9c);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 106, 79, 0.3);
        }

        button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }

        button:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }

        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            100% {
                transform: scale(100, 100);
                opacity: 0;
            }
        }
    </style>
</head>
<body>

<?php
if (!is_object($conn)) {
    die("Erreur de connexion à la base de données");
}

$id_espece = isset($_GET['id']) ? $_GET['id'] : null;

if ($id_espece) {
    $sql = "SELECT * FROM espece WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_espece);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $espece = $result->fetch_assoc();
    } else {
        die("Espèce non trouvée");
    }
}
?>

<div class="form-container">
    <h2>Modifier l'espèce de mangrove</h2>
    
    <form action="Backend_modifier_espece.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id_espece" value="<?= $espece['id']; ?>">

        <div class="form-group">
            <label for="nom_espece">
                <i class="fas fa-leaf"></i> Nom de l'espèce
            </label>
            <input type="text" id="nom_espece" name="nom_espece" value="<?= htmlspecialchars($espece['nom']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>
                <i class="fas fa-image"></i> Image de l'espèce
            </label>
            <div class="file-input-wrapper">
                <div class="file-input-trigger">
                    <i class="fas fa-upload"></i> Choisir un nouveau fichier
                </div>
                <input type="file" id="file_espece" name="file_espece" accept=".jpg,.jpeg,.png,.pdf">
            </div>
            
            <?php if ($espece['url_photo']): ?>
                <div class="current-image">
                    <p>Image actuelle :</p>
                    <img src="./images/<?= $espece['url_photo']; ?>" alt="Espèce">
                </div>
            <?php endif; ?>
        </div>
        
        <button type="submit">
            <i class="fas fa-save"></i> Enregistrer les modifications
        </button>
    </form>
</div>

<script>
document.getElementById('file_espece').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    e.target.parentNode.querySelector('.file-input-trigger').textContent = fileName;
});
</script>

</body>
</html>
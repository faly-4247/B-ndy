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

function getParcelles($conn) {
    $sql = "SELECT * FROM parcelle";
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
$parcelles = getParcelles($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Plantations de Mangroves</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/Gestion_plantation.css">
</head>
<body>

<div class="container fade-in">
    <a href="index.php">  &#x21A9; Retour <h1>Gestion des Plantations de Mangroves</h1></a> 

    <section class="slide-in">
        <h2><i class="fas fa-seedling"></i> Ajouter un Stock de Plants</h2>
        <form id="formStock" action="Backend_GestionPlantation.php" method="post">
            <label for="espece"><i class="fas fa-leaf"></i> Espèce:</label>
            <select id="espece" name="espece" required>
                <option value="">Sélectionnez une espèce</option>
                <?php foreach ($especes as $espece): ?>
                    <option value="<?= htmlspecialchars($espece['id']) ?>">
                        <?= htmlspecialchars($espece['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="quantite"><i class="fas fa-sort-numeric-up"></i> Quantité:</label>
            <input type="number" id="quantite" name="quantite" required>

            <input type="hidden" name="type" value="stock">
            <button type="button" onclick="confirmerAjout('stock')"><i class="fas fa-plus-circle"></i> Ajouter Stock</button>
        </form>
    </section>

    <section class="slide-in">
        <h2><i class="fas fa-tree"></i> Ajouter une Plantation</h2>
        <form id="formPlantation" action="Backend_GestionPlantation.php" method="post">
            <label for="parcelle"><i class="fas fa-map-marker-alt"></i> Parcelle:</label>
            <select id="parcelle" name="parcelle" required>
                <option value="">Sélectionnez une parcelle</option>
                <?php foreach ($parcelles as $parcelle): ?>
                    <option value="<?= htmlspecialchars($parcelle['id']) ?>">
                        <?= htmlspecialchars($parcelle['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="especePlantation"><i class="fas fa-leaf"></i> Espèce Plantée:</label>
            <select id="especePlantation" name="espece" required>
                <option value="">Sélectionnez une espèce</option>
                <?php foreach ($especes as $espece): ?>
                    <option value="<?= htmlspecialchars($espece['id']) ?>">
                        <?= htmlspecialchars($espece['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="quantite_plantee"><i class="fas fa-sort-numeric-up"></i> Quantité Plantée:</label>
            <input type="number" id="quantite_plantee" name="quantite_plantee" required>
            <label for="surface"><i class="fas fa-sort-numeric-up"></i> Surface:</label>
            <input type="number" id="surface" name="surface" required>

            <label for="date_plantation"><i class="fas fa-calendar-alt"></i> Date de Plantation:</label>
            <input type="date" id="date_plantation" name="date_plantation" required>

            <input type="hidden" name="type" value="plantation">
            <button type="button" onclick="confirmerAjout('plantation')"><i class="fas fa-plus-circle"></i> Ajouter Plantation</button>
        </form>
    </section>
</div>

<footer>
    <p>© 2024 Gestion des Plantations de Mangroves. Tous droits réservés.</p>
</footer>

<div id="confirmationModal" class="modal">
    <h3><i class="fas fa-question-circle"></i> Confirmation</h3>
    <p id="confirmationText"></p>
    <button id="confirmBtn"><i class="fas fa-check"></i> Confirmer</button>
    <button onclick="fermerConfirmation()"><i class="fas fa-times"></i> Annuler</button>
</div>

<div id="overlay" class="overlay"></div>

<script>
    function confirmerAjout(type) {
        let text = type === 'stock' ? "Voulez-vous ajouter ce stock ?" : "Voulez-vous ajouter cette plantation ?";
        document.getElementById('confirmationText').innerText = text;
        
        const modal = document.getElementById('confirmationModal');
        const overlay = document.getElementById('overlay');
        
        modal.style.display = 'block';
        overlay.style.display = 'block';
        setTimeout(() => {
            modal.classList.add('show');
            overlay.classList.add('show');
        }, 10);
        
        document.getElementById('confirmBtn').onclick = function() {
            if (type === 'stock') {
                document.getElementById('formStock').submit();
            } else {
                document.getElementById('formPlantation').submit();
            }
        };
    }

    function fermerConfirmation() {
        const modal = document.getElementById('confirmationModal');
        const overlay = document.getElementById('overlay');
        
        modal.classList.remove('show');
        overlay.classList.remove('show');
        setTimeout(() => {
            modal.style.display = 'none';
            overlay.style.display = 'none';
        }, 300);
    }

    // Animation des sections au chargement
    document.addEventListener('DOMContentLoaded', (event) => {
        const sections = document.querySelectorAll('section');
        sections.forEach((section, index) => {
            setTimeout(() => {
                section.style.opacity = '1';
                section.style.transform = 'translateY(0)';
            }, 200 * index);
        });
    });
</script>

</body>
</html>
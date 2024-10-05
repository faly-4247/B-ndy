



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Espèces de Mangroves</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2D6A4F;
            font-size: 30px;
            font-family: 'Arial', sans-serif;
            margin: 20px 0;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        table,
        th,
        td {
            border: 1.8px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1.8px solid #000;
        }

        th {
            background-color: #2D6A4F;
            color: white;
            font-size: 16px;
        }

        td img {
            max-width: 100px;
            height: 150px;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }

        td img:hover {
            transform: scale(1.1);
        }

        button {
            padding: 8px 12px;
            background-color: #1abc9c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        button:hover {
            background-color: transparent;
            color: #1abc9c;
            transform: translateY(-2px);
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3);
        }

        .btn-modifier {
            background-color: #2D6A4F;
        }

        .form-modification {
            display: none;
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            border: 1.5px solid #2D6A4F;
            background-color: #f9f9f9;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-modification h3 {
            color: #2D6A4F;
            margin-bottom: 15px;
        }

        .form-modification input,
        .form-modification button {
            display: block;
            margin-bottom: 15px;
            padding: 10px;
            width: 100%;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function afficherFormulaireModification(id, nom, photo) {
            // Remplir les champs du formulaire
            $('#form-id').val(id);
            $('#form-nom').val(nom);
            $('#form-photo').attr('src', './images/' + photo);

            // Afficher le formulaire avec une animation
            $('.form-modification').slideDown(300);
        }
// Fonction pour envoyer la modification via a.btn-supprimer
function submitForm(event) {
    event.preventDefault();
    var formData = new FormData(document.getElementById("modificationForm"));

    $.ajax({
        url: 'Modification_espece.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                alert('Modification réussie !');
                $('.form-modification').slideUp(300); // Fermer le formulaire

                // Mettre à jour l'élément dans la liste sans recharger la page
                var especeId = $('#form-id').val();
                $('td:contains("' + especeId + '")').siblings().eq(1).text($('#form-nom').val());
                $('td:contains("' + especeId + '")').siblings().eq(2).find('img').attr('src', './images/' + $('#photo').val().split('\\').pop());
            } else {
                alert('Erreur: ' + response.message); // Afficher le message d'erreur renvoyé par le serveur
            }
        },
        error: function(xhr, status, error) {
            // Afficher les détails de l'erreur
            console.log(xhr.responseText); // Affiche la réponse du serveur pour inspection
            console.log("Erreur: " + error); // Affiche l'erreur
            alert('Erreur lors de la modification.');
        }
    });
}


    </script>
</head>

<body>

    <h2>Liste des Espèces de Mangroves</h2>

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
            <?php foreach ($especes as $espece): ?>
            <tr>
                <td><?= $espece['id']; ?></td>
                <td><?= htmlspecialchars($espece['nom']); ?></td>
                <td><img src="./images/<?= $espece['url_photo']; ?>" alt="Photo de l'espèce"></td>
                <td>
                    <button class="btn-modifier" onclick="afficherFormulaireModification('<?= $espece['id']; ?>', '<?= htmlspecialchars($espece['nom']); ?>', '<?= $espece['url_photo']; ?>')">Modifier</button>
                    <button class="btn-supprimer"><a href="Backend_Supprimer_espece.php?id=<?= $espece['id']; ?>"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette espèce ?');">Supprimer</a></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Formulaire de modification -->
    <div class="form-modification">
        <h3>Modifier l'espèce</h3>
        <form id="modificationForm" action="Modification_espece.php" method="POST" enctype="multipart/form-data" onsubmit="submitForm(event)">
            <input type="hidden" id="form-id" name="id">
            <div>
                <label for="form-nom">Nom de l'espèce :</label>
                <input type="text" id="form-nom" name="nom" required>
            </div>
            <div>
                <label for="form-photo">Photo actuelle :</label>
                <img id="form-photo" style="max-width: 100px;">
            </div>
            <div>
                <label for="photo">Nouvelle photo :</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>
            <button type="submit">Modifier</button>
        </form>
    </div>
    <!-- Formulaire de modification -->

</body>

</html>

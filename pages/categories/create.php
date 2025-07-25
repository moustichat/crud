<?php
require_once('./../../config/database.php');
require_once('./../../classes/Categorie.php');
require_once('./../../classes/Bibliotheque.php');


$errors = [];


// Traitement du formulaire
if ($_POST) {
    $categorieModel = new Categorie($pdo,
                                    $_POST['nom_categorie'] ?? '',
                                    $_POST['description'] ?? 'A rentrer');


    // Validation basique
    if (empty($_POST['nom_categorie'])) {
        $errors[] = "Le nom de la catégorie est requis.";
    }
    if (empty($_POST['description'])) {
        $errors[] = "La description est requise.";
    }

    // Si pas d'erreurs, mise à jour de la catégorie
    if (empty($errors)) {
        try {
            $categorieModel->create($id_categorie);
            header('Location: ../../index.php?message=categorie_updated');
            exit;
        } catch (Exception $e) {
            $errors[] = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Creation d'une catégorie</title>
</head>

<body>
    <div class="container">
        <h1> Ajouter une catégorie</h1>

        <div class="back-link">
                <a href="../../index.php" class="btn-back">← Retour a la liste</a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <h3>⚠️ Erreurs détectées :</h3>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">    
            <div>
                <label for="nom_categorie">nom de la catégorie *</label>
                <input type="text" name="nom_categorie" id="nom_categorie" required>
            </div>
            <div>
                <label for="description">description *</label>
                <input type="text" name="description" id="description" required>
            </div>


        <input type="submit" value="Ajouter">
        </form>
    </div>
</body>

</html>
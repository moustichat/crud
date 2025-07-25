<?php
require_once('./../../config/database.php');
require_once('./../../classes/Auteur.php');
require_once('./../../classes/Bibliotheque.php');

$auteurModel = new Auteur($pdo);
$errors = [];


// Traitement du formulaire
if ($_POST) {
    $auteurModel = new Auteur($pdo,
                              $_POST['nom'] ?? '',
                              $_POST['prenom'] ?? '',
                              $_POST['date_naissance'] ?? '',
                              $_POST['nationalite'] ?? '');

    // Validation des donnees
    if (empty($_POST['nom'])) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($_POST['prenom'])) {
        $errors[] = "Le prenom est requis.";
    }

    // Si pas d'erreurs, mise à jour de l'auteur
    if (empty($errors)) {
        try {
            $auteurModel->create();
            header('Location: ../../index.php?message=auteur_updated');
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
    <title>Creation d'un auteur</title>
</head>

<body>
    <div class="container">
        <h1> Ajouter un auteur</h1>
        
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
                <label for="nom">nom *</label>
                <input type="text" name="nom" id="nom" required>
            </div>
            <div>
                <label for="prenom">prenom *</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>
            <div>
                <label for="date_naissance">Date de naissance *</label>
                <input type="date" name="date_naissance" id="date_naissance" required>
            </div>
            <div>
                <label for="nationalite">nationalite *</label>
                <input type="text" name="nationalite" id="nationalite" required>
            </div>


        <input type="submit" value="Ajouter">
        </form>
    </div>
</body>

</html>
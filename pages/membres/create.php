<?php
require_once('./../../config/database.php');
require_once('./../../classes/Membre.php');
require_once('./../../classes/Bibliotheque.php');

$errors = [];
$biblioModel = new Bibliotheque($pdo);

// Traitement du formulaire
if ($_POST) {
    $membreModel = new Membre($pdo,
                              $_POST['nom'] ?? '',
                              $_POST['prenom'] ?? '',
                              $_POST['email'] ?? '',
                              $_POST['telephone'] ?? '',
                              $_POST['adresse'] ?? '');


    // Validation basique
    if (empty($_POST['nom'])) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($_POST['prenom'])) {
        $errors[] = "Le prenom est requis.";
    }
    if (empty($_POST['email'])) {
        $errors[] = "L'email est requis.";
    }
    if ($biblioModel->emailExists($_POST['email'])) {
        $errors[] = "Cet email est déja utilisé";
    }

    // Si pas d'erreurs, création du membre
    if (empty($errors)) {
        try {
            $membreModel->create();
            header('Location: ../../index.php?message=updated');
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
    <title>Creation d'un membre</title>
</head>

<body>
    <div class="container">
        <h1>Ajouter un membre</h1>  

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
                <label for="nom">Nom *</label>
                <input type="text" name="nom" id="nom" required>
            </div>
            <div>
                <label for="prenom">Prenom *</label>
                <input type="text" name="prenom" id="prenom" required>
            </div>
            <div>
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="telephone">Telephone</label>
                <input type="text" name="telephone" id="telephone" required>
            </div>
            <div>
                <label for="adresse">Adresse</label>
                <textarea name="adresse" id="adresse" rows="3" required></textarea>
            </div>
            

            <input type="submit" value="Ajouter">
        </form>
    </div>
</body>

</html>

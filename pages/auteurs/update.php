<?php
require_once('./../../config/database.php');
require_once('./../../classes/Auteur.php');
require_once('./../../classes/Bibliotheque.php');

$biblioModel = new Bibliotheque($pdo);
$errors = [];

// Récupération de l'ID de l'auteur à modifier
$id_auteur = $_GET['id_auteur'] ?? null;

if (!$id_auteur) {
    header('Location: ../../index.php?error=missing_id');
    exit;
}

// Récupération des données de l'auteur
try {
    $auteur = $biblioModel->getAuteur($id_auteur);
    if (!$auteur) {
        header('Location: ../../index.php?error=auteur_not_found');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../../index.php?error=database_error');
    exit;
}

// Traitement du formulaire de modification
if ($_POST) {
        $auteurModel = new Auteur($pdo,
                                  $_POST['nom'] ?? '',
                                  $_POST['prenom'] ?? '',
                                  $_POST['date_naissance'] ?? '',
                                  $_POST['nationalite'] ?? '');

    // Validation basique
    if (empty($_POST['nom'])) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($_POST['prenom'])) {
        $errors[] = "Le prénom est requis.";
    }


    // Si pas d'erreurs, mise à jour de l'auteur
    if (empty($errors)) {
        try {
            $auteurModel->update();
            header('Location: ../../index.php?message=auteur_updated');
            exit;
        } catch (Exception $e) {
            $errors[] = "Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Modifier un auteur</title>
</head>

<body>
    <div class="container">
        <h1>Modifier l'auteur</h1>
        
        <div class="back-link">
            <a href="../../index.php" class="btn-back">← Retour à la liste</a>
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

        <form method="POST" class="update-form">
            <div class="form-group">
                <label for="nom">Nom *</label>
                <input type="text" name="nom" id="nom" 
                       value="<?php echo htmlspecialchars($auteur['nom'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="prenom">Prénom *</label>
                <input type="text" name="prenom" id="prenom" 
                       value="<?php echo htmlspecialchars($auteur['prenom'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="date_naissance">Date de naissance *</label>
                <input type="date" name="date_naissance" id="date_naissance" 
                       value="<?php echo htmlspecialchars($auteur['date_naissance'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="nationalite">Nationalité *</label>
                <input type="text" name="nationalite" id="nationalite" 
                       value="<?php echo htmlspecialchars($auteur['nationalite'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-actions">
                <input type="submit" value="Mettre à jour" class="btn-submit">
                <a href="../../index.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>

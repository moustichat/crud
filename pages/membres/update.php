<?php
require_once('./../../config/database.php');
require_once('./../../classes/Membre.php');

$membreModel = new Membre($pdo);
$errors = [];
$membre = null;

// Récupération de l'ID du membre à modifier
$id_membre = $_GET['id_membre'] ?? null;

if (!$id_membre) {
    header('Location: ../../index.php?error=missing_id');
    exit;
}

// Récupération des données du membre
try {
    $membre = $membreModel->getById($id_membre);
    if (!$membre) {
        header('Location: ../../index.php?error=membre_not_found');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../../index.php?error=database_error');
    exit;
}

// Traitement du formulaire de modification
if ($_POST) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $actif = isset($_POST['actif']) ? 1 : 0;

    // Validation basique
    if (empty($nom)) {
        $errors[] = "Le nom est requis.";
    }
    if (empty($prenom)) {
        $errors[] = "Le prenom est requis.";
    }
    if (empty($email)) {
        $errors[] = "L'email est requis.";
    }

    // Si pas d'erreurs, mise à jour du membre
    if (empty($errors)) {
        try {
            $membreModel->update($id_membre, $nom, $prenom, $email, $telephone, $adresse, $actif);
            header('Location: ../../index.php?message=updated');
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
    <title>Modifier un membre</title>
</head>

<body>
    <div class="container">
        <h1>Modifier le membre</h1>
        
        <div class="back-link">
            <a href="../../index.php" class="btn-back">Retour a la liste</a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <h3>Erreurs detectees :</h3>
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
                       value="<?php echo htmlspecialchars($membre['nom'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="prenom">Prenom *</label>
                <input type="text" name="prenom" id="prenom" 
                       value="<?php echo htmlspecialchars($membre['prenom'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" 
                       value="<?php echo htmlspecialchars($membre['email'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="telephone">Telephone</label>
                <input type="text" name="telephone" id="telephone" 
                       value="<?php echo htmlspecialchars($membre['telephone'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="adresse">Adresse</label>
                <textarea name="adresse" id="adresse" rows="3"><?php echo htmlspecialchars($membre['adresse'] ?? ''); ?></textarea>
            </div>

            <div class="form-group checkbox-group">
                <label for="actif">Actif</label>
                <input type="checkbox" name="actif" id="actif" 
                       <?php echo ($membre['actif'] ?? 0) ? 'checked' : ''; ?>>
                <span class="checkbox-label">Le membre est actif</span>
            </div>

            <div class="form-actions">
                <input type="submit" value="Mettre a jour" class="btn-submit">
                <a href="../../index.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>

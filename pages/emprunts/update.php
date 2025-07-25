<?php
require_once('./../../config/database.php');
require_once('./../../classes/Emprunt.php');
require_once('./../../classes/Bibliotheque.php');

$biblioModel = new Bibliotheque($pdo);
$errors = [];
$emprunt = null;

// Récupération de l'ID de l'emprunt à modifier
$id_emprunt = $_GET['id_emprunt'] ?? null;

if (!$id_emprunt) {
    header('Location: ../../index.php?error=missing_id');
    exit;
}

// Récupération des données de l'emprunt
try {
    $emprunt = $biblioModel->getEmprunt($id_emprunt);
    if (!$emprunt) {
        header('Location: ../../index.php?error=emprunt_not_found');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../../index.php?error=database_error');
    exit;
}

// Récupérer les livres et membres pour les selects
$livres = $biblioModel->getAllLivres();
$membres = $biblioModel->getAllMembres();

// Traitement du formulaire de modification
if ($_POST) {
    $empruntModel = new Emprunt($pdo,
                                $_POST['id_livre'] ?? '',
                                $_POST['id_membre'] ?? '',
                                $_POST['date_emprunt'] ?? '',
                                $_POST['date_retour_prevue'] ?? '',
                                $_POST['statut'] ?? '');
                                


    // Validation basique
    if (empty($_POST['id_livre'])) {
        $errors[] = "Le livre est requis.";
    }
    if (empty($_POST['id_membre'])) {
        $errors[] = "Le membre est requis.";
    }
    if (empty($_POST['date_emprunt'])) {
        $errors[] = "La date d'emprunt est requise.";
    }
    if (empty($_POST['date_retour_prevue'])) {
        $errors[] = "La date de retour prevue est requise.";
    }
    if ($_POST['date_retour_effectif']) {
        $empruntModel->rendre_livre($_POST['date_retour_effectif']);
    }
    if (empty($_POST['statut'])) {
        $errors[] = "Le statut est requis.";
    }
    if ($_POST['statut'] == 'rendu') {
        $empruntModel->rendre_livre(date("Y-m-d H:i:s"));
    }

    // Si pas d'erreurs, mise à jour de l'emprunt
    if (empty($errors)) {
        try {
            $empruntModel->update($id_emprunt);
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
    <title>Modifier un emprunt</title>
</head>

<body>
    <div class="container">
        <h1>Modifier l'emprunt</h1>
        
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

        <form method="POST" class="update-form">
            <div class="form-group">
                <label for="id_livre">Livre *</label>
                <select name="id_livre" id="id_livre" required>
                    <option value="">Choisir un livre</option>
                    <?php foreach ($livres as $livre): ?>
                        <option value="<?php echo $livre['id_livre']; ?>" <?php echo ($emprunt['id_livre'] == $livre['id_livre']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($livre['titre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_membre">Membre *</label>
                <select name="id_membre" id="id_membre" required>
                    <option value="">Choisir un membre</option>
                    <?php foreach ($membres as $membre): ?>
                        <option value="<?php echo $membre['id_membre']; ?>" <?php echo ($emprunt['id_membre'] == $membre['id_membre']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars("{$membre['prenom']} {$membre['nom']}"); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="date_emprunt">Date d'emprunt *</label>
                <input type="date" name="date_emprunt" id="date_emprunt" 
                       value="<?php echo htmlspecialchars($emprunt['date_emprunt'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="date_retour_prevue">Date de retour prevue *</label>
                <input type="date" name="date_retour_prevue" id="date_retour_prevue" 
                       value="<?php echo htmlspecialchars($emprunt['date_retour_prevue'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="date_retour_effectif">Date de retour effectif</label>
                <input type="date" name="date_retour_effectif" id="date_retour_effectif" 
                       value="<?php echo htmlspecialchars($emprunt['date_retour_effectif'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label for="statut">Statut *</label>
                <select name="statut" id="statut" required>
                    <option value="en_cours" <?php echo ($emprunt['statut'] == 'en_cours') ? 'selected' : ''; ?>>En cours</option>
                    <option value="rendu" <?php echo ($emprunt['statut'] == 'rendu') ? 'selected' : ''; ?>>Rendu</option>
                    <option value="en_retard" <?php echo ($emprunt['statut'] == 'en_retard') ? 'selected' : ''; ?>>En retard</option>
                </select>
            </div>

            <div class="form-actions">
                <input type="submit" value="Mettre a jour" class="btn-submit">
                <a href="../../index.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>

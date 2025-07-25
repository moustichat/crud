<?php
require_once('./../../config/database.php');
require_once('./../../classes/Emprunt.php');
require_once('./../../classes/Bibliotheque.php');

$biblioModel = new Bibliotheque($pdo);
$errors = [];

// Récupérer les livres et membres pour les selects
$livres = $biblioModel->getAllLivres();
$membres = $biblioModel->getAllMembres();

// Traitement du formulaire
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

    // Si pas d'erreurs, création de l'emprunt
    if (empty($errors)) {
        try {
            $empruntModel->create($id_emprunt);
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
    <title>Creation d'un emprunt</title>
</head>

<body>
    <div class="container">
        <h1>Ajouter un emprunt</h1>

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
                <label for="id_livre">Livre *</label>
                <select name="id_livre" id="id_livre" required>
                    <option value="">Choisir un livre</option>
                    <?php foreach ($livres as $livre): ?>
                        <option value="<?php echo $livre['id_livre']; ?>"><?php echo htmlspecialchars($livre['titre']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="id_membre">Membre *</label>
                <select name="id_membre" id="id_membre" required>
                    <option value="">Choisir un membre</option>
                    <?php foreach ($membres as $membre): ?>
                        <option value="<?php echo $membre['id_membre']; ?>"><?php echo htmlspecialchars("{$membre['prenom']} {$membre['nom']}"); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="date_emprunt">Date d'emprunt *</label>
                <input type="date" name="date_emprunt" id="date_emprunt" required>
            </div>
            <div>
                <label for="date_retour_prevue">Date de retour prevue *</label>
                <input type="date" name="date_retour_prevue" id="date_retour_prevue" required>
            </div>
            <div>
                <label for="statut">Statut *</label>
                <select name="statut" id="statut" required>
                    <option value="en_cours">En cours</option>
                    <option value="rendu">Rendu</option>
                    <option value="en_retard">En retard</option>
                </select>
            </div>

            <input type="submit" value="Ajouter">
        </form>
    </diV>
</body>

</html>

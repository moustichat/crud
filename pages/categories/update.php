<?php
require_once('./../../config/database.php');
require_once('./../../classes/Categorie.php');
require_once('./../../classes/Bibliotheque.php');

$errors = [];
$categorie = null;

// Récupération de l'ID de la catégorie à modifier
$biblioModel = new Bibliotheque($pdo);
$id_categorie = $_GET['id_categorie'] ?? null;

if (!$id_categorie) {
    header('Location: ../../index.php?error=missing_id');
    exit;
}

// Récupération des données de la catégorie
try {
    $categorie = $biblioModel->getCategorie($id_categorie);
    if (!$categorie) {
        header('Location: ../../index.php?error=categorie_not_found');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../../index.php?error=database_error');
    exit;
}

// Traitement du formulaire de modification
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
            $categorieModel->update($id_categorie);
            header('Location: ../../index.php?message=categorie_updated');
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
    <title>Modifier une catégorie</title>
</head>

<body>
    <div class="container">
        <h1>Modifier la catégorie</h1>
        
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
                <label for="nom_categorie">Nom de la catégorie *</label>
                <input type="text" name="nom_categorie" id="nom_categorie" 
                       value="<?php echo htmlspecialchars($categorie['nom_categorie'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea name="description" id="description" rows="4" 
                          placeholder="Description de la catégorie..." 
                          required><?php echo htmlspecialchars($categorie['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-actions">
                <input type="submit" value="Mettre à jour" class="btn-submit">
                <a href="../../index.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>

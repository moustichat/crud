<?php
require_once('./../../config/database.php');
require_once('./../../classes/Livre.php');

$livreModel = new Livre($pdo);
$errors = [];
$livre = null;

// Récupération de l'ID du livre à modifier
$id_livre = $_GET['id_livre'] ?? null;

if (!$id_livre) {
    header('Location: ../../index.php?error=missing_id');
    exit;
}

// Récupération des données du livre
try {
    $livre = $livreModel->getById($id_livre);
    if (!$livre) {
        header('Location: ../../index.php?error=livre_not_found');
        exit;
    }
} catch (Exception $e) {
    header('Location: ../../index.php?error=database_error');
    exit;
}

// Traitement du formulaire de modification
if ($_POST) {
    $titre = $_POST['titre'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $date_publication = $_POST['date_publication'] ?? '';
    $nombre_pages = $_POST['nombre_pages'] ?? '';
    $nombre_exemplaires = $_POST['nombre_exemplaires'] ?? '';
    $disponible = isset($_POST['disponible']) ? 1 : 0;
    $resume = $_POST['resume'] ?? '';

    // Validation basique
    if (empty($titre)) {
        $errors[] = "Le titre est requis.";
    }
    if (empty($isbn)) {
        $errors[] = "L'ISBN est requis.";
    }
    if (empty($date_publication)) {
        $errors[] = "La date de publication est requise.";
    }
    if (empty($nombre_pages) || $nombre_pages <= 0) {
        $errors[] = "Le nombre de pages doit être positif.";
    }
    if (empty($nombre_exemplaires) || $nombre_exemplaires <= 0) {
        $errors[] = "Le nombre d'exemplaires doit être positif.";
    }

    // Si pas d'erreurs, mise à jour du livre
    if (empty($errors)) {
        try {
            $livreModel->update($id_livre, $titre, $isbn, $date_publication, $nombre_pages, $nombre_exemplaires, $disponible, $resume);
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
    <title>Modifier un livre</title>
</head>

<body>
    <div class="container">
        <h1>Modifier le livre</h1>
        
        <div class="back-link">
            <a href="../../index.php" class="btn-back">← Retour à la liste</a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="error-messages">
                <h3>Erreurs détectées :</h3>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" class="update-form">
            <div class="form-group">
                <label for="titre">Titre *</label>
                <input type="text" name="titre" id="titre" 
                       value="<?php echo htmlspecialchars($livre['titre'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN *</label>
                <input type="text" name="isbn" id="isbn" 
                       value="<?php echo htmlspecialchars($livre['isbn'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="date_publication">Date de publication *</label>
                <input type="date" name="date_publication" id="date_publication" 
                       value="<?php echo htmlspecialchars($livre['date_publication'] ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="nombre_pages">Nombre de pages *</label>
                <input type="number" name="nombre_pages" id="nombre_pages" 
                       value="<?php echo htmlspecialchars($livre['nombre_pages'] ?? ''); ?>" 
                       min="1" required>
            </div>

            <div class="form-group">
                <label for="nombre_exemplaires">Nombre d'exemplaires *</label>
                <input type="number" name="nombre_exemplaires" id="nombre_exemplaires" 
                       value="<?php echo htmlspecialchars($livre['nombre_exemplaires'] ?? ''); ?>" 
                       min="1" required>
            </div>

            <div class="form-group checkbox-group">
                <label for="disponible">Disponible</label>
                <input type="checkbox" name="disponible" id="disponible" 
                       <?php echo ($livre['disponible'] ?? 0) ? 'checked' : ''; ?>>
            </div>

            <div class="form-group">
                <label for="resume">Résumé</label>
                <textarea name="resume" id="resume" rows="4" 
                          placeholder="Résumé du livre..."><?php echo htmlspecialchars($livre['resume'] ?? ''); ?></textarea>
            </div>

            <div class="form-actions">
                <input type="submit" value="Mettre à jour" class="btn-submit">
                <a href="../../index.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>

<?php
require_once('./../../config/database.php');
require_once('./../../classes/Livre.php');
require_once('./../../classes/Bibliotheque.php');


$biblioModel = new Bibliotheque($pdo);
$auteurs = $biblioModel->getAllAuteurs();
$categories = $biblioModel->getAllCategories();
$errors = [];
$id_livre = $_GET['id_livre'];
$livre = $biblioModel->getLivre($id_livre);

// Traitement du formulaire de modification
if ($_POST) {
    $livreModel = new Livre($pdo,
                            $_POST['titre'] ?? '',
                            $_POST['isbn'] ?? '',
                            $_POST['id_auteur'] ?? '',
                            $_POST['id_categorie'] ?? '',
                            $_POST['date_publication'] ?? '',
                            $_POST['nombre_pages'] ?? '',
                            $_POST['nombre_exemplaires'] ?? '',
                            isset($_POST['disponible']) ? 1 : 0,
                            $_POST['resume'] ?? '');

    // Validation basique
    if (empty($_POST['titre'])) {
        $errors[] = "Le titre est requis.";
    }
    if (empty($_POST['isbn'])) {
        $errors[] = "L'ISBN est requis.";
    }
    if (empty($_POST['date_publication'])) {
        $errors[] = "La date de publication est requise.";
    }
    if (empty($_POST['nombre_pages']) || $_POST['nombre_pages'] <= 0) {
        $errors[] = "Le nombre de pages doit être positif.";
    }
    if (empty($_POST['nombre_exemplaires']) || $_POST['nombre_exemplaires'] <= 0) {
        $errors[] = "Le nombre d'exemplaires doit être positif.";
    }
    if ($biblioModel->isbnExists($_POST['isbn']) != $id_livre) {
        $errors[] = "Cet email est déja utilisé";
    }

    // Si pas d'erreurs, mise à jour du livre
    if (empty($errors)) {
        try {
            $livreModel->update($livre['id_livre']);
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

        <div>
            <?php $auteur = $biblioModel->getAuteur($livre['id_auteur']); ?>
            <label for="id_auteur">Auteur *</label>
            <select name="id_auteur" id="id_auteur" required>
                <option value = <?php echo $livre['id_auteur'] ?>><?php echo htmlspecialchars($auteur['prenom']) ?> <?php echo htmlspecialchars($auteur['nom']) ?></option>
                <?php foreach ($auteurs as $auteur): ?>
                    <option value="<?php echo $auteur['id_auteur']; ?>">
                        <?php echo htmlspecialchars("{$auteur['prenom']} {$auteur['nom']}"); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="id_categorie">Catégorie *</label>
            <select name="id_categorie" id="id_categorie" required>
                <option value = <?php echo $livre['id_categorie'] ?>><?php echo htmlspecialchars(($biblioModel->getCategorie($livre['id_categorie']))['nom_categorie']) ?></option>
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?php echo $categorie['id_categorie']; ?>">
                        <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

            <div class="form-actions">
                <input type="submit" value="Mettre à jour" class="btn-submit">
                <a href="../../index.php" class="btn-cancel">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>

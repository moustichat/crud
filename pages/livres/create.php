<?php

require_once('./../../config/database.php');
require_once('./../../classes/Livre.php');
require_once('./../../classes/Bibliotheque.php');


$biblioModel = new Bibliotheque($pdo);
$auteurs = $biblioModel->getAllAuteurs();
$categories = $biblioModel->getAllCategories();
$errors = [];


// Traitement du formulaire

if ($_POST) {
    $livreModel = new Livre($pdo,
                            $_POST['titre'],
                            $_POST['isbn'] ?? '',
                            $_POST['id_auteur'] ?? '',
                            $_POST['id_categorie'] ?? '',
                            $_POST['date_publication'] ?? '',
                            $_POST['nombre_pages'] ?? '',
                            $_POST['nombre_exemplaires'] ?? '',
                            isset($_POST['disponible']) ? 1 : 0,
                            $_POST['resume'] ?? '');

    // Validation des donnees (A faire)

    // Gestion des erreur (A faire)
    $livreModel->create();
    header('Location: http://localhost/crud?message=created'); // permet de rediriger a la page d'accueil en cas de creation reussie.
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Creation d'un livre</title>
</head>

<body>
    <h1> Ajouter un livre</h1>
    <form method="POST">    
        <div>
            <label for="titre">Titre *</label>
            <input type="text" name="titre" id="titre" required>
        </div>
        <div>
            <label for="isbn">ISBN *</label>
            <input type="text" name="isbn" id="isbn" required>
        </div>
        <div>
            <label for="date_publication">Date de publication *</label>
            <input type="date" name="date_publication" id="date_publication" required>
        </div>
        <div>
            <label for="nombre_pages">Nombre de pages *</label>
            <input type="number" name="nombre_pages" id="nombre_pages" required>
        </div>
        <div>
            <label for="nombre_exemplaires">Nombre d'exemplaires *</label>
            <input type="text" name="nombre_exemplaires" id="nombre_exemplaires" required>
        </div>
        <div>
            <label for="disponible">Disponible *</label>
            <input type="checkbox" name="disponible" id="disponible" required>
        </div>
        <div>
            <label for="resume">Resume *</label>
            <input type="text" name="resume" id="resume" required>
        </div>
        <div>
            <label for="id_auteur">Auteur *</label>
            <select name="id_auteur" id="id_auteur" required>
                <option value="">-- Sélectionner un auteur --</option>
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
                <option value="">-- Sélectionner une catégorie --</option>
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?php echo $categorie['id_categorie']; ?>">
                        <?php echo htmlspecialchars($categorie['nom_categorie']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="submit" value="Ajouter">
    </form>
</body>

</html>
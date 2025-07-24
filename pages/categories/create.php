<?php
require_once('./../../config/database.php');
require_once('./../../classes/Categorie.php');

$categorieModel = new Categorie($pdo);
$errors = [];


// Traitement du formulaire
if ($_POST) {
    $nom_categorie = $_POST['nom_categorie'] ?? '';
    $description = $_POST['description'] ?? '';

    // Validation des donnees (A faire)

    // Gestion des erreur (A faire)
    $categorieModel->create($nom_categorie, $description);
    header('Location: http://localhost/crud?message=created'); // permet de rediriger a la page d'accueil en cas de creation reussie.
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Creation d'une catégorie</title>
</head>

<body>
    <h1> Ajouter une catégorie</h1>
    <form method="POST">    
        <div>
            <label for="nom_categorie">nom de la catégorie *</label>
            <input type="text" name="nom_categorie" id="nom_categorie" required>
        </div>
        <div>
            <label for="description">description *</label>
            <input type="text" name="description" id="description" required>
        </div>


    <input type="submit" value="Ajouter">
    </form>
</body>

</html>
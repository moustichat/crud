<?php
require_once('./../../config/database.php');
require_once('./../../classes/Auteur.php');

$auteurModel = new Auteur($pdo);
$errors = [];


// Traitement du formulaire
if ($_POST) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $nationalite = $_POST['nationalite'] ?? '';

    // Validation des donnees (A faire)

    // Gestion des erreur (A faire)
    $auteurModel->create($nom, $prenom, $date_naissance, $nationalite);
    header('Location: http://localhost/crud?message=created'); // permet de rediriger a la page d'accueil en cas de creation reussie.
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Creation d'un auteur</title>
</head>

<body>
    <h1> Ajouter un auteur</h1>
    <form method="POST">    
        <div>
            <label for="nom">nom *</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <div>
            <label for="prenom">prenom *</label>
            <input type="text" name="prenom" id="prenom" required>
        </div>
        <div>
            <label for="date_naissance">Date de naissance *</label>
            <input type="date" name="date_naissance" id="date_naissance" required>
        </div>
        <div>
            <label for="nationalite">nationalite *</label>
            <input type="text" name="nationalite" id="nationalite" required>
        </div>


    <input type="submit" value="Ajouter">
    </form>
</body>

</html>
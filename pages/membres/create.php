<?php
require_once('./../../config/database.php');
require_once('./../../classes/Membre.php');

$membreModel = new Membre($pdo);
$errors = [];

// Traitement du formulaire
if ($_POST) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $adresse = $_POST['adresse'] ?? '';

    // Validation des donnees (A faire)

    // Gestion des erreur (A faire)
    $membreModel->create($nom, $prenom, $email, $telephone, $adresse);
    header('Location: http://localhost/crud?message=created'); // permet de rediriger a la page d'accueil en cas de creation reussie.
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style.css">
    <title>Creation d'un membre</title>
</head>

<body>
    <h1>Ajouter un membre</h1>
    <form method="POST">    
        <div>
            <label for="nom">Nom *</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <div>
            <label for="prenom">Prenom *</label>
            <input type="text" name="prenom" id="prenom" required>
        </div>
        <div>
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="telephone">Telephone</label>
            <input type="text" name="telephone" id="telephone">
        </div>
        <div>
            <label for="adresse">Adresse</label>
            <textarea name="adresse" id="adresse" rows="3"></textarea>
        </div>

        <input type="submit" value="Ajouter">
    </form>
</body>

</html>

<?php
require_once('./../../config/database.php');
require_once('./../../classes/Emprunt.php');

$empruntModel = new Emprunt($pdo);
$errors = [];

// Récupérer les livres et membres pour les selects
$livres = $empruntModel->getAllAuteursLivres();
$membres = $empruntModel->getAllAuteursMembres();

// Traitement du formulaire
if ($_POST) {
    $id_livre = $_POST['id_livre'] ?? '';
    $id_membre = $_POST['id_membre'] ?? '';
    $date_emprunt = $_POST['date_emprunt'] ?? '';
    $date_retour_prevue = $_POST['date_retour_prevue'] ?? '';
    $statut = $_POST['statut'] ?? '';

    // Validation des donnees (A faire)

    // Gestion des erreur (A faire)
    $empruntModel->create($id_livre, $id_membre, $date_emprunt, $date_retour_prevue, $statut);
    header('Location: http://localhost/crud?message=created'); // permet de rediriger a la page d'accueil en cas de creation reussie.
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
    <h1>Ajouter un emprunt</h1>
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
                    <option value="<?php echo $membre['id_membre']; ?>"><?php echo htmlspecialchars($membre['nom_complet']); ?></option>
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
</body>

</html>

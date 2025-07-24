<?php
require_once('config/database.php');
require_once('classes/Livre.php');
require_once('classes/Auteur.php');
require_once('classes/Categorie.php');
require_once('classes/Membre.php');
require_once('classes/Emprunt.php');


$livreModel = new Livre($pdo);
$livres = $livreModel->getAll();

$auteurModel = new Auteur($pdo);
$auteurs = $auteurModel->getAll();

$categorieModel = new Categorie($pdo);
$categories = $categorieModel->getAll();

$membreModel = new Membre($pdo);
$membres = $membreModel->getAll();

$empruntModel = new Emprunt($pdo);
$emprunts = $empruntModel->getAll();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Biblio</title>
</head>

<body>
    <h1 id="livres">Liste des livres</h1>
    <a href="pages/livres/create.php">Ajouter un livre</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Date de publication</th>
                <th>Disponible</th>
                <th>Résumé</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($livres as $livre):  ?>
                
                <tr>
                    <td><?php echo htmlspecialchars($livre['id_livre']) ?></td>
                    <td><?php echo htmlspecialchars($livre['titre']) ?></td>
                    <td><?php echo htmlspecialchars($livre['date_publication']) ?></td>
                    <td><?php echo $livre['disponible'] == 1 ? 'OUI' : 'NON' ?></td>
                    <td><?php echo htmlspecialchars($livre['resume']) ?></td>
                    <td>
                        <a href="pages/livres/update.php?id_livre=<?php echo $livre['id_livre'] ?>" class="btn-edit">✏️</a>
                        <a href="pages/livres/delete.php?id_livre=<?php echo $livre['id_livre'] ?>" class="btn-delete">❌</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($livres)): ?>
        <p>Aucun livre trouve, <a href="">Ajoutez le premier livre</a>!</p>
    <?php endif; ?>


    <h1 id="auteurs">Liste des auteurs</h1>
    <a href="pages/auteurs/create.php">Ajouter un auteur</a>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de naissance</th>
                <th>nationalité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($auteurs as $auteur):  ?>
                
                <tr>
                    <td><?php echo htmlspecialchars($auteur['nom']) ?></td>
                    <td><?php echo htmlspecialchars($auteur['prenom']) ?></td>
                    <td><?php echo htmlspecialchars($auteur['date_naissance']) ?></td>
                    <td><?php echo htmlspecialchars($auteur['nationalite']) ?></td>
                    <td>
                        <a href="pages/auteurs/update.php?id_auteur=<?php echo $auteur['id_auteur'] ?>" class="btn-edit">✏️</a>
                        <a href="pages/auteurs/delete.php?id_auteur=<?php echo $auteur['id_auteur'] ?>" class="btn-delete">❌</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($auteurs)): ?>
        <p>Aucun auteur trouvé, <a href="">Ajoutez le premier auteur</a>!</p>
    <?php endif; ?>


    <h1 id="categories">Liste des catégories</h1>
    <a href="pages/categories/create.php">Ajouter une catégorie</a>
    <table>
        <thead>
            <tr>
                <th>Nom de la catégorie</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $categorie):  ?>
                
                <tr>
                    <td><?php echo htmlspecialchars($categorie['nom_categorie']) ?></td>
                    <td><?php echo htmlspecialchars($categorie['description']) ?></td>
                    <td>
                        <a href="pages/categories/update.php?id_categorie=<?php echo $categorie['id_categorie'] ?>" class="btn-edit">✏️</a>
                        <a href="pages/categories/delete.php?id_categorie=<?php echo $categorie['id_categorie'] ?>" class="btn-delete">❌</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($categories)): ?>
        <p>Aucune catégorie trouvée, <a href="">Ajoutez la premiere catégorie</a>!</p>
    <?php endif; ?>


    <h1 id="membres">Liste des membres</h1>
    <a href="pages/membres/create.php">Ajouter un membre</a>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Actif</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($membres as $membre):  ?>
                <tr>
                    <td><?php echo htmlspecialchars($membre['nom']) ?></td>
                    <td><?php echo htmlspecialchars($membre['prenom']) ?></td>
                    <td><?php echo htmlspecialchars($membre['email']) ?></td>
                    <td><?php echo htmlspecialchars($membre['telephone']) ?></td>
                    <td><?php echo $membre['actif'] == 1 ? 'OUI' : 'NON' ?></td>
                    <td>
                        <a href="pages/membres/update.php?id_membre=<?php echo $membre['id_membre'] ?>" class="btn-edit">✏️</a>
                        <a href="pages/membres/delete.php?id_membre=<?php echo $membre['id_membre'] ?>" class="btn-delete">❌</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($membres)): ?>
        <p>Aucun membre trouvé, <a href="">Ajoutez le premier membre</a>!</p>
    <?php endif; ?>


    <h1 id="emprunts">Liste des emprunts</h1>
    <a href="pages/emprunts/create.php">Ajouter un emprunt</a>
    <table>
        <thead>
            <tr>
                <th>Livre</th>
                <th>Membre</th>
                <th>Date emprunt</th>
                <th>Date retour prevue</th>
                <th>Date retour effectif</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($emprunts as $emprunt):  ?>
                <tr>
                    <td><?php echo htmlspecialchars($emprunt['titre']) ?></td>
                    <td><?php echo htmlspecialchars($emprunt['membre_nom']) ?></td>
                    <td><?php echo htmlspecialchars($emprunt['date_emprunt']) ?></td>
                    <td><?php echo htmlspecialchars($emprunt['date_retour_prevue']) ?></td>
                    <td><?php echo htmlspecialchars($emprunt['date_retour_effectif'] ?? 'Non rendu') ?></td>
                    <td><?php echo htmlspecialchars($emprunt['statut']) ?></td>
                    <td>
                        <a href="pages/emprunts/update.php?id_emprunt=<?php echo $emprunt['id_emprunt'] ?>" class="btn-edit">✏️</a>
                        <a href="pages/emprunts/delete.php?id_emprunt=<?php echo $emprunt['id_emprunt'] ?>" class="btn-delete">❌</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (empty($emprunts)): ?>
        <p>Aucun emprunt trouvé, <a href="">Ajoutez le premier emprunt</a>!</p>
    <?php endif; ?>
</body>

</html>
<?php
require_once('./../../config/database.php');
require_once('./../../classes/Auteur.php');
require_once('./../../classes/Bibliotheque.php');

$biblioModel = new Bibliotheque($pdo);

$id_auteur = $_GET['id_auteur'] ?? null;

$biblioModel->delAuteur($id_auteur);

header('Location: ../../index.php#auteurs');

?>


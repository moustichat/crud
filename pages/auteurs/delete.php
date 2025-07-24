<?php
require_once('./../../config/database.php');
require_once('./../../classes/Auteur.php');

$auteurModel = new Auteur($pdo);

$id_auteur = $_GET['id_auteur'] ?? null;

$auteurModel->delAuteur($id_auteur);

header('Location: ../../index.php#auteurs');

?>


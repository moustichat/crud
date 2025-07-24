<?php
require_once('./../../config/database.php');
require_once('./../../classes/Categorie.php');

$categorieModel = new Categorie($pdo);

$id_categorie = $_GET['id_categorie'] ?? null;

$categorieModel->delCategorie($id_categorie);

header('Location: ../../index.php#categories');


?>
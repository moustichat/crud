<?php
require_once('./../../config/database.php');
require_once('./../../classes/Categorie.php');
require_once('./../../classes/Bibliotheque.php');

$biblioModel = new Bibliotheque($pdo);

$id_categorie = $_GET['id_categorie'] ?? null;

$biblioModel->delCategorie($id_categorie);

header('Location: ../../index.php#categories');


?>
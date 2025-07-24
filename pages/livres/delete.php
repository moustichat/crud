<?php
require_once('../../config/database.php');
require_once('../../classes/Livre.php');
require_once('./../../classes/Bibliotheque.php');
 
$biblioModel = new Bibliotheque($pdo);
 
$id_livre = $_GET['id_livre'];
 
$biblioModel->delLivre($id_livre);
 
header('Location: ../../index.php#livres');
 
 
?>
 
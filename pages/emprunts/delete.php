<?php
require_once('../../config/database.php');
require_once('../../classes/Emprunt.php');
require_once('./../../classes/Bibliotheque.php');
 
$biblioModel = new Bibliotheque($pdo);
 
$id_emprunt = $_GET['id_emprunt'];
 
$biblioModel->delEmprunt($id_emprunt);
 
header('Location: ../../index.php#emprunts');
 
?>

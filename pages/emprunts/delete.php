<?php
require_once('../../config/database.php');
require_once('../../classes/Emprunt.php');
 
$empruntModel = new Emprunt($pdo);
 
$id_emprunt = $_GET['id_emprunt'];
 
$empruntModel->delEmprunt($id_emprunt);
 
header('Location: ../../index.php#emprunts');
 
?>

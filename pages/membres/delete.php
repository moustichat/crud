<?php
require_once('../../config/database.php');
require_once('../../classes/Membre.php');
 
$membreModel = new Membre($pdo);
 
$id_membre = $_GET['id_membre'];
 
$membreModel->delMembre($id_membre);
 
header('Location: ../../index.php#membres');
 
?>

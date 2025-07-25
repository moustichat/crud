<?php
require_once('../../config/database.php');
require_once('../../classes/Membre.php');
require_once('./../../classes/Bibliotheque.php');
 
$biblioModel = new Bibliotheque($pdo);
 
$biblioModel->delMembre($_GET['id_membre']);
 
header('Location: ../../index.php#membres');
 
?>

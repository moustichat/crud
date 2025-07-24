<?php
require_once('../../config/database.php');
require_once('../../classes/Livre.php');
 
$livreModel = new Livre($pdo);
 
$id_livre = $_GET['id_livre'];
 
$livreModel->delLivre($id_livre);
 
header('Location: ../../index.php#livres');
 
 
?>
 
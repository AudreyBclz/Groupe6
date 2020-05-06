<?php
require_once '../views/elements/head.php';
require_once '../views/elements/footer.php';
session_start();
head();
$_SESSION['nom']="";
$_SESSION['prenom']="";
session_destroy();
header('Location:../../index.php');
?>

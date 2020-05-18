<?php

$_SESSION['nom']="";
$_SESSION['prenom']="";
session_destroy();
header('Location:accueil');
?>

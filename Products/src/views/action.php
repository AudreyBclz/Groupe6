<?php

require_once '../views/elements/head.php';
require_once '../views/elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

head();

$db = connect();

if(!isset($_GET['id']) || !isset($_GET['action']))
{
    header('Location:../../products.php');
}

if ($_GET['action']=="delete")
{
    $sqlDel='DELETE FROM products
             WHERE id='.$_GET['id'];
    $reqDel=$db->prepare($sqlDel);
    $reqDel->execute();
    echo '<div class="alert-danger">produit supprimé</div>
           <a href="../../products.php" class="btn btn-dark"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>';
}

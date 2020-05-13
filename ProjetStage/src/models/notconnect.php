<?php
function notco()
{
    if(!isset($_SESSION['iduser']))
    {
        header('Location:../../index.php');
    }
}

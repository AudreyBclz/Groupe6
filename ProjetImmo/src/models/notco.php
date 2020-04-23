<?php function notconnected()
{
    if (!isset($_SESSION['agence']) && !isset($_SESSION['client']))
    {
        header('Location:../../home.php');
    }
}



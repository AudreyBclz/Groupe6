<?php
session_start();
 ?>
<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="../../public/css/index.css">

    <title></title>
</head>
<body class="bg-grey">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">DamienLocation</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->generate('accueil') ?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= $router->generate('inscription') ?>">Ajout Client/Agence</a>
            </li>

            <?php
            if(isset($_SESSION['agence']) && isset($_SESSION['client'])) {
                if ($_SESSION['agence'] || $_SESSION['client']) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate('annonces') ?>">Annonces</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate('contact') ?>">Contact</a>
                    </li>
                    <?php if ($_SESSION['agence']) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $router ->generate('ajoutAnnonce') ?>">Ajout de bien</a>
                        </li>
                    <?php }

                    if ($_SESSION['agence']) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $router->generate('gestionBiens') ?>">Gestion biens</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->generate('disconected') ?>">Déconnexion</a>
                    </li>
                <?php }
            }?>
        </ul>
    </div>
</nav>



    <?php
 ?>


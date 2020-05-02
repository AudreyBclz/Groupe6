<?php
function head()
{ ?>
    <!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="../../public/css/index.css">

    <title></title>
</head>
<body class="bg-vert">
<div class="d-flex">
    <nav class="bg-marron navbar-light text-center d-none" id="navigation" role="navigation">
        <div class="h-100 d-flex flex-column justify-content-between" id="navbarNav">
            <div>
                <a class="navbar-brand" href="../../index.php"><img src="../../public/img/tasseCafe64.png"></a>
                <ul class="nav navbar-light flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="panier.php">Mon panier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Connexion<span class="d-none d-lg-block m-0">/Inscription</span></a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="inscription.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class=" nav-link active" href="selection.php">Sélection de la semaine</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="plusvendus.php">Les + vendus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nosproduits.php">Tous nos produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ajoutcafe.php">Ajout Café</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="modifcafe.php">Modification Café</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Déconnexion</a>
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-light flex-column footer">
                <li class="nav-item text-light">
SARL Paradise Coffee<br/>
                    87 rue des Fleurs <br/>
                    54000 NANCY
</li>
                <li class="nav-item text-light">
Contact:<br/>
                    paradise.coffee@aol.fr
</li>
            </ul>
        </div>
    </nav>
</div>
<div>
    <div id="croix" class="d-none">
        <i class="fa fa-times"></i>
    </div>
    <div id="plus">
        <i class="fa fa-bars"></i>
    </div>
</div>
<?php }
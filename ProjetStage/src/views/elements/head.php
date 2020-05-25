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


    <title></title>
</head>
<body class="bg-vert">
<div class="d-flex">
    <nav class="bg-marron navbar-light text-center d-none" id="navigation" role="navigation">
        <div class="h-100 d-flex flex-column justify-content-between" id="navbarNav">
            <div>
                <a class="navbar-brand" href="accueil"><img src="public/img/tasseCafe64.png"></a>
                <ul class="nav navbar-light flex-column">
                    <?php if(isset($_SESSION['nom']) && isset($_SESSION['prenom']))
                        { ?>
                    <li class="mb-5 mt-1">
                        <span class=" text-light font-weight-bold">Bonjour <?= $_SESSION['prenom'].' '.$_SESSION['nom'] ?></span>
                    </li>
                            <?php } ?>
                    <?php if(isset($_SESSION['iduser']))
                        { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="monpanier">Mon panier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historique_commande">Historique des commandes</a>
                    </li>
                            <?php }
                            if(!isset($_SESSION['iduser']))
                                { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="connexion&ins">Connexion<span class="d-none d-lg-block m-0">/Inscription</span></a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="inscription">Inscription</a>
                    </li>
                                <?php } ?>
                    <li class="nav-item">
                        <a class=" nav-link active" href="selection">Sélection de la semaine</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="lesplusvendus">Les + vendus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="nosproduits">Tous nos produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact">Contact</a>
                    </li>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role']==='admin')
                        { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="ajoutCafe">Ajout Café</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ajout_fournisseur">Ajout fournisseur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dateLivraison">Mettre en livraison les commandes</a>
                    </li>
                            <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link" href="deconnexion">Déconnexion</a>
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
                    06-05-04-03-02
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
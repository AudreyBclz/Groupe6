<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';

session_start();
head();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">DamienLocation</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="../../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ajoutClAg.php">Ajout Client/Agence</a>
            </li>
            <?php
            if(isset($_SESSION['agence']) && isset($_SESSION['client']))
            {
            if($_SESSION['agence'] || $_SESSION['client'])
            { ?>
            <li class="nav-item">
                <a class="nav-link" href="./location.php">Location</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./contact.php">Contact</a>
            </li>
            <?php if($_SESSION['agence'])
                { ?>
            <li class="nav-item">
                <a class="nav-link" href="./ajoutbien.php">Ajout de bien</a>
            </li>
            <?php }

            if($_SESSION['agence'])
                { ?>
            <li class="nav-item">
                <a class="nav-link" href="gererMesBiens.php">Gestion biens</a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="../models/deconnect.php">Déconnexion</a>
            </li>
            <?php }
            } ?>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row mt-5 d-flex justify-content-center">
        <div class="col-xs-5 col-sm-5 col-md-5  col-lg-4  col-xl-4 ">
            <img class="card-img-top" src="../../public/img/maison_bleue.jpg" alt="Card image cap">
        </div>

        <div class="col-xs-5 col-sm-5 col-md-5  col-lg-5  col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Bienvenue sur IMMO-Blier!!</h5>
                    <p class="card-text">Le site de ventes et locations de biens immobiliers de Bernard Blier!</p>

                    <p>"Chez moi on ne vends pas, on ventile!!"</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab animi aperiam beatae eligendi esse harum iste mollitia nihil numquam officiis perferendis quos ratione recusandae repellat, sint sunt totam vero voluptates?</p>
                </div>
            </div>
        </div>

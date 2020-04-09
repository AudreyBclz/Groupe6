<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';

head();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="../../index.php">DamienLocation</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="location.php">Location</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">

    <div class="row">
        <h1>Voici une sélection de nos biens immobiliers </h1>
    </div>


    <div class="card-group">
        <div class="card">
            <img class="card-img-top" src="../../public/img/cabane.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">La cabane au fond du jardin</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <div class="row">
                    <a href="./detail.php">
                        <span class="btn btn-outline-secondary">Voir +</span>
                    </a>
                </div>
            </div>
            <div class="card-footer">
                <h6>130 000 Euro net vendeur</h6>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="../../public/img/maison_bleue.jpg" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">C'est une maison bleue...</h5>
                <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
                <div class="row">
                    <a href="./detail.php">
                        <span class="btn btn-outline-secondary">Voir +</span>
                    </a>
                </div>
            </div>
            <div class="card-footer">
                <h6>350 Euro net vendeur</h6>
            </div>
        </div>
        <div class="card">
            <img class="card-img-top" src="../../public/img/maison-luxe.png" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Petite maison "de caractère"</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                <div class="row">
                    <a href="./detail.php">
                        <span class="btn btn-outline-secondary">Voir +</span>
                    </a>
                </div>
            </div>
            <div class="card-footer">
                <h6>1 800 000 Euro (frais d'agences offerts)</h6>
            </div>
        </div>
    </div>
    <?php
footer();
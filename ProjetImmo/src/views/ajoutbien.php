<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

$db=connect();
head();
if (isset($_POST['titre']) && isset($_POST['resume']) && isset($_POST['superficie']) && isset($_POST['nbpiece']) && isset($_POST['prix']) && isset($_POST['description']))
{
    $sqlInsDet='INSERT INTO detail (Superficiedetail,nbPiecedetail,descdetail)
                VALUES(:super,:nbp,:descr)';
    $reqInsDet=$db->prepare($sqlInsDet);;
    $reqInsDet->bindParam(':super',$_POST['superficie']);
    $reqInsDet->bindParam(':nbp',$_POST['nbpiece']);
    $reqInsDet->bindParam(':descr',$_POST['description']);
    $reqInsDet->execute();
    $idDet=intval($db->lastInsertId());

    $sqlInsLoc='INSERT INTO location (titreLocation,resumeLocation,prixLocation,imageLocation,statusLocation,detail_iddetail)
                VALUES(:titre,:resume,:prix,:image,1,:id)';
    $reqInsLoc=$db->prepare($sqlInsLoc);
    $reqInsLoc->bindParam(':titre',$_POST['titre']);
    $reqInsLoc->bindParam(':resume',$_POST['resume']);
    $reqInsLoc->bindParam(':prix',$_POST['prix']);
    $reqInsLoc->bindParam(':image',$_FILES['image']['name']);
    $reqInsLoc->bindParam(':id',$idDet);
    $reqInsLoc->execute();

    echo'<div class="alert-success">Le bien a bien été ajouté</div>';
}
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
            <li class="nav-item">
                <a class="nav-link" href="location.php">Location</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="ajoutbien.php">Ajout de bien</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ajoutClAg.php">Ajout Client/Agence</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gererMesBiens.php">Gestion biens</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
   <div class="row">
       <h2 class="mx-auto mt-3"> Ajouter un bien immobilier</h2>
   </div>
    <div>
        <form method="post" action="ajoutbien.php" class="w-50 mx-auto mt-5" enctype="multipart/form-data">
            <div class="form-group row w-50">
                <label for="titre" class="form"> Titre de l'annonce :</label>
                <input type="text" name="titre" id="titre" class="form-control" required="required">

            </div>
            <div class="form-group row">
                <label for="resume">Résumé de l'annonce :</label>
                <textarea maxlength="255" name="resume" id="resume" class="form-control" required="required"></textarea>

            </div>
            <div class="row d-flex justify-content-between">
                <div class="form-group ">
                    <label for="superficie">Superficie :</label>
                    <input type="number" name="superficie" id="superficie" class="form-control" required="required">
                </div>

                <div class="form-group">
                    <label for="nbpiece">Nombre de pièces :</label>
                    <input type="number" name="nbpiece" id="nbpiece" class="form-control" required="required">
                </div>
                <div class="form-group">
                    <label for="prix">Prix : :</label>
                    <input type="number" name="prix" id="prix" class="form-control" required="required">
                </div>
           </div>
            <div class="form-group row">
                <label for="description">Description complète :</label>
                <textarea class="form-control" name="description" id="description" required="required"></textarea>
            </div>
            <div class="row">
                <label for="image">Photographie du bien :</label><br>
            </div>
            <div class="row">
                <input type="file" name="image" id="image">
            </div>
            <div class="row">
                <button type="submit" class="btn btn-dark mt-4">Envoyer</button>
            </div>
        </form>
    </div>
</div>
 <?php
footer();
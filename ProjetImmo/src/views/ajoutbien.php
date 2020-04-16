<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

$db=connect();
head();
session_start();
if ($_SESSION['client'])
{
    header('Location:../../index.php');
}
if (isset($_POST['titre']) &&isset($_POST['typeA']) && isset($_POST['typeBien']) && isset($_POST['resume']) &&
    isset($_POST['superficie']) && isset($_POST['nbpiece']) && isset($_POST['prix'])&& isset($_POST['adresse1']) && isset($_POST['ville'])
    && isset($_POST['codePost']) && isset($_POST['pays'])  && isset($_POST['description']))
{
    $sqlInsAd='INSERT INTO adresse (adresse1,adresse2,ville,codePostal,pays)
                VALUES(:ad1,:ad2,:ville,:cp,:pays)';
    $reqInsAd=$db->prepare($sqlInsAd);;
    $reqInsAd->bindParam(':ad1',$_POST['adresse1']);
    $reqInsAd->bindParam(':ad2',$_POST['adresse2']);
    $reqInsAd->bindParam(':ville',$_POST['ville']);
    $reqInsAd->bindParam(':cp',$_POST['codePost']);
    $reqInsAd->bindParam(':pays',$_POST['pays']);
    $reqInsAd->execute();
    $idAd=intval($db->lastInsertId());

    $sqlInsBien='INSERT INTO bien (titreBien,typeAnnonce,typeBien,resumeBien,superficieBien,nbpieceBien,prixBien,descBien,imageBien,statusBien,adresse_idadresse)
                VALUES(:titre,:typeA,:typeB,:resume,:super,:nbpiece,:prix,:descr,:image,1,:id)';
    $reqInsBien=$db->prepare($sqlInsBien);
    $reqInsBien->bindParam(':titre',$_POST['titre']);
    $reqInsBien->bindParam(':typeA',$_POST['typeA']);
    $reqInsBien->bindParam(':typeB',$_POST['typeBien']);
    $reqInsBien->bindParam(':resume',$_POST['resume']);
    $reqInsBien->bindParam(':super',$_POST['superficie']);
    $reqInsBien->bindParam(':nbpiece',$_POST['nbpiece']);
    $reqInsBien->bindParam(':prix',$_POST['prix']);
    $reqInsBien->bindParam(':descr',$_POST['description']);
    $reqInsBien->bindParam(':image',$_FILES['image']['name']);
    $reqInsBien->bindParam(':id',$idAd);
    $reqInsBien->execute();

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
                <a class="nav-link" href="ajoutClAg.php">Ajout Client/Agence</a>
            </li>
<?php
if(isset($_SESSION['agence']) && isset($_SESSION['client'])) {
    if ($_SESSION['agence'] || $_SESSION['client']) { ?>
        <li class="nav-item">
            <a class="nav-link" href="location.php">Location</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
        </li>

        <?php if ($_SESSION['agence']) { ?>
            <li class="nav-item active">
                <a class="nav-link" href="ajoutbien.php">Ajout de bien</a>
            </li>
        <?php } ?>

        <?php if ($_SESSION['agence']) { ?>
            <li class="nav-item">
                <a class="nav-link" href="gererMesBiens.php">Gestion biens</a>
            </li>
        <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="../models/deconnect.php">Déconnexion</a>
            </li>
   <?php }
}?>
        </ul>
    </div>
</nav>
<div class="container">
   <div class="row">
       <h2 class="mx-auto mt-3"> Ajouter un bien immobilier</h2>
   </div>
    <form method="post" action="ajoutbien.php" class="mx-auto mt-5" enctype="multipart/form-data">
    <div class="row justify-content-between">

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="form-group mr-4">
                            <label for="titre"> Titre de l'annonce :</label>
                            <input type="text" name="titre" id="titre" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label for="typeA"> Type d'Annonce :</label>
                            <select name="typeA" id="typeA" class="form-control">
                                <option value="Achat">Achat</option>
                                <option value="Location">Location</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group w-50">
                            <label for="typeBien"> Type de bien :</label>
                            <select name="typeBien" id="typeBien" class="form-control">
                                <option value="Maison">Maison</option>
                                <option value="Appartement">Appartement</option>
                                <option value="Garage">Garage</option>
                                <option value="Commerce">Commerce</option>
                                <option value="Terrain">Terrain</option>
                            </select>
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group row">
                            <label for="resume">Résumé de l'annonce :</label>
                            <textarea maxlength="255" name="resume" id="resume" class="form-control" required="required"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between row">
                        <div class="form-group">
                            <label for="superficie">Superficie :</label>
                            <input type="number" name="superficie" id="superficie" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label for="nbpiece">Nombre de pièces :</label>
                            <input type="number" name="nbpiece" id="nbpiece" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label for="prix">Prix :</label>
                            <input type="number" name="prix" id="prix" class="form-control" required="required">
                        </div>
                    </div>
                </div>
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="form-group row">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse1" required="required">
                </div>
                <div class="form-group row">
                    <label for="inputAddress2">Complément d'adresse</label>
                    <input type="text" class="form-control" id="inputAddress2" name="adresse2">
                </div>

                <div class="row form-group">
                    <div class="form-group">
                        <label for="inputCity">Ville</label>
                        <input type="text" class="form-control" id="inputCity" name="ville" required="required">
                    </div>
                </div>

                <div class="d-flex justify-content-between row">
                    <div class="form-group">
                        <label for="inputZip">Code Postal</label>
                        <input type="number" class="form-control" id="inputZip" name="codePost" required="required">
                    </div>
                    <div class="form-group">
                        <label for="inputState">Pays</label>
                        <input type="text" class="form-control" id="inputState" name="pays" required="required">
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
            </div>
            </form>



 <?php
footer();
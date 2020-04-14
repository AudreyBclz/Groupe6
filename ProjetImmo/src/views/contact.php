<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

head();
$db=connect();
if(isset($_POST['ct_email']) && isset($_POST['ct_adresse1']) && isset($_POST['ct_ville'])
    && isset($_POST['ct_codePost']) && isset($_POST['ct_pays']) && isset($_POST['ct_message']))
{
    $sqlInsAd='INSERT INTO adresse (email,adresse1,adresse2,ville,codepostal,pays)
                VALUES (:mail,:ad1,:ad2,:ville,:cp,:pays)';
    $reqInsAd=$db->prepare($sqlInsAd);
    $reqInsAd->bindParam(':mail',$_POST['ct_email']);
    $reqInsAd->bindParam(':ad1',$_POST['ct_adresse1']);
    $reqInsAd->bindParam(':ad2',$_POST['ct_adresse2']);
    $reqInsAd->bindParam(':ville',$_POST['ct_ville']);
    $reqInsAd->bindParam(':cp',$_POST['ct_codePost']);
    $reqInsAd->bindParam(':pays',$_POST['ct_pays']);
    $reqInsAd->execute();
    $idAd=intval($db->lastInsertId());

    $sqlInsCon='INSERT INTO contact (messagecontact,adresse_idadresse)
                VALUES (:msg,:id)';
    $reqInsCon=$db->prepare($sqlInsCon);
    $reqInsCon->bindParam(':msg',$_POST['ct_message']);
    $reqInsCon->bindParam(':id',$idAd);
    $reqInsCon->execute();

    echo '<div class="alert-success p-2 text-center">Votre message a bien été envoyé</div>';
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
            <li class="nav-item active">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
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
        <div class="col-xs-12 col-sm-12 col-md-6  col-lg-6  col-xl-6">
            <form class="mt-5" method="post" action="contact.php">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="ct_email" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="adresse">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="ct_adresse1" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputAddress2">Complément d'adresse</label>
                        <input type="text" class="form-control" id="inputAddress2" name="ct_adresse2">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputCity">Ville</label>
                        <input type="text" class="form-control" id="inputCity" name="ct_ville" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-between col-md-12">
                        <div class="form-group">
                            <label for="inputZip">Code Postal</label>
                            <input type="text" class="form-control w-50" id="inputZip" name="ct_codePost" required="required">
                        </div>
                        <div class="form-group">
                            <label for="inputState">Pays</label>
                            <input type="text" class="form-control w-50" id="inputState" name="ct_pays" required="required">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputmess">Message</label>
                        <textarea class="form-control" id="inputmess" name="ct_message" required="required"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-secondary">Envoyer</button>
            </form>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6  col-lg-6  col-xl-6 mt-5">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10165.462850644237!2d2.8071097344365343!3d50.434288369956704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47dd307d659025fd%3A0xb92f8bd91a43659a!2zQ29sbMOoZ2UgSmVhbiBKYXVyw6hz!5e0!3m2!1sfr!2sfr!4v1586439142378!5m2!1sfr!2sfr" width="500" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
    <?php
footer();

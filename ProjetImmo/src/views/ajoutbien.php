<?php
require_once 'elements/footer.php';
require_once 'src/config/config.php';
require_once 'src/models/connect.php';
require_once 'src/models/notco.php';

$db=connect();


notconnected();
if ($_SESSION['client'])
{
    header('Location:../../home.php');
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
<div class="container">
   <div class="row">
       <h2 class="mx-auto mt-3"> Ajouter un bien immobilier</h2>
   </div>
    <form method="post" action="ajoutbien.php" class="mx-auto mt-5" enctype="multipart/form-data">
    <div class="row justify-content-between">

                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="row ml-2">
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
                    <div class="row ml-2">
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
                        <div class="form-group row ml-2">
                            <label for="resume">Résumé de l'annonce :</label>
                            <textarea maxlength="255" name="resume" id="resume" class="form-control" required="required"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between row ml-2">
                        <div class="form-group">
                            <label for="superficie">Superficie :</label>
                            <input type="number" name="superficie" id="superficie" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label for="nbpiece">Nombre de pièces :</label>
                            <input type="number" name="nbpiece" id="nbpiece" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="row ml-2">
                        <div class="form-group">
                            <label for="prix">Prix :</label>
                            <input type="number" name="prix" id="prix" class="form-control" required="required">
                        </div>
                    </div>
                </div>
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                <div class="form-group row mx-2">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse1" required="required">
                </div>
                <div class="form-group row mx-2">
                    <label for="inputAddress2">Complément d'adresse</label>
                    <input type="text" class="form-control" id="inputAddress2" name="adresse2">
                </div>

                <div class="row form-group mx-2">
                    <div class="form-group">
                        <label for="inputCity">Ville</label>
                        <input type="text" class="form-control" id="inputCity" name="ville" required="required">
                    </div>
                </div>

                <div class="d-flex justify-content-between row mx-2">
                    <div class="form-group">
                        <label for="inputZip">Code Postal</label>
                        <input type="number" class="form-control" id="inputZip" name="codePost" required="required">
                    </div>
                    <div class="form-group">
                        <label for="inputState">Pays</label>
                        <input type="text" class="form-control" id="inputState" name="pays" required="required">
                    </div>
                </div>


                <div class="form-group row mx-2">
                    <label for="description">Description complète :</label>
                    <textarea class="form-control" name="description" id="description" required="required"></textarea>
                </div>
                <div class="row mx-2">
                    <label for="image">Photographie du bien :</label><br>
                </div>
                <div class="row mx-2">
                    <input type="file" name="image" id="image">
                </div>
                <div class="row mx-2">
                    <button type="submit" class="btn btn-dark mt-4">Envoyer</button>
                </div>
            </div>
            </form>



 <?php

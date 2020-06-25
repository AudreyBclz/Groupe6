<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once 'src/config/config.php';
require_once 'src/models/connect.php';
require_once 'src/models/notco.php';


$db=connect();
notconnected();

if (isset($_GET['action']) && isset($_GET['id']))
{
    if ($_GET['action']=="delete")
    {
        $sqlSelAd='SELECT adresse_idadresse FROM bien WHERE idbien= :id';
        $reqSelAd=$db->prepare($sqlSelAd);
        $reqSelAd->bindParam(':id',$_GET['id']);
        $reqSelAd->execute();
        $adresse=array();
        while ($data=$reqSelAd->fetchObject())
        {
            array_push($adresse,$data);
        }

        foreach ($adresse as $ad)
        {
            $idAd = intval($ad->adresse_idadresse);
        }
        $sqlDelAd='DELETE FROM adresse
                    WHERE idadresse=:idad';
        $reqDelAd=$db->prepare($sqlDelAd);
        $reqDelAd->bindParam(':idad',$idAd);
        $reqDelAd->execute();

        $sqlDelBien='DELETE FROM bien
                    WHERE idbien=:id';
        $reqDelBien=$db->prepare($sqlDelBien);
        $reqDelBien->bindParam(':id',$_GET['id']);
        $reqDelBien->execute();

        header('Location:gestionBiens?delete=done');
    }

    if($_GET['action']=="modify")
    {
     $sqlAffbien='SELECT *
                    FROM bien
                    INNER JOIN adresse ON adresse_idadresse=idadresse
                    WHERE idbien=:idbien';
        $reqAffbien=$db->prepare($sqlAffbien);
        $reqAffbien->bindParam(':idbien',$_GET['id']);
        $reqAffbien->execute();
        $affbien=array();
        while($data=$reqAffbien->fetchObject())
        {
            array_push($affbien,$data);
        }

        ?>


            <div class="row">
                <h2 class="mx-auto mt-3"> Modification</h2>
            </div>
            <div class="mx-3">
                <form method="post" action="modify" class="mx-auto mt-5" enctype="multipart/form-data">
                    <?php
                    foreach ($affbien as $bien)
                    {
                    ?><div class="container">
                        <div class="row justify-content-between">

                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                <div class="d-none">
                                    <input type="number" name="id" value="<?= $bien->idbien ?>"/>
                                </div>

                                <div class="d-flex justify-content-between row">
                                    <div class="form-group">
                                        <label for="titre"> Titre de l'annonce :</label>
                                        <input type="text" name="titre" value="<?= $bien->titreBien ?>" id="titre" class="form-control" required="required">
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
                                        <textarea maxlength="255" name="resume"id="resume" class="form-control" required="required"><?= $bien->resumeBien ?></textarea>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between row">
                                    <div class="form-group">
                                        <label for="superficie">Superficie :</label>
                                        <input type="number" name="superficie" value="<?= $bien->superficieBien ?>" id="superficie" class="form-control" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="nbpiece">Nombre de pièces :</label>
                                        <input type="number" name="nbpiece"  value="<?= $bien->nbpieceBien ?>" id="nbpiece" class="form-control" required="required">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="prix">Prix :</label>
                                        <input type="number" name="prix" value="<?= $bien->prixBien ?>" id="prix" class="form-control" required="required">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mx-3">
                                <div class="form-group row">
                                    <label for="adresse">Adresse</label>
                                    <input type="text" class="form-control" id="adresse" value="<?= $bien->adresse1 ?>" name="adresse1" required="required">
                                </div>
                                <div class="form-group row">
                                    <label for="inputAddress2">Complément d'adresse</label>
                                    <input type="text" class="form-control"  value="<?= $bien->adresse2 ?>" id="inputAddress2" name="adresse2">
                                </div>

                                <div class="row form-group">
                                    <div class="form-group">
                                        <label for="inputCity">Ville</label>
                                        <input type="text" class="form-control" value="<?= $bien->ville ?>" id="inputCity" name="ville" required="required">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between row">
                                    <div class="form-group">
                                        <label for="inputZip">Code Postal</label>
                                        <input type="number" class="form-control" id="inputZip" name="codePost" value="<?= $bien->codepostal ?>" required="required">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputState">Pays</label>
                                        <input type="text" class="form-control" id="inputState" name="pays" value="<?= $bien->pays ?>" required="required">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="description">Description complète :</label>
                                    <textarea class="form-control" name="description" id="description" required="required"><?= $bien->descBien ?></textarea>
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
                </form>
            <?php } ?>
             </div>
        </div>

    <?php }
}
if ($_GET['action']=='read') {
    $sqlSel1 = 'SELECT *
                    FROM bien
                    INNER JOIN adresse ON adresse_idadresse=idadresse
                    WHERE idbien=:id';
    $reqSel1 = $db->prepare($sqlSel1);
    $reqSel1->bindParam(':id', $_GET['id']);
    $reqSel1->execute();
    $selBien = array();
    while ($data = $reqSel1->fetchObject()) {
        array_push($selBien, $data);
    }
    ?>


    <?php foreach ($selBien as $bien) {
        if($bien->typeAnnonce == "Achat")
        {
            $prefix_prix=' € net vendeur';
        }else
        {
            $prefix_prix=' € / mois';
        }
        if (isset($_GET['indice']))
        {
            $ind=$_GET['indice'];
        }
        else
        {
            $ind=0;
        }
        ?>

        <div class="col-lg-6 col-md-6 mx-auto">
            <h1 class="flex-block text-center"><?= $bien->titreBien ?></h1>
            <div>
                <img class="img-thumbnail" src="<?php __DIR__; ?>public/img/<?= $bien->imageBien ?>">
            </div>
            <div class="mt-1">
                <span class="font-weight-bold"><?= $bien->ville ?></span>
                <p class="mt-4">
                    <span class="bg-warning p-2 rounded"><?= $bien->typeBien ?></span>
                    <span class="bg-info p-2 rounded font-weight-bold"><?= $bien->typeAnnonce ?></span>
                    <span class="bg-success p-2 rounded text-light font-weight-bold">Prix : <?= $bien->prixBien ?><?= $prefix_prix ?></span>
                </p>
            </div>
            <div>
                <span class="pr-5">Superficie : <?= $bien->superficieBien ?> m²</span>
                <span> Nombre de pièces : <?= $bien->nbpieceBien ?></span>
            </div>
            <p class="my-3"><?= $bien->descBien ?></p>
            <div class="mt-2 d-flex justify-content-between">

                <a class="btn btn-dark" href="<?php if($_GET['page'] ==="location")
                                                {
                                                    echo $router->generate('annonces').'?indice='.$_GET['indice'];
                                                }elseif ($_GET['page']==='gererMesBiens'){
                                                    echo $router->generate('gestionBiens');
                                                }
                                                ?>">Retour</a>
            </div>
        </div>
        </div>
        <?php
    }
}
?>

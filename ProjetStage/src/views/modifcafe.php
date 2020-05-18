<?php
require_once 'src/config/config.php';
require_once 'src/models/connect.php';


$db=connect();

if(!isset($_SESSION['role']) && $_SESSION['role']!=='admin')
{
    header('Location:accueil');
}

    $sqlSelCaf='SELECT * FROM cafe
                INNER JOIN pays ON pays_idpays=idpays
                WHERE idcafe=:id';
    $reqSelCaf=$db->prepare($sqlSelCaf);
    $reqSelCaf->bindParam(':id',$_GET['id']);
    $reqSelCaf->execute();
    $tab_caf=array();
    while ($data=$reqSelCaf->fetchObject())
    {
        array_push($tab_caf,$data);
    }

if (isset($_POST["nomCafe"]) && isset($_POST["paysCafe"]) && isset($_POST["type"]) && isset($_POST["prix"]) &&
isset($_POST["resume"]) && isset($_POST["description"]))
{

    $nomcafe=htmlspecialchars(trim($_POST["nomCafe"]));
    $payscafe=htmlspecialchars(trim($_POST["paysCafe"]));
    $resume=htmlspecialchars(trim($_POST["resume"]));
    $description=htmlspecialchars(trim($_POST["description"]));

    $sqlSelPays='SELECT idpays FROM pays
                 WHERE nomPays=:pays';
    $reqSelPays=$db->prepare($sqlSelPays);
    $reqSelPays->bindParam(':pays',$payscafe);
    $reqSelPays->execute();
    $tab_pays=array();
    while($data=$reqSelPays->fetchObject())
    {
        array_push($tab_pays,$data);
    }
    if(!empty($tab_pays))
    {
        $idpays=intval($tab_pays[0]->idpays);
    }
    else {
        $sqlInsPays = 'INSERT INTO pays (nomPays) VALUES (:pays)';
        $reqInsPays = $db->prepare($sqlInsPays);
        $reqInsPays->bindParam(':pays', $payscafe);
        $reqInsPays->execute();
        $idpays = intval($db->lastInsertId());
    }

        $sqlUp = 'UPDATE cafe SET
            stockCafe=:stock,
            fournisseur_idfournisseur=:fourn,
            nomCafe=:nom,
            typeCafe=:type_c,
            decafCafe=:deca,
            bioCafe=:bio,
            prixCafe=:prix,
            resumeCafe=:resume,
            descCafe=:descr,
            photoCafe=:photo,
            date_modifCafe= NOW(),
            selectCafe=:select_c,
            pays_idpays=:id_p
            WHERE idcafe=:id_c';
        $reqUp=$db->prepare($sqlUp);
        $reqUp->bindParam(':stock', $_POST['stock']);
        $reqUp->bindParam(':fourn', $_POST['fournisseur']);
        $reqUp->bindParam(':nom', $nomcafe);
        $reqUp->bindParam(':type_c', $_POST["type"]);
        $reqUp->bindParam(':deca', $_POST["deca"]);
        $reqUp->bindParam(':bio', $_POST["bio"]);
        $reqUp->bindParam(':prix', $_POST["prix"]);
        $reqUp->bindParam(':resume', $resume);
        $reqUp->bindParam(':descr', $description);
        $reqUp->bindParam(':photo', $_FILES["image"]["name"]);
        $reqUp->bindParam('select_c', $_POST["select"]);
        $reqUp->bindParam(':id_p', $idpays);
        $reqUp->bindParam(':id_c', $_POST["id_c"]);
        $reqUp->execute();
        if($_POST['page']==="plusvendus") {
            header('Location:lesplusvendus?modify=done');
        }
        else
        {
            header('Location:'.$_POST["page"].'?modify=done');
        }
}
$sqlSelFourn='SELECT * FROM fournisseur';
$reqSelFourn=$db->prepare($sqlSelFourn);
$reqSelFourn->execute();
$tab_fourn=array();
while($data=$reqSelFourn->fetchObject())
{
    array_push($tab_fourn,$data);
}

function selec($value,$tri)
{
    if ($value == $tri)
    {
        echo'selected="selected"';
    }
}
?>
<div class="container">
    <div class="arr_plan justify-content-center">
        <h1 class="text-center titre">Admin: Modification Café</h1>
        <form method="post" action="modification" enctype="multipart/form-data">
            <div class="row justify-content-between">
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <?php foreach ($tab_caf as $cafe)
                        { ?>
                    <input type="text" value="<?= $_GET["page"] ?>" name="page" class="d-none"/>
                    <input type="number" value="<?= $cafe->idcafe ?>" class="d-none" name="id_c"/>
                    <div >
                        <label for="nomCafe" class="col-form-label">Nom du Café :</label>
                        <input type="text" name="nomCafe" id="nomCafe" value="<?= $cafe->nomCafe ?>" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="paysCafe" class="col-form-label">Provenance :</label>
                        <input type="text" name="paysCafe" id="paysCafe" value="<?= $cafe->nomPays ?>" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="type" class="labelcafe col-form-label">Type :</label>
                        <select name="type" id="type" class="form-control w-50">
                            <option value="En grain"<?php selec('En grain',$cafe->typeCafe) ?>>En grain</option>
                            <option value="Moulu"<?php selec('Moulu',$cafe->typeCafe) ?>>Moulu</option>
                        </select>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <div class="form-check form-check-inline">
                            <label for="decafeine" class="mr-3 col-form-label">Décaféiné :</label>
                            <input type="checkbox" value="1" id="decafeine" name="deca" <?php if ($cafe->decafCafe ==="1"){echo'checked="checked"';} ?>>
                        </div>
                        <div class="form-check form-check-inline">
                            <label for="bio" class="mr-3 col-form-label">Bio :</label>
                            <input type="checkbox" value="1" id="bio" name="bio"<?php if ($cafe->bioCafe === "1"){echo'checked="checked"';} ?>>
                        </div>
                        <div class="form-check form-check-inline">
                            <label for="select" class="mr-3 col-form-label">Sélectionné :</label>
                            <input type="checkbox" name="select" value="1" id="select" <?php if ($cafe->selectCafe === "1"){echo'checked="checked"';} ?>>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="fournisseur">Fournissseur :</label>
                        <select name="fournisseur" id="fournisseur" class="form-control w-75">
                            <?php foreach ($tab_fourn as $fourn)
                            { ?>
                                <option value="<?= $fourn->idfournisseur ?>"<?php selec($fourn->idfournisseur,$cafe->fournisseur_idfournisseur) ?>><?= $fourn->societeFournisseur ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </div>
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div class="d-flex justify-content-between">
                        <div class="mt-3">
                            <label for="prix" class="labelcafe">Prix :</label>
                            <input type="text" name="prix" value="<?= $cafe->prixCafe ?>" id="prix" class="form-control w-50" required="required">
                        </div>
                        <div class="mt-3">
                            <label for="stock" class="labelcafe">Stock :</label>
                            <input type="text" name="stock" value="<?= $cafe->stockCafe ?>" id="stock" class="form-control w-50" required="required">
                        </div>
                    </div>
                    <div>
                        <label for="resume" class="col-form-label">Résumé :</label>
                        <input type="text" name="resume" value="<?=$cafe->resumeCafe ?>" id="resume" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="description" class="col-form-label">Description :</label>
                        <textarea name="description" id="description" class="form-control" required="required"><?= $cafe->descCafe ?></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="image" class="col-form-label">Photos :</label>
                        <input type="file" name="image" id="image" class="w-100"/>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-marron" id="modif_cafe">Ajouter</button>
                    </div>
                </div>
                            <?php } ?>
            </div>
        </form>
        <div class="text-center">
            <img src="public/img/cafe-vrac.png" class="w-25"/>
        </div>
    </div>
</div>


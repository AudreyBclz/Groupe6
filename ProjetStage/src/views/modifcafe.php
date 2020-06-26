<?php

use App\Models\cafe;
use App\Models\pays;
require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/notconnect.php';

notco();
$db=connect();

if($_SESSION['role']!=='admin')
{
    header('Location:accueil');
}
else {
    $cafe = new cafe($db);
    if (isset($_GET['id']))
    {
        $tab_caf = $cafe->aff_un_cafe()[1];
    }

if (isset($_POST["nomCafe"]) && isset($_POST["paysCafe"]) && isset($_POST["type"]) && isset($_POST["prix"]) &&
isset($_POST["resume"]) && isset($_POST["description"]))
{
    $cafe->setNomCafe($_POST['nomCafe']);
    $cafe->setTypeCafe($_POST['type']);
    $cafe->setPrixCafe($_POST['prix']);
    $cafe->setResumeCafe($_POST['resume']);
    $cafe->setDescCafe($_POST['description']);
    $cafe->setStockCafe($_POST['stock']);
    $cafe->setFournisseurIdfournisseur($_POST['fournisseur']);
    $cafe->setSelectCafe($_POST['select']);
    $cafe->setDecafCafe($_POST['deca']);
    $cafe->setBioCafe($_POST['bio']);
    $cafe->setPhotoCafe($_FILES['image']['name']);


    $pays=new pays($db);
    $pays->setNomPays($_POST['paysCafe']);
    $idpays=$pays->select_champ($pays->getChamps(),$pays->getNomPays())[0]->idpays;
    if(empty($idpays))
    {
        $idpays=$pays->insert_pays();
    }
    $cafe->setPaysIdpays($idpays);

    $cafe->update_cafe();


    move_uploaded_file($_FILES['image']['tmp_name'],'public/img/'.basename($_FILES['image']['name']));

    //on fait une redirection sur la page précédente
    if($_POST['page']==="plusvendus") {
        header('Location:lesplusvendus?modify=done');
    }
    else
    {
        header('Location:'.$_POST["page"].'?modify=done');
    }
}
$fournisseur=new \App\models\Fournisseur($db);
$tab_fourn=$fournisseur->select_fournisseur();

//fonction pour sélectionner le bon fournisseur et le bon type
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
                        <textarea name="description" id="description" class="form-control" required="required"><?= /* str_replace sert à enlver les br superflue pour garder la même mise en forme */str_replace('<br />',"",$cafe->descCafe) ?></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="image" class="col-form-label">Photos :</label>
                        <input type="file" name="image" id="image" class="w-100"/>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-marron" id="modif_cafe">Modifier</button>
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
<?php } ?>

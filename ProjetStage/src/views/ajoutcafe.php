<?php
use App\Models\cafe;
use App\Models\pays;
use App\Models\Fournisseur;

require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/notconnect.php';

notco();
$db=connect();
$fourni=new Fournisseur($db);
if($_SESSION['role']!=="admin")
{
    header('Location:accueil');
}
elseif (isset($_POST["nomCafe"]))
{

    $cafe = new cafe($db);
    $cafe->setNomCafe($_POST['nomCafe']);
    $cafe->setTypeCafe($_POST['type']);
    $cafe->setDecafCafe($_POST['deca']);
    $cafe->setBioCafe($_POST['bio']);
    $cafe->setPrixCafe($_POST['prix']);
    $cafe->setResumeCafe($_POST['resume']);
    $cafe->setDescCafe($_POST['description']);
    $cafe->setPhotoCafe($_FILES['picture']['name']);
    $cafe->setDateCreaCafe(NULL);
    $cafe->setDateModifCafe(NULL);
    $cafe->setSelectCafe($_POST['select']);
    $cafe->setNbventeCafe(0);
    $cafe->setStockCafe($_POST['stock']);
    $cafe->setFournisseurIdfournisseur($_POST['fournisseur']);

    $pays= new pays($db);
    $pays->setNomPays($_POST['paysCafe']);

    if($cafe->exist())
    {
        echo'<div class="alert-warning p-2 text-center">Ce café existe déjà!</div>';
    }
    else
    {
        $idpays= $pays->select_champ($pays->getChamps(),$pays->getNomPays())[0]->idpays;
        if (empty($idpays))
        {
            $idpays=$pays->insert_pays();
        }
        $cafe->setPaysIdpays($idpays);
        $cafe->insert();

        move_uploaded_file($_FILES['picture']['tmp_name'],'public/img/'.basename($_FILES['picture']['name']));
        echo '<div class="alert-success p-2 text-center">Le café a bien été ajouté</div>';
    }
}
$tab_fourn=$fourni->select_fournisseur();
?>
<div class="container">
    <div class="arr_plan justify-content-center">
        <h1 class="text-center titre">Admin: Ajout Café</h1>
        <form method="post" action="ajoutCafe" enctype="multipart/form-data">
            <div class="row justify-content-between">
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div >
                        <label for="nomCafe" class="col-form-label">Nom du Café :</label>
                        <input type="text" name="nomCafe" id="nomCafe" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="paysCafe" class="col-form-label">Provenance :</label>
                        <input type="text" name="paysCafe" id="paysCafe" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="type" class="labelcafe col-form-label">Type :</label>
                        <select name="type" id="type" class="form-control w-50">
                            <option value="En grain">En grain</option>
                            <option value="Moulu">Moulu</option>
                        </select>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <div class="form-check form-check-inline">
                            <label for="decaffeine" class="mr-3 col-form-label">Décafféiné :</label>
                            <input type="checkbox" name="deca" value="1" id="decaffeine">
                        </div>
                        <div class="form-check form-check-inline">
                            <label for="bio" class="mr-3 col-form-label">Bio :</label>
                            <input type="checkbox"name="bio" value=1 id="bio">
                        </div>
                        <div class="form-check form-check-inline">
                            <label for="select" class="mr-3 col-form-label">Sélectionné :</label>
                            <input type="checkbox" name="select" value="1" id="select">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="fournisseur">Fournissseur :</label>
                        <select name="fournisseur" id="fournisseur" class="form-control w-75">
                            <?php foreach ($tab_fourn as $fourn)
                            { ?>
                                <option value="<?= $fourn->idfournisseur ?>"><?= $fourn->societeFournisseur ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div>
                        <label for="resume" class="col-form-label">Résumé :</label>
                        <input type="text" name="resume" id="resume" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="description" class="col-form-label">Description :</label>
                        <textarea name="description" id="description" class="form-control" required="required"></textarea>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <div>
                            <label for="prix" class="labelcafe">Prix * :</label>
                            <input type="text" name="prix" id="prix" class="form-control w-50" required="required">
                        </div>
                        <div>
                            <label for="stock" class="labelcafe">Stock :</label>
                            <input type="number" name="stock" id="stock" class="form-control w-50" required="required">
                        </div>
                    </div>
                    <small class="font-italic">* décimal séparé par un point</small>
                    <div class="mt-3">
                        <label for="image" class="col-form-label">Photos :</label>
                        <input type="file" name="picture" id="image" class="w-100"/>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-marron" id="ajout_cafe">Ajouter</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="text-center">
            <img src="public/img/cafe-vrac.png" class="w-25"/>
        </div>
    </div>
</div>


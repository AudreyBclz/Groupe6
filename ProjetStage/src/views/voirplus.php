<?php

use App\models\cafe;
use App\Models\Panier;
use App\Models\User;
require_once 'src/config/config.php';
require_once 'src/config/connect.php';


$db=connect();

$cafe=new cafe($db);
$panier=new Panier($db);
$user=new User($db);

$suffixe=$cafe->aff_un_cafe()[0];
$tab_cafe=$cafe->aff_un_cafe()[1];

if(isset($_GET['id']) && isset($_GET['quantite']))
{
    if($panier->update_panier_page_voir($tab_cafe)===false)
    {
        $idAd=($user->select_champ($user->getChamps(),$_SESSION['iduser']))[0]->adresse_idadresse;
        $panier->insert_panier($idAd);
        echo '<div class="alert-info p-2 text-center">Article(s) ajouté(s) à votre panier</div>';
    }
}
if (isset($_GET['id']))
{
    $name=md5('voirplus'.$_GET['id'].'.txt');
    $filename='cache/'.$name;
    if (file_exists($filename))
    {
        echo file_get_contents($filename);
    }
    else
    {
        ob_start();


        ?>

        <div class="container">
            <div class="arr_plan row justify-content-center">
                <h1 class="text-center titre"><?= $tab_cafe[0]->nomCafe ?></h1>

                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mb-3">
                        <?php if($tab_cafe[0]->stockCafe==0){echo'<img class="panneau w-100 bg-light rounded" src="public/img/epuise.png">' ;}else{ ?><img src="public/img/<?= $tab_cafe[0]->photoCafe ?>" class="panneau w-100 bg-light rounded" alt="..."><?php ;} ?>
                        <div class="d-flex justify-content-between mt-3">
                            <p><span>Pays:</span><span
                                        class="p-2 m-1 rounded bg-wheat font-weight-bold"><?= $tab_cafe[0]->nomPays ?></span>
                            </p>
                            <p><span>Type :</span><span
                                        class="p-2 m-1 rounded bg-light font-weight-bold"><?= $tab_cafe[0]->typeCafe ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between mb-3 ">
                                <?php if($tab_cafe[0]->decafCafe=="1" || $tab_cafe[0]->bioCafe=="1")
                                { ?>
                                    <img src="public/img/deca.png" class="w-25 <?php if ($tab_cafe[0]->decafCafe !== "1") {
                                        echo 'invisible';
                                    } ?>">
                                    <img src="public/img/bio.png" class="w-50 <?php if ($tab_cafe[0]->bioCafe !== "1") {
                                        echo 'invisible';
                                    } ?>"> <?php } ?>
                            </div>
                            <div class="bg-marron2 p-3 rounded">
                                <p class="card-text"><?= $tab_cafe[0]->descCafe ?></p>
                                <p class="card-text">Quantité restante :<span class="font-weight-bold"> <?=$tab_cafe[0]->stockCafe ?></span></p>
                            </div>
                            <div class="card-footer rounded mb-3">
                                <p>Prix:<span class="font-weight-bold p-2"><?= $tab_cafe[0]->prixCafe ?>€</span><?= $suffixe ?>
                                <p>
                            </div>
                            <?php
                            $content = ob_get_contents();
                            file_put_contents($filename, $content);
                            } ?>
                            <form method="get" action="detail" class="d-flex justify-content-end">
                                <div class="d-flex">
                                    <label for="quantite" class="mr-2 col-form-label  <?php if(!isset($_SESSION['iduser']) || $tab_cafe[0]->stockCafe==0){echo'd-none';} ?>">Qté:</label>
                                    <input type="number" name="quantite" id="quantite" class=" form-control w-25  <?php if(!isset($_SESSION['iduser'])|| $tab_cafe[0]->stockCafe==0){echo'd-none';} ?>">
                                    <input type="number" name="id" value="<?= $tab_cafe[0]->idcafe ?>" class="d-none"/>
                                </div>
                                <button type="submit" class="btn btn-marron  <?php if(!isset($_SESSION['iduser'])|| $tab_cafe[0]->stockCafe==0){echo'd-none';} ?>">Ajouter au panier</button>
                            </form>
                            <?php if(!isset($_SESSION['iduser'])){echo '<p> Vous devez être connecté pour ajouter des articles dans le panier.</p>';} ?>
                        </div>
                        <div class="mb-2">
                            <a href="javascript:history.go(-1)"><span class="btn btn-outline-success">Retour</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>


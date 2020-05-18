<?php

require_once 'src/config/config.php';
require_once 'src/models/connect.php';


$db=connect();

$sqlSelCaf='SELECT * FROM cafe
            INNER JOIN pays ON pays_idpays=idpays
            WHERE idcafe=:id';
$reqSelCaf=$db->prepare($sqlSelCaf);
$reqSelCaf->bindParam(':id',$_GET['id']);
$reqSelCaf->execute();
$tab_cafe=array();
while($data=$reqSelCaf->fetchObject())
{
    array_push($tab_cafe,$data);
}
if($tab_cafe[0]->typeCafe==='En grain')
{
    $suffixe=' le sachet d\'1 kg';
}
else
{
    $suffixe=' le paquet de 250g';
}
if(isset($_GET['id']) && isset($_GET['quantite']))
{
    if($tab_cafe[0]->stockCafe < $_GET['quantite'])
    {
        echo'<div class="alert-warning p-2 text-center">Quantité supérieur au stock du produit</div>';
    }
    elseif(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['iduser']) && isset($_SESSION['role'])) {
        $sqlSelPanier = 'SELECT * FROM panier
                        INNER JOIN cafe ON cafe_idcafe=idcafe
                        WHERE  users_idUsers=:id
                        AND cafe_idcafe=:id_c';
        $reqSelPanier = $db->prepare($sqlSelPanier);
        $reqSelPanier->bindParam('id', $_SESSION['iduser']);
        $reqSelPanier->bindParam(':id_c', $_GET['id']);
        $reqSelPanier->execute();
        $tab_panier = array();
        while ($data = $reqSelPanier->fetchObject()) {
            array_push($tab_panier, $data);
        }
        if (!empty($tab_panier)) {
            $qte = intval($tab_panier[0]->quantite);
            $stock=intval($tab_panier[0]->stockCafe);
            if(($qte+$_GET['quantite']>$stock))
            {
                echo'<div class="alert-warning p-2 text-center">Vous ne pouvez pas acheter autant de cet article</div>';
            }
            else
            {
            $sqlUpPan = 'UPDATE panier
                        SET quantite=:quant
                        WHERE users_idUsers=:id
                        AND cafe_idcafe=:id_c';
            $reqUpPan = $db->prepare($sqlUpPan);
            $quantite = $qte + $_GET['quantite'];
            $reqUpPan->bindParam(':quant', $quantite);
            $reqUpPan->bindParam(':id', $_SESSION['iduser']);
            $reqUpPan->bindParam(':id_c', $_GET['id']);
            $reqUpPan->execute();
            echo '<div class="alert-info p-2 text-center">Articles ajouté à votre panier</div>';
        } }
        else {
            $sqlSelAd = 'SELECT adresse_idadresse FROM users
                        WHERE idUsers=:id';
            $reqSelAd = $db->prepare($sqlSelAd);
            $reqSelAd->bindParam(':id', $_SESSION['iduser']);
            $reqSelAd->execute();
            $tab_Ad = array();
            while ($data = $reqSelAd->fetchObject()) {
                array_push($tab_Ad, $data);
            }
            $idAd = intval($tab_Ad[0]->adresse_idadresse);
           
            $sqlInsPan = 'INSERT INTO panier (users_idUsers,cafe_idcafe,quantite,adresse_idadresse)
                        VALUES (:id_u,:id_c,:qte,:ad)';
            $reqInsPan = $db->prepare($sqlInsPan);
            $reqInsPan->bindParam('id_u', $_SESSION['iduser']);
            $reqInsPan->bindParam('id_c', $_GET['id']);
            $reqInsPan->bindParam(':qte', $_GET['quantite']);
            $reqInsPan->bindParam(':ad', $idAd);
            $reqInsPan->execute();
            echo '<div class="alert-info p-2 text-center">Article(s) ajouté(s) à votre panier</div>';

        }
    }else
    {
        echo'<div class="alert-warning p-2 text-center">Vous devez vous connecter pour ajouter dans votre panier <a href="connexion.php" class="btn btn-marron">Connexion</a></div>';
    }
}

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
                                <img src="public/img/deca.png" class="w-25 <?php if ($tab_cafe[0]->decafCafe !== "1") {
                                    echo 'invisible';
                                } ?>">
                                <img src="public/img/bio.png" class="w-50 <?php if ($tab_cafe[0]->bioCafe !== "1") {
                                    echo 'invisible';
                                } ?>">
                            </div>
                            <div class="bg-marron2 p-3 rounded">
                                <p class="card-text"><?= $tab_cafe[0]->descCafe ?></p>
                                <p class="card-text">Quantité restante :<span class="font-weight-bold"> <?=$tab_cafe[0]->stockCafe ?></span></p>
                            </div>
                            <div class="card-footer rounded mb-3">
                                <p>Prix:<span class="font-weight-bold p-2"><?= $tab_cafe[0]->prixCafe ?>€</span><?= $suffixe ?>
                                <p>
                            </div>
                            <form method="get" action="detail" class="d-flex justify-content-end">
                                <div class="d-flex">
                                    <label for="quantite" class="mr-2 col-form-label  <?php if(!isset($_SESSION['iduser']) || $tab_cafe[0]->stockCafe==0){echo'd-none';} ?>">Qté:</label>
                                    <input type="number" name="quantite" id="quantite" class=" form-control w-25  <?php if(!isset($_SESSION['iduser'])|| $tab_cafe[0]->stockCafe==0){echo'd-none';} ?>">
                                    <input type="number" name="id" value="<?= $tab_cafe[0]->idcafe ?>" class="d-none"/>
                                </div>
                                <button type="submit" class="btn btn-marron  <?php if(!isset($_SESSION['iduser'])|| $tab_cafe[0]->stockCafe==0){echo'd-none';} ?>">Ajouter au panier</button>
                            </form>
                            <?php if(!isset($_SESSION['iduser'])){echo '<p> Vous devez être connecté pour ajouter des articles dans le panier</p>';} ?>
                        </div>
                        <div class="mb-2">
                            <a href="javascript:history.go(-1)"><span class="btn btn-outline-success">Retour</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

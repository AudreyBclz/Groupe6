<?php

require_once 'src/config/config.php';
require_once 'src/models/connect.php';
require_once 'src/models/notconnect.php';

$db=connect();

notco();

if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['adresse']) && isset($_POST['codePost']) && isset($_POST['ville'])) {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $complement = htmlspecialchars(trim($_POST['complement']));
    $ville = htmlspecialchars(trim($_POST['ville']));
    $sqlSelAd = 'SELECT idadresse FROM adresse
                WHERE adresse1=:ad
                AND adressePrenom=:prenom
                AND adresseNom=:nom
                AND adresse2=:ad2
                AND adresseCP=:cp
                AND adresseVille=:ville';
    $reqSelAd = $db->prepare($sqlSelAd);
    $reqSelAd->bindParam(':prenom', $prenom);
    $reqSelAd->bindParam(':nom', $nom);
    $reqSelAd->bindParam(':ad', $adresse);
    $reqSelAd->bindParam(':ad2', $complement);
    $reqSelAd->bindParam(':cp', $_POST['codePost']);
    $reqSelAd->bindParam(':ville', $ville);
    $reqSelAd->execute();
    $tab_ad = array();
    while ($data = $reqSelAd->fetchObject()) {
        array_push($tab_ad, $data);
    }
    if (!empty($tab_ad)) {
        $idAd = intval($tab_ad[0]->idadresse);
    } else {
        $sqlInsAd = 'INSERT INTO adresse (adressePrenom, adresseNom,adresse1,adresse2,adresseCP,adresseVille)
                    VALUES (:prenom,:nom,:ad1,:ad2,:cp,:ville)';
        $reqInsAd = $db->prepare($sqlInsAd);
        $reqInsAd->bindParam(':nom', $nom);
        $reqInsAd->bindParam(':prenom', $prenom);
        $reqInsAd->bindParam(':ad1', $adresse);
        $reqInsAd->bindParam(':ad2', $complement);
        $reqInsAd->bindParam(':cp', $_POST['codePost']);
        $reqInsAd->bindParam(':ville', $ville);
        $reqInsAd->execute();
        $idAd = intval($db->lastInsertId());
    }
    $sqlUpAdPan = 'UPDATE panier SET
                 adresse_idadresse =:id_ad
                 WHERE users_idUsers=:idU';
    $reqUpAdPan = $db->prepare($sqlUpAdPan);
    $reqUpAdPan->bindParam(':id_ad', $idAd);
    $reqUpAdPan->bindParam(':idU', $_SESSION['iduser']);
    $reqUpAdPan->execute();
}
    $sqlAdFacture = 'SELECT * FROM users
                    INNER JOIN adresse ON adresse_idadresse=idadresse
                   WHERE idUsers=:id';
    $reqAdFacture = $db->prepare($sqlAdFacture);
    $reqAdFacture->bindParam(':id', $_SESSION['iduser']);
    $reqAdFacture->execute();
    $tab_ad_fact = array();
    while ($data = $reqAdFacture->fetchObject()) {
        array_push($tab_ad_fact, $data);
    }
    $idFac = intval($tab_ad_fact[0]->adresse_idadresse);

    if (isset($_POST['same']))
{
    $sqlUpAd='UPDATE panier SET
                 adresse_idadresse =:id_ad
                 WHERE users_idUsers=:idU';
    $reqUpAd=$db->prepare($sqlUpAd);
    $reqUpAd->bindParam(':id_ad',$idFac);
    $reqUpAd->bindParam(':idU',$_SESSION['iduser']);
    $reqUpAd->execute();
}
$sqlSelPan = 'SELECT * FROM panier
                            INNER JOIN cafe ON cafe_idcafe=idcafe
                            INNER JOIN adresse ON adresse_idadresse=idadresse
                            INNER JOIN users on users_idUsers=idUsers
                            WHERE users_idUsers =:id';
$reqSelPan = $db->prepare($sqlSelPan);
$reqSelPan->bindParam(':id', $_SESSION['iduser']);
$reqSelPan->execute();
$tab_pan = array();
$pxtotal = 0;
$i = 0;
while ($data = $reqSelPan->fetchObject()) {
    array_push($tab_pan, $data);
}

?>
<div class="container arr_plan mx-auto">
    <h1 class="text-center titre">Récapitulatif de la commande</h1>
    <div class=" row justify-content-center">
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 d-flex flex-column">

            <table class="table">
                <thead class= "bg-marron">
                <tr class="text-light">
                    <th scope="col">Nom du produit</th>
                    <th scope="col" class="w-30">Quantité</th>
                    <th scope="col">Prix</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tab_pan as $panier)
                    {
                        $total = $panier->prixCafe * $panier->quantite;
                        $pxtotal = $pxtotal + $total;
                        $i = $i + 1;
                    ?>
                <tr class="bg-wheat">
                    <td scope="col"><?=$panier->nomCafe ?></td>
                    <td scope="col"><?= $panier->quantite ?></td>
                    <td scope="col"><?= $total ?>€</td>
                </tr>
                <?php } ?>
                <tr class="bg-wheat">
                    <th scope="col">Total :</th>
                    <th scope="col"></th>
                    <th scope="col"><?= $pxtotal ?>€</th>
                </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 d-flex justify-content-between">
            <div>
                <span class="font-weight-bold">Adresse de Facturation :</span><br/>
                <?= $tab_ad_fact[0]->prenomUsers ?> <?=$tab_ad_fact[0]->nomUsers ?><br/>
               <?= $tab_ad_fact[0]->adresse1 ?><br/>
                 <?php if (strlen($tab_ad_fact[0]->adresse2)!==0) {
    echo $tab_pan[0]->adresse2 . '<br/>';}
    echo $tab_ad_fact[0]->adresseCP . ' ' . $tab_ad_fact[0]->adresseVille; ?>
    </div>
    <div>
        <span class="font-weight-bold">Adresse de Livraison:</span><br/>
        <?php if (isset($tab_pan[0]->adressePrenom))
                {
                    echo $tab_pan[0]->adressePrenom.' ';
                }else {
                echo $tab_ad_fact[0]->prenomUsers.' ';}
                if (isset($tab_pan[0]->adresseNom))
                {
                   echo $tab_pan[0]->adresseNom;
                }
                else
                {
                    echo $tab_ad_fact[0]->nomUsers;
                }?><br/>
        <?= $tab_pan[0]->adresse1 ?><br/>
        <?php if (strlen($tab_pan[0]->adresse2) !== 0) {
            echo $tab_pan[0]->adresse2 . '<br/>';
        }
        echo $tab_pan[0]->adresseCP . ' ' . $tab_pan[0]->adresseVille; ?>
    </div>
    </div>
    </div>
    <div class="row">
        <div class="col-xl-5=7 col-lg-7 col-md-12 col-sm-12 d-flex justify-content-between">
            <a href="paiement" class="btn btn-marron">Confirmer</a>
            <a href="selection" class="btn btn-marron">Annuler</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <img src="public/img/ter_paiement.png" class="w-50">
    </div>

    </div>

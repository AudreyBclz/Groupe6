<?php
use App\Models\Adresse;
use App\Models\pays;
use App\Models\Panier;
require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/notconnect.php';

$db=connect();

notco();

// on vérifie si l'utilisateur vient de la page précédente
if(!isset($_POST['add_adresse']))
{
    header('Location:accueil');
}

$pays=new pays($db);
$adresse=new Adresse($db);
$panier=new Panier($db);
if (isset($_POST['nom'])) {

    if ($_POST['pays']!=='') {
        $pays->setNomPays($_POST['pays']);

        $adresse->setAdresseNom($_POST['nom']);
        $adresse->setAdressePrenom($_POST['prenom']);
        $adresse->setAdresse1($_POST['adresse']);
        $adresse->setAdresse2($_POST['complement']);
        $adresse->setAdresseCP($_POST['codePost']);
        $adresse->setAdresseVille($_POST['ville']);
        /*$pays=htmlspecialchars(trim($_POST['pays']));
        $nom = htmlspecialchars(trim($_POST['nom']));
        $prenom = htmlspecialchars(trim($_POST['prenom']));
        $adresse = htmlspecialchars(trim($_POST['adresse']));
        $complement = htmlspecialchars(trim($_POST['complement']));
        $ville = htmlspecialchars(trim($_POST['ville']));*/

        $idAd = $adresse->check_adresse($pays, 1);
        var_dump($idAd);

        if ($idAd === '') {
            var_dump($pays->getChamps(),$pays->getNomPays());
            $idPays = $pays->select_champ($pays->getChamps(), $pays->getNomPays())[0]->idpays;
            if (empty($idPays)) {
                $idPays = $pays->insert_pays();
            }
            $adresse->setPaysIdpays($idPays);
            $idAd = $adresse->insert_adresse(1);
        }

        /* //on vérifie si l'adresse rentrée est déjà en base de donnée si oui on récupère l'id
         $sqlSelAd = 'SELECT idadresse FROM adresse
                     INNER JOIN pays ON pays_idpays=idpays
                     WHERE adresse1=:ad
                     AND adressePrenom=:prenom
                     AND adresseNom=:nom
                     AND adresse2=:ad2
                     AND adresseCP=:cp
                     AND adresseVille=:ville
                     AND nomPays=:pays';
         $reqSelAd = $db->prepare($sqlSelAd);
         $reqSelAd->bindParam(':prenom', $prenom);
         $reqSelAd->bindParam(':nom', $nom);
         $reqSelAd->bindParam(':ad', $adresse);
         $reqSelAd->bindParam(':ad2', $complement);
         $reqSelAd->bindParam(':cp', $_POST['codePost']);
         $reqSelAd->bindParam(':ville', $ville);
         $reqSelAd->bindParam(':pays',$pays);
         $reqSelAd->execute();
         $tab_ad = array();
         while ($data = $reqSelAd->fetchObject()) {
             array_push($tab_ad, $data);
         }
         if (!empty($tab_ad)) {
             $idAd = intval($tab_ad[0]->idadresse);
         } else {
             //si non on vérifie si le pays existe en DB et si c'est le cas on récupère l'id
             $sqlSelPays='SELECT idpays FROM pays
                          WHERE nomPays=:pays';
             $reqSelPays=$db->prepare($sqlSelPays);
             $reqSelPays->bindParam(':pays',$pays);
             $reqSelPays->execute();
             $tab_pays=array();
             while($data=$reqSelPays->fetchObject())
             {
                 array_push($tab_pays,$data);
             }
             if(!empty($tab_pays))
             {
                 $idPays=intval($tab_pays[0]->idpays);
             }
             else
             {
                 //si le pays n'existe pas on l'insère et on récupère l'id
                 $sqlInsPays='INSERT INTO pays (nomPays) VALUES (:pays)';
                 $reqInsPays=$db->prepare($sqlInsPays);
                 $reqInsPays->bindParam(':pays',$pays);
                 $reqInsPays->execute();
                 $idPays=intval($db->lastInsertId());
             }
             //on insère l'adresse et on récupère l'id
             $sqlInsAd = 'INSERT INTO adresse (adressePrenom, adresseNom,adresse1,adresse2,adresseCP,adresseVille,pays_idpays)
                         VALUES (:prenom,:nom,:ad1,:ad2,:cp,:ville,:id_p)';
             $reqInsAd = $db->prepare($sqlInsAd);
             $reqInsAd->bindParam(':prenom', $prenom);
             $reqInsAd->bindParam(':nom', $nom);
             $reqInsAd->bindParam(':ad1', $adresse);
             $reqInsAd->bindParam(':ad2', $complement);
             $reqInsAd->bindParam(':cp', $_POST['codePost']);
             $reqInsAd->bindParam(':ville', $ville);
             $reqInsAd->bindParam(':id_p',$idPays);
             $reqInsAd->execute();
             $idAd = intval($db->lastInsertId());
         }*/
        // on update l'idadresse du panier

    }

    $tab_ad_fact = $adresse->aff_adresse();
    $idFac = $tab_ad_fact[0]->adresse_idadresse;
    $sqlUpAd = 'UPDATE panier SET
                 adresse_idadresse =:id_ad
                 WHERE users_idUsers=:idU';
    $reqUpAd = $db->prepare($sqlUpAd);
    $reqUpAd->bindParam(':id_ad', $idAd);
    $reqUpAd->bindParam(':idU', $_SESSION['iduser']);
    $reqUpAd->execute();
    /*//on récupère l'adresse de facturation pour l'afficher
        $sqlAdFacture = 'SELECT * FROM users
                        INNER JOIN adresse ON adresse_idadresse=idadresse
                        INNER JOIN pays ON pays_idpays=idpays
                       WHERE idUsers=:id';
        $reqAdFacture = $db->prepare($sqlAdFacture);
        $reqAdFacture->bindParam(':id', $_SESSION['iduser']);
        $reqAdFacture->execute();
        $tab_ad_fact = array();
        while ($data = $reqAdFacture->fetchObject()) {
            array_push($tab_ad_fact, $data);
        }
        $idFac = intval($tab_ad_fact[0]->adresse_idadresse);*/
}
    if (isset($_POST['same'])) {
        $idAd = $idFac;
        $sqlUpAd = 'UPDATE panier SET
                 adresse_idadresse =:id_ad
                 WHERE users_idUsers=:idU';
        $reqUpAd = $db->prepare($sqlUpAd);
        $reqUpAd->bindParam(':id_ad', $idAd);
        $reqUpAd->bindParam(':idU', $_SESSION['iduser']);
        $reqUpAd->execute();
    }



$tab_pan=$panier->aff_panier();


//on récupère le pays pour la livraison
$sqlPays='SELECT * FROM panier
            INNER JOIN adresse ON adresse_idadresse=idadresse
            INNER JOIN pays ON pays_idpays=idpays
            WHERE users_idUsers=:id';
$reqPays=$db->prepare($sqlPays);
$reqPays->bindParam(':id',$_SESSION['iduser']);
$reqPays->execute();
$tabAffPays=array();
while($data=$reqPays->fetchObject())
{
    array_push($tabAffPays,$data);
}

$i=0;
$pxtotal=0;
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
                    <td scope="col"><a class="text-dark" href="detail?id=<?= $panier->idcafe?>"><?=$panier->nomCafe ?></a></td>
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
    echo $tab_ad_fact[0]->adresseCP . ' ' . $tab_ad_fact[0]->adresseVille.'<br>'.$tab_ad_fact[0]->nomPays; ?>
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
        echo $tab_pan[0]->adresseCP . ' ' . $tab_pan[0]->adresseVille.'<br>'.$tabAffPays[0]->nomPays; ?>
    </div>
    </div>
    </div>
    <div class="row">
        <div class="col-xl-5=7 col-lg-7 col-md-12 col-sm-12 d-flex justify-content-between">
            <a href="selection" class="btn btn-marron">Annuler</a>
            <form method="post" action="paiement">
                <input type="text" name="recap" value="ok" class="d-none">
                <button type="submit" class="btn btn-marron">Confirmer</button>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">
        <img src="public/img/ter_paiement.png" class="w-50">
    </div>

    </div>

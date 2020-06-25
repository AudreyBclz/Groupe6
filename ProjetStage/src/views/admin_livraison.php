<?php

require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/notconnect.php';


$db=connect();
notco();
if( $_SESSION['role']!=="admin")
    {
        header('Location:accueil');
    }

$url=explode('?liv=',$_SERVER['REQUEST_URI']);
if(isset($url[1]) && $url[1]==='ok')
    {
         echo'<div class= "alert-success p-2 text-center">Commande bien mise à jour</div>';
    }

//récupération du contenu de la commande
$sqlCommande='SELECT *,
              DATE_FORMAT(dateCommande,\'%d/%m/%Y à %Hh %imin %ss\') AS date_c
              FROM commande
              INNER JOIN cafe ON cafe_idcafe=idcafe
              INNER JOIN adresse ON adresse_idadresse=idadresse
              WHERE dateLivCommande IS NULL';
$reqCommande=$db->prepare($sqlCommande);
$reqCommande->execute();
$tab_commande=array();
while($data=$reqCommande->fetchObject())
{
    array_push($tab_commande,$data);
}
 if(isset($tab_commande[0]))
 {
     $date=$tab_commande[0]->date_c;                   //Les dates servent à savoir quand le tableau doit être fermé
     $date_non_form=$tab_commande[0]->dateCommande;
     $idUser=$tab_commande[0]->users_idUsers;
 }
//déclaration globale des variables pour total
 $total=0;

?>
<div class="container">
            <div class="arr_plan">
                <h1 class="text-center titre">Admin: mettre en livraison</h1>
                <div class="row">
                    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 d-flex flex-column">
                                 <?php if(isset($tab_commande[0])){ ?><h2 class="s_titre"> Commande du <?= $tab_commande[0]->date_c ?></h2><?php } ?>
                        <table class="table">
                            <thead class= "bg-marron">
                            <tr class="text-light">
                                <th scope="col">Nom du produit</th>
                                <th scope="col" class="w-30">Quantité</th>
                                <th scope="col">Prix</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(empty($tab_commande))
                            {
                            echo'<td colspan="3">Il n\'y a pas de commandes en attente de livraison</td>';
                            }
                            else
                            {
                            foreach ($tab_commande as $achat)
                            {

                                //si date identique et même user on continue de remplir le tableau
                                if ($achat->date_c === $date && $achat->users_idUsers === $idUser)
                                {
                                    $total=$total+$achat->quantite * $achat->prixCafe; ?>
                                        <tr>
                                            <td class="bg-wheat"><a href="detail?id=<?= $achat->idcafe ?>" class="text-dark"> <?= $achat->nomCafe ?></a></td>
                                            <td class="bg-wheat"><?= $achat->quantite ?></td>
                                            <td class="bg-wheat"><?= $achat->quantite * $achat->prixCafe ?>€</td>
                                        </tr>
                                        <?php $date=$achat->date_c; } else { //récupération du pays pour livraison car impossible de faire 3 INNER JOIN sur la 1ère requête
                                        $sqlPays='SELECT *,
                                        DATE_FORMAT(dateCommande,\'%d/%m/%Y à %Hh %imin %ss\') AS date_c
                                        FROM commande
                                        INNER JOIN adresse ON adresse_idadresse=idadresse
                                        INNER JOIN pays ON pays_idpays=idpays
                                        WHERE dateLivCommande IS NULL
                                        AND dateCommande=:date_f';
                                        $reqPays=$db->prepare($sqlPays);
                                        $reqPays->bindParam(':date_f',$date_non_form);
                                        $reqPays->execute();
                                        $tab_pays=array();
                                        while($data=$reqPays->fetchObject())
                                        {
                                            array_push($tab_pays,$data);
                                        }

                                    /* si date ou user != on ferme le tableau et ajoute la colonne pour les adresses puis on ouvre un nouveau tableau*/?>
                                            <tr>
                                                <th class="bg-wheat"></th>
                                                <th class="bg-wheat">Total</th>
                                                <th class="bg-wheat"><?=$total ?>€</th>
                                            </tr>
                                    </tbody>
                                </table>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                        <div class="d-flex justify-content-between mb-5 mt-5">
                                            <div>
                                                <span class="font-weight-bold">Adresse de Facturation :</span><br/>
                                                <?= $tab_Fac[0]->prenomUsers ?> <?=$tab_Fac[0]->nomUsers ?><br/>
                                                <?= $tab_Fac[0]->adresse1 ?><br/>
                                                <?php if (strlen($tab_Fac[0]->adresse2)!==0) {
                                                    echo $tab_Fac[0]->adresse2 . '<br/>';}
                                                echo $tab_Fac[0]->adresseCP . ' ' . $tab_Fac[0]->adresseVille.'<br>'.$tab_Fac[0]->nomPays ?>
                                            </div>
                                            <div>
                                                <span class="font-weight-bold">Adresse de Livraison:</span><br/>
                                                <?php
                                                   if (isset($tab_pays[0]->adressePrenom)){
                                                       echo $tab_pays[0]->adressePrenom.' ';
                                                   }else{
                                                       echo $tab_Fac[0]->prenomUsers.' ';
                                                   }if (isset($tab_pays[0]->adresseNom)){
                                                       echo $tab_pays[0]->adresseNom;
                                                   }else{
                                                       echo $tab_Fac[0]->nomUsers;
                                                   } ?>
                                                    <br>
                                                    <?php echo $tab_pays[0]->adresse1.'<br>';
                                                        if(strlen($tab_pays[0]->adresse2) !==0){
                                                            echo $tab_pays[0]->adresse2.'<br>';
                                                        }
                                                        echo $tab_pays[0]->adresseCP.' '.$tab_pays[0]->adresseVille.'<br>'.$tab_pays[0]->nomPays;
                                                        ?>
                                            </div>
                                        </div>
                                            <?php $total=0; /* Reset du Total */?>
                                    </div>
                                    </div>
                                        <button  type="button" class="btn bg-wheat putDelivery" id="<?= $idUser ?>" data-type="<?= $date_non_form ?>">Envoyer en livraison</button>
                                    <hr class="mt-10" color="#7E6958">
                                    <div class="row">
                                        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 d-flex flex-column">
                                            <h2 class="s_titre"> Commande du <?= $achat->date_c ?></h2>
                                <table class="table">
                                     <thead class="bg-marron">
                                        <tr class="text-light">
                                            <th scope="col">Nom du produit</th>
                                            <th scope="col" class="w-30">Quantité</th>
                                            <th scope="col">Prix</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="bg-wheat"><a class="text-dark" href="detail?id=<?= $achat->idcafe ?>"><?= $achat->nomCafe ?></a></td>
                                            <td class="bg-wheat"><?= $achat->quantite ?></td>
                                            <td class="bg-wheat"><?= $achat->quantite * $achat->prixCafe ?>€</td>
                                            <?php $total=$total+$achat->quantite * $achat->prixCafe?>
                                        </tr>

<?php  $date=$achat->date_c;
       $date_non_form=$achat->dateCommande;
       $idUser=$achat->users_idUsers;
                                }
                                //récupération de l'adresse de Facturation
                                 $sqlSelFac='SELECT * FROM users
                                            INNER JOIN adresse ON adresse_idadresse=idadresse
                                            INNER JOIN pays ON pays_idpays=idpays
                                            WHERE idUsers=:id';
                                $reqSelFac=$db->prepare($sqlSelFac);
                                $reqSelFac->bindParam(':id',$achat->users_idUsers);
                                $reqSelFac->execute();
                                $tab_Fac=array();
                                while($data=$reqSelFac->fetchObject())
                                {
                                    array_push($tab_Fac,$data);
                                }

} /*On ferme le dernier tableau et on ajoute les adresses */
$sqlLiv='SELECT * FROM commande
         INNER JOIN adresse ON adresse_idadresse=idadresse
         INNER JOIN pays ON pays_idpays=idpays
         WHERE dateCommande=:date_co';
$reqLiv=$db->prepare($sqlLiv);
$reqLiv->bindParam(":date_co",$date_non_form);
$reqLiv->execute();
$tab_liv=array();
while($data=$reqLiv->fetchObject())
{
    array_push($tab_liv,$data);
}?>
                                        <tr>
                                            <th class="bg-wheat"></th>
                                            <th class="bg-wheat">Total</th>
                                            <th class="bg-wheat"><?=$total ?>€</th>
                                        </tr>
                                </tbody>
                                </table>
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                                    <div class="d-flex justify-content-between mb-5 mt-5">
                                        <div>
                                            <span class="font-weight-bold">Adresse de Facturation :</span><br/>
                                            <?= $tab_Fac[0]->prenomUsers ?> <?=$tab_Fac[0]->nomUsers ?><br/>
                                            <?= $tab_Fac[0]->adresse1 ?><br/>
                                            <?php if (strlen($tab_Fac[0]->adresse2)!==0) {
                                                echo $tab_Fac[0]->adresse2 . '<br/>';}
                                            echo $tab_Fac[0]->adresseCP . ' ' . $tab_Fac[0]->adresseVille.'<br>'.$tab_Fac[0]->nomPays ; ?>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold">Adresse de Livraison:</span><br/>
                                            <?php
                                                   if (isset($tab_liv[0]->adressePrenom)){
                                                       echo $tab_liv[0]->adressePrenom.' ';
                                                   }else{
                                                       echo $tab_Fac[0]->prenomUsers.' ';
                                                   }if (isset($tab_liv[0]->adresseNom)){
                                                       echo $tab_liv[0]->adresseNom;
                                                   }else{
                                                       echo $tab_Fac[0]->nomUsers;
                                                   } ?>
                                                    <br>
                                                    <?php echo $tab_liv[0]->adresse1.'<br>';
                                                        if(strlen($tab_liv[0]->adresse2) !==0){
                                                            echo $tab_liv[0]->adresse2.'<br>';
                                                        }
                                                        echo $tab_liv[0]->adresseCP.' '.$tab_liv[0]->adresseVille.'<br>'.$tab_liv[0]->nomPays;
                                                        ?>
                                        </div>
                                        </div>
                                            <?php $total=0; ?>

                                    </div>
                                    </div>
                                        <button  type="button" class="btn bg-wheat putDelivery" id="<?= $tab_liv[0]->users_idUsers ?>" data-type="<?= $date_non_form ?>">Envoyer en livraison</button>
                                </div>
                                                 <?php   }


<?php

require_once 'src/config/config.php';
require_once 'src/models/connect.php';
require_once 'src/models/notconnect.php';


$db=connect();
notco();


$sqlCommande='SELECT *,
              DATE_FORMAT(dateCommande,\'%d/%m/%Y à %Hh %imin %ss\') AS date_c
              FROM commande
              INNER JOIN cafe ON cafe_idcafe=idcafe
              INNER JOIN adresse ON adresse_idadresse=idadresse
              WHERE users_idUsers=:id';
$reqCommande=$db->prepare($sqlCommande);
$reqCommande->bindParam(':id',$_SESSION['iduser']);
$reqCommande->execute();
$tab_commande=array();
while($data=$reqCommande->fetchObject())
{
    array_push($tab_commande,$data);
}

 if(isset($tab_commande[0]))
 {
     $date=$tab_commande[0]->date_c;
     $date_avt=$tab_commande[0]->dateCommande; //date utile pour récupérer la livraison
 }
$total=0; //déclaration globale du total pour le récupérer en sortant de la boucle
 $sqlFac='SELECT * FROM users
          INNER JOIN adresse ON adresse_idadresse=idadresse
          INNER JOIN pays ON pays_idpays=idpays
          WHERE idUsers=:id';
 $reqFac=$db->prepare($sqlFac);
 $reqFac->bindParam(':id',$_SESSION['iduser']);
 $reqFac->execute();
 $tab_Fac=array();
 while($data=$reqFac->fetchObject())
 {
     array_push($tab_Fac,$data);
 }
?>
<div class="container">
            <div class="arr_plan">
                <h1 class="text-center titre">Historique de commande</h1>
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
                            echo'<td colspan="3">Vous n\'avez pas encore commandé chez nous</td>';
                            }
                            else
                            {
                            foreach ($tab_commande as $achat)
                            {
                                if ($achat->date_c === $date)
                                {
                                   $total=$total+$achat->quantite * $achat->prixCafe; ?>
                                        <tr>
                                            <td class="bg-wheat"><a href="detail?id=<?= $achat->idcafe ?>" class="text-dark"> <?= $achat->nomCafe ?></a></td>
                                            <td class="bg-wheat"><?= $achat->quantite ?></td>
                                            <td class="bg-wheat"><?= $achat->quantite * $achat->prixCafe ?>€</td>
                                        </tr>
                                        <?php $date=$achat->date_c; }
                                            else{ $sqlLiv='SELECT * FROM commande
                                                            INNER JOIN adresse ON adresse_idadresse=idadresse
                                                            INNER JOIN pays ON pays_idpays=idpays
                                                            WHERE dateCommande=:date_co';
                                            $reqLiv=$db->prepare($sqlLiv);
                                            $reqLiv->bindParam(':date_co',$date_avt);
                                            $reqLiv->execute();
                                            $tab_liv=array();
                                            while($data=$reqLiv->fetchObject())
                                            {
                                                array_push($tab_liv,$data);
                                            }
                                    ?>
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
                                                <?php if(isset($tab_liv[0]->adressePrenom))
                                                    {
                                                        echo $tab_liv[0]->adressePrenom.' ';
                                                    }
                                                    else
                                                        {
                                                            echo $tab_Fac[0]->prenomUsers.' ';
                                                        }
                                                    if(isset($tab_liv[0]->adresseNom))
                                                        {
                                                            echo $tab_liv[0]->adresseNom;
                                                        }
                                                    else
                                                        {
                                                            echo $tab_Fac[0]->nomUsers;
                                                        }
                                                ?><br/>
                                                <?= $tab_liv[0]->adresse1 ?><br/>
                                                <?php if (strlen($tab_liv[0]->adresse2) !== 0) {
                                                    echo $tab_liv[0]->adresse2 . '<br/>';
                                                }
                                                echo $tab_liv[0]->adresseCP . ' ' . $tab_liv[0]->adresseVille; ?>
                                            </div>
                                        </div>
                                            <?php $total=0; ?>
                                    </div>
                                    </div>
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
       $date_avt=$achat->dateCommande; }
} ?>
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
                                            <?= $tab_Fac[count($tab_Fac)-1]->prenomUsers ?> <?=$tab_Fac[count($tab_Fac)-1]->nomUsers ?><br/>
                                            <?= $tab_Fac[count($tab_Fac)-1]->adresse1 ?><br/>
                                            <?php if (strlen($tab_Fac[count($tab_Fac)-1]->adresse2)!==0) {
                                                echo $tab_Fac[count($tab_Fac)-1]->adresse2 . '<br/>';}
                                            echo $tab_Fac[count($tab_Fac)-1]->adresseCP . ' ' . $tab_Fac[count($tab_Fac)-1]->adresseVille.'<br>'.$tab_Fac[count($tab_Fac)-1]->nomPays; ?>
                                        </div>
                                        <div>
                                            <span class="font-weight-bold">Adresse de Livraison:</span><br/>
                                            <?php if (isset($achat->adressePrenom))
                                            {
                                                echo $achat->adressePrenom.' ';
                                            }else
                                            {
                                                echo $tab_Fac[0]->prenomUsers.' ';
                                            }
                                            if (isset($achat->adresseNom))
                                            {
                                                echo $achat->adresseNom;
                                            }
                                            else
                                            {
                                                echo $tab_Fac[0]->nomUsers;
                                            }
                                            ?><br/>
                                            <?= $achat->adresse1 ?><br/>
                                            <?php if (strlen($achat->adresse2) !== 0) {
                                                echo $achat->adresse2 . '<br/>';
                                            }
                                            echo $achat->adresseCP . ' ' . $achat->adresseVille; ?>
                                        </div>
                                        </div>
                                            <?php $total=0; ?>
                                    </div>
                                </div>
                                                 <?php   }



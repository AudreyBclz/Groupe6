<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';
require_once '../models/notconnect.php';
session_start();
head();
notco();
$db=connect();
$sqlSelPan = 'SELECT * FROM panier
              INNER JOIN cafe ON cafe_idcafe=idcafe
              WHERE users_idUsers =:id';
$reqSelPan = $db->prepare($sqlSelPan);
$reqSelPan->bindParam(':id', $_SESSION['iduser']);
$reqSelPan->execute();
$tab_pan=array();
while($data=$reqSelPan->fetchObject())
{
    array_push($tab_pan,$data);
}

foreach ($tab_pan as $article)
{
    if (intval($article->stockCafe) < intval($article->quantite))
    {
        echo'<div class="alert-warning p-2 text-center">Quantité supérieur au stock disponible, veuillez modifier votre panier.</div>';
    }
    else {

        $id_c=intval($article->cafe_idcafe);
        $qte= intval($article->quantite);
        $ad=intval($article->adresse_idadresse);
        $sql = 'INSERT INTO commande (users_idUsers,cafe_idcafe,dateCommande,quantite,adresse_idadresse)
             VALUES ('.$_SESSION["iduser"].','.$id_c.',NOW(),'.$qte.','.$ad.')';
        $req = $db->prepare($sql);
        $req->execute();

        $sqlUpCafe='UPDATE cafe SET
                    stockCafe = stockCafe -'.intval($article->quantite).'.,
                    nbventeCafe = nbventeCafe +'.intval($article->quantite).',
                    date_modifCafe = NOW()
                    WHERE idcafe='.intval($article->idcafe);
        $reqUpCafe=$db->prepare($sqlUpCafe);
        $reqUpCafe->execute();
        }
}
$sqlDelPan='DELETE FROM panier
            WHERE users_idUsers='.$_SESSION['iduser'];
$reqDelPan=$db->prepare($sqlDelPan);
$reqDelPan->execute();

echo'<div class="alert-success p-5 m-auto text-center"> Votre Commande a bien été enregistrée, Merci de votre confiance.</div>';
footer();



<?php
require_once '../../../src/config/config.php';
require_once '../../../src/config/connect.php';
$db=connect();
if (isset($_POST['date']) && isset($_POST['id_user']))
{
    //on passe la commande sélectionnée en livraison
    $sqlUpCommande='UPDATE commande SET
                        dateLivCommande = NOW()
                        WHERE dateCommande=:date_co
                        AND users_idUsers=:id';
    $reqUpCommande=$db->prepare($sqlUpCommande);
    $reqUpCommande->bindParam(':date_co',$_POST['date']);
    $reqUpCommande->bindParam(':id',$_POST['id_user']);
    $reqUpCommande->execute();
    echo '<div class= "alert-success p-2 text-center mb-3">Commande bien mise à jour</div>';

}

<?php
require '../../../vendor/autoload.php';
use App\Models\User;
use App\Models\Adresse;
use App\Models\pays;
require_once '../../../src/config/config.php';
require_once '../../../src/config/connect.php';
session_start();

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

if (isset($_POST['nom']))
{
    $user= new User($db);
    $user->setNomUsers($_POST['nom']);
    $user->setPrenomUsers($_POST['prenom']);
    $user->setMailUsers($_POST['email']);

    $pays_m= new pays($db);
    $pays_m->setNomPays($_POST['pays']);

    $adresse_m= new Adresse($db);
    $adresse_m->setAdresse1($_POST['adresse']);
    $adresse_m->setAdresse2($_POST['complement']);
    $adresse_m->setAdresseCP($_POST['codePost']);
    $adresse_m->setAdresseVille($_POST['ville']);

    if(!empty($user->getErrors()))
    {
        foreach ($user->getErrors() as $error)
        {
            echo '<div class="alert-warning p-2 text-center">' . $error . '</div>';
        }
    }
    elseif (!empty($adresse_m->getErrors()))
    {
        foreach ($adresse_m->getErrors() as $error)
        {
            echo '<div class="alert-warning p-2 text-center">' . $error . '</div>';
        }
    }
    elseif (!empty($pays_m->getErrors()))
    {
        echo '<div class="alert-warning p-2 text-center">' . $error . '</div>';
    }
    else
    {
        $idpays = $pays_m->select_champ($pays_m->getChamps(),$pays_m->getNomPays())[0]->idpays;
        if (empty($idpays)) {
            $idpays = $pays_m->insert_pays();
        }
        $idAdresse = $adresse_m->check_adresse($pays_m,0);
        $adresse_m->setPaysIdpays($idpays);
        if ($idAdresse == '') {
            $idAdresse = $adresse_m->insert_adresse(0);
        }
        $user->setAdresseIdadresse($idAdresse);

        $user->update_user();

        echo '<div class="alert-success p-2 text-center">Modification du compte bien effectuée.</div>';

        $_POST['nom']="";
        $_POST['prenom']="";
        $_POST['email']="";
        $_POST['adresse']="";
        $_POST['complement']="";
        $_POST['codePost']="";
        $_POST['ville']="";
        $_POST['pays']="";
    }
}
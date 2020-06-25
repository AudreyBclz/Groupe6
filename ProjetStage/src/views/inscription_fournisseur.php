<?php
use App\Models\User;
use App\Models\pays;
use App\Models\Adresse;
require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/notconnect.php';


notco();
$db=connect();

if($_SESSION['role']!=="admin")
{
    header('Location:accueil');
}
elseif (isset($_POST['societe']))
   {

    $user_ins=new User($db);
    $user_ins->setNomUsers($_POST['nom'])
             ->setPrenomUsers($_POST['prenom'])
             ->setMailUsers($_POST['email'])
             ->setConfMailUsers($_POST['conf_email'])
             ->setConfMdpUsers($_POST['conf_mdp'])
             ->setPassUsers($_POST['mdp'])
             ->setRoleUsers("fournisseur");

    $pays_ins=new pays($db);
    $pays_ins->setNomPays($_POST['pays']);

    $adresse_ins=new Adresse($db);
    $adresse_ins->setAdresse1($_POST['adresse'])
                ->setAdresse2($_POST['complement'])
                ->setAdresseCP($_POST['codePost'])
                ->setAdresseVille($_POST['ville']);

    $mdp_hash=password_hash(htmlspecialchars(trim($_POST['mdp'])),PASSWORD_BCRYPT);
    $societe=htmlspecialchars(trim($_POST['societe']));

       if (!empty($user_ins->getErrors()))
       {
           foreach ($user_ins->getErrors() as $error)
           {
               echo '<div class="alert-warning p-2 text-center">' . $error . '</div>';
           }
       } elseif (!empty($adresse_ins->getErrors()))
       {
           foreach ($adresse_ins->getErrors() as $error)
           {
               echo '<div class="alert-warning p-2 text-center">' . $error . '</div>';
           }
       } elseif (!empty($pays_ins->getErrors()))
       {
           foreach ($pays_ins->getErrors() as $error)
           {
               echo '<div class="alert-warning p-2 text-center">' . $error . '</div>';
           }
       }
       elseif($user_ins->check_user()!=='')
        {
            echo '<div class="alert-warning p-2 text-center">Adresse mail déjà utilisée</div>';
        }
        else
        {
            $idAdresse=$adresse_ins->check_adresse($pays_ins,0);
            if($idAdresse=='')
            {
                $idPays = $pays_ins->select_champ($pays_ins->getChamps(),$pays_ins->getNomPays())[0]->idpays;
                if (empty($idPays))
                {
                    $idPays = $pays_ins->insert_pays();
                }
                $adresse_ins->setPaysIdpays($idPays);
                $idAdresse = $adresse_ins->insert_adresse(0);
            }
            $user_ins->setAdresseIdadresse($idAdresse);
            $iduser=$user_ins->insert_user($mdp_hash);

             //on insère les données dans la table fournisseur

            $sqlInsFourn = 'INSERT INTO fournisseur (societeFournisseur,users_idUsers) VALUES (:societe,:id_u)';
            $reqInsFourn = $db->prepare($sqlInsFourn);
            $reqInsFourn->bindParam(':societe', $societe);
            $reqInsFourn->bindParam(':id_u', $idUser);
            $reqInsFourn->execute();

            echo '<div class="alert-success p-2 text-center">L\'inscription du fournisseur a bien été enregistrée</div>';

            //une fois inscrit on  efface les données car la fonction aff_champ les réaffiche
            $_POST['societe']="";
            $_POST['nom']="";
            $_POST['prenom']="";
            $_POST['email']="";
            $_POST['conf_email']="";
            $_POST['mdp']="";
            $_POST['conf_mdp']="";
            $_POST['adresse']="";
            $_POST['complement']="";
            $_POST['codePost']="";
            $_POST['pays']="";
        }
    }

//on fait un submit au changement de code postal pour l'api donc on a besoin d'afficher les cases déjà remplies
function aff_champ($name_champ)
{
    if (isset($_POST[$name_champ])) {
        echo $_POST[$name_champ];
    }
}

?>
<div class="container mx-auto">
    <div class="arr_plan row justify-content-center">
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 d-flex flex-column">
            <h1 class="text-center titre">Admin: Ajout Fournisseur</h1>
            <form method="post" action="ajout_fournisseur" class="m-1" id="form_ins">
                <div class="row">
                    <label for="societe">Nom de la société :</label>
                </div>
                <div class="row">
                    <input type="text" name="societe" id="societe" value="<?php aff_champ('societe'); ?>" class="form-control">
                </div>
                <div class="row justify-content-between">
                    <label for="nom" class="label">Nom :</label>
                    <label for="prenom" class="label">Prénom :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="text" name="nom" id="nom" value="<?php aff_champ('nom'); ?>" class="form-control w-45" required="required"/>
                    <input type="text" name="prenom" id="prenom" value="<?php aff_champ('prenom'); ?>" class="form-control w-45" required="required"/>
                </div>
                <div class="row justify-content-between">
                    <label for="email" class="label">Email :</label>
                    <label for="mdp" class="label">Mot de passe * :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="email" name="email" id="email" value="<?php aff_champ('email'); ?>" class="form-control w-45 " required="required">
                    <input type="password" name="mdp" id="mdp" value="<?php aff_champ('mdp'); ?>" class="form-control w-45" required="required" aria-describedby="passhelp">
                </div>
                <div class="row justify-content-between">
                    <label for="conf_email" class="label">Confirmer mail :</label>
                    <label for="conf_mdp" class="label">Confirmer mot de passe :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="email" name="conf_email" id="conf_email" value="<?php aff_champ('conf_email');?>" class="form-control w-45 " required="required">
                    <input type="password" name="conf_mdp" id="conf_mdp" value="<?php aff_champ('conf_mdp');?>" class="form-control w-45" required="required">
                </div>
                <div class="row justify-content-between">
                    <label for="adresse" class="label">Adresse :</label>
                    <label for="complement" class="label">Complément :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="text" name="adresse" id="adresse" value="<?php aff_champ('adresse');?>" class="form-control w-45" required="required">
                    <input type="text" name="complement" id="complement" value="<?php aff_champ('complement');?>" class="form-control w-45">
                </div>
                <div class="row justify-content-between">
                    <label for="codePost" class="label">Code Postal :</label>
                    <label for="ville" class="label">Ville :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="text" name="codePost" id="codePost" value="<?php aff_champ('codePost');?>" class="form-control w-30" required="required">
                    <?php
                    if (isset($_POST['codePost']))
                    {
                    //fonction que j'ai récupéré sur internet qui teste si une page existe grâce au code contenu dans le header
                    function file_contents_exist($url, $response_code = 200)
                    {
                        $headers = get_headers($url);

                        if (substr($headers[0], 9, 3) == $response_code)
                        {
                            return TRUE;
                        }
                        else
                        {
                            return FALSE;
                        }
                    }
                    if(file_contents_exist('https://api.zippopotam.us/fr/' . $_POST['codePost']))
                    {
                    //s'il existe on récupère le contenu de la page
                    $url=file_get_contents('https://api.zippopotam.us/fr/' . $_POST['codePost']);
                    // on remplace la clé "place name" par "placeName"
                    $url=str_replace("place name","placeName",$url);
                    $tab=json_decode($url);
                    $tab_ville=$tab->places;
                    ?>
                    <select class="form-control w-45" name="ville" id="ville">
                        <?php foreach ($tab_ville as $ville)
                        { ?>
                            <option id="ville" value="<?= $ville->placeName ?>"><?= $ville->placeName ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row">
                    <label for="pays">Pays :</label>
                </div>
                <div class="row">
                    <input type="text" value="<?= $tab->country ?>" class="form-control w-45" name="pays" id="pays"/>
                </div>
                <?php }
                else
                { ?>
                <input type="text" id="ville" class="form-control w-45" name="ville"/>
        </div>
        <div class="row">
            <label for="pays">Pays :</label>
        </div>
        <div class="row">
            <input type="text" class="form-control w-45" name="pays" id="pays"/>
        </div>
        <?php  } } else {?>
        <input type="text" id="ville" class="form-control w-45" name="ville"/>
    </div>
    <div class="row">
        <label for="pays">Pays :</label>
    </div>
    <div class="row">
        <input type="text" class="form-control w-45" name="pays" id="pays"/>
    </div>
    <?php } ?>

    <div class="row mt-3">
        <label for="robot" class="mr-2"> Je ne suis pas un robot :</label>
        <input type="checkbox" value="ok" name="robot" id="robot" class="form-check" />
    </div>
    <div class="row justify-content-between">
        <button type="submit" class="btn btn-marron mt-3" id="inscription">S'inscrire</button>
        <small id="passhelp"> *8 caractères minimum et au moins une majuscule</small>
    </div>
    </form>
    <div class="container text-center m-0">
        <img src="public/img/tasseCafe.png" id="logo">
    </div>
</div>
</div>

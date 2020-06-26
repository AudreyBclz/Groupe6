<?php


require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/notconnect.php';

notco();
$db=connect();

//récupération des infos de l'utilisateur
$sqlSelInfo='SELECT * FROM users
             INNER JOIN adresse ON adresse_idadresse=idadresse
             INNER JOIN pays ON pays_idpays=idpays
             WHERE idUsers=:id';

$reqSelInfo=$db->prepare($sqlSelInfo);
$reqSelInfo->bindParam(':id',$_SESSION['iduser']);
$reqSelInfo->execute();
$tab_info=array();
while($data=$reqSelInfo->fetchObject())
{
    array_push($tab_info,$data);
}

//on fait un submit au changement de code postal pour l'api donc on a besoin d'afficher les cases déjà remplies
function aff_champ($name_champ)
{
    if (isset($_POST[$name_champ])) {
        echo $_POST[$name_champ];
        return true;
    }else{
        return false;
    }
}

?>
<div class="container">
    <div class="arr_plan">
        <h1 class="text-center titre">Modifcation des informations du compte</h1>
         <!-- <form method="post" action="monCompte" class="m-1" id="form_ins"> -->
            <div class="col-12">
                <div class="row justify-content-between mt-3">
                    <label for="nom" class="label">Nom :</label>
                    <label for="prenom" class="label">Prénom :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="text" name="nom" id="nom" value="<?php if (!aff_champ('nom')){echo $tab_info[0]->nomUsers;}; ?>" class="form-control w-45" required="required"/>
                    <input type="text" name="prenom" id="prenom" value="<?php if (!aff_champ('prenom')){echo $tab_info[0]->prenomUsers;}; ?>" class="form-control w-45" required="required" readonly/>
                </div>
                <div class="row justify-content-between mt-3">
                    <label for="email" class="label">Email :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="email" name="email" id="email" value="<?php if (!aff_champ('email')){echo $tab_info[0]->mailUsers;}; ?>" class="form-control w-45 " required="required" readonly>
                </div>
                <div class="row justify-content-between mt-3">
                    <label for="adresse" class="label">Adresse :</label>
                    <label for="complement" class="label">Complément :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="text" name="adresse" id="adresse" value="<?php if(!aff_champ('adresse')){echo $tab_info[0]->adresse1;}?>" class="form-control w-45" required="required">
                    <input type="text" name="complement" id="complement" value="<?php if(!aff_champ('complement')){echo $tab_info[0]->adresse2;}?>" class="form-control w-45">
                </div>
                <div class="row justify-content-between mt-3">
                    <label for="codePost" class="label">Code Postal :</label>
                    <label for="ville" class="label">Ville :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="text" name="codePost" id="codePost" value="<?php if(!aff_champ('codePost')){echo $tab_info[0]->adresseCP;};?>" class="form-control w-30" required="required">
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
                    <select class="form-control w-45" name="ville" id="ville" required="required">
                        <?php foreach ($tab_ville as $ville)
                        { ?>
                            <option id="ville" value="<?= $ville->placeName ?>"><?= $ville->placeName ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row mt-3">
                    <label for="pays">Pays :</label>
                </div>
                <div class="row">
                    <input type="text" value="<?= $tab->country ?>" class="form-control w-45" name="pays" id="pays" required="required"/>
                </div>
                <?php }
                else
                { ?>
                <input type="text" id="ville" value="<?= $tab_info[0]->adresseVille ?>" class="form-control w-45" name="ville" required="required"/>
                </div>

            <div class="row mt-3">
                <label for="pays">Pays :</label>
            </div>
            <div class="row">
                <input type="text" value="" class="form-control w-45" name="pays" id="pays" required="required"/>
            </div>
        <?php  } } else {?>
        <input type="text" id="ville" value="<?= $tab_info[0]->adresseVille ?>" class="form-control w-45" name="ville" required="required"/>
          </div>

    <div class="row mt-3">
        <label for="pays">Pays :</label>
    </div>
    <div class="row">
        <input type="text" value="" class="form-control w-45" name="pays" id="pays" required="required"/>
    </div>
              <?php } ?>
              <div class="row mt-3">
                  <label for="robot" class="mr-2"> Je ne suis pas un robot :</label>
                  <input type="checkbox" value="ok" name="robot" id="robot" class="form-check" />
              </div>
              <div class="row justify-content-between">
                  <button type="button" class="btn btn-marron mt-3 modif_compte" id="modif">Modifier</button>
                  <a href="selection" class="btn btn-marron mt-3">Retour</a>
              </div>
   <!-- </form> -->
    </div>



<?php require_once 'src/config/config.php';
require_once 'src/models/connect.php';
require_once 'src/models/notconnect.php';

notco();
$db=connect();

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
function aff_champ($name_champ)
{
    if (isset($_POST[$name_champ])) {
        echo $_POST[$name_champ];
        return true;
    }else{
        return false;
    }
}
if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['adresse']) && isset($_POST['complement'])
 && isset($_POST['codePost']) && isset($_POST['ville']) && isset($_POST['pays']) && isset($_POST['robot']))
{
    $nom=htmlspecialchars(trim($_POST['nom']));
    $adresse=htmlspecialchars(trim($_POST['adresse']));
    $complement=htmlspecialchars(trim($_POST['complement']));
    $cp=htmlspecialchars(trim($_POST['codePost']));
    $ville=htmlspecialchars(trim($_POST['ville']));
    $pays=htmlspecialchars(trim($_POST['pays']));

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
        $idpays=$tab_pays[0]->idpays;
    }
    else{
        $sqlInsPays='INSERT INTO pays (nomPays) VALUES (:pays)';
        $reqInsPays=$db->prepare($sqlInsPays);
        $reqInsPays->bindParam(':pays',$pays);
        $reqInsPays->execute();
        $idpays=$db->lastInsertId();
    }

   $sqlSelAd='SELECT * FROM adresse
                WHERE adresse1=:ad1
                AND adresse2=:ad2
                AND adresseCP=:cp
                AND adresseVille=:ville
                AND pays_idpays=:id_p
                AND adressePrenom IS NULL
                AND adresseNom IS NULL';
    $reqSelAd=$db->prepare($sqlSelAd);
    $reqSelAd->bindParam(':ad1',$adresse);
    $reqSelAd->bindParam(':ad2',$complement);
    $reqSelAd->bindParam(':cp',$cp);
    $reqSelAd->bindParam(":ville",$ville);
    $reqSelAd->bindParam(':id_p',$idpays);
    $reqSelAd->execute();
    $tab_ad=array();
    while($data=$reqSelAd->fetchObject())
    {
        array_push($tab_ad,$data);
    }
    if(!empty($tab_ad))
    {
        $idAd=$tab_ad[0]->idadresse;
    }
    else
    {
        $sqlInsAd='INSERT INTO adresse(adresse1,adresse2,adresseCP,adresseVille,pays_idpays)
                    VALUES (:ad1,:ad2,:cp,:ville,:id_pays)';
        $reqInsAd=$db->prepare($sqlInsAd);
        $reqInsAd->bindParam(':ad1',$adresse);
        $reqInsAd->bindParam(':ad2',$complement);
        $reqInsAd->bindParam(':cp',$cp);
        $reqInsAd->bindParam(':ville',$ville);
        $reqInsAd->bindParam(':id_pays',$idpays);
        $reqInsAd->execute();
        $idAd=$db->lastInsertId();

    }
    $sqlUpUser='UPDATE users SET
                nomUsers=:nom,
                adresse_idadresse=:id_a
                WHERE idUsers=:id_u';
    $reqUpUser=$db->prepare($sqlUpUser);
    $reqUpUser->bindParam(':nom',$nom);
    $reqUpUser->bindParam(':id_a',$idAd);
    $reqUpUser->bindParam(':id_u',$_SESSION['iduser']);
    $reqUpUser->execute();

echo '<div class="alert-success p-2 text-center">Modification du compte bien effectuée.</div>';
}
?>
<div class="container">
    <div class="arr_plan">
        <h1 class="text-center titre">Modifcation des informations du compte</h1>
          <form method="post" action="monCompte" class="m-1" id="form_ins">
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
                    $url=file_get_contents('https://api.zippopotam.us/fr/' . $_POST['codePost']);
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
        <div class="row"><
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
                  <button type="submit" class="btn btn-marron mt-3" id="inscription">Modifier</button>
                  <a href="selection" class="btn btn-marron mt-3">Retour</a>
              </div>
    </form>
    </div>



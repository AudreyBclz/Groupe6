<?php

require_once 'src/config/config.php';
require_once 'src/models/connect.php';

$db=connect();



if(isset($_POST['email_co']) && isset($_POST['mdp_co']))
{
    $mail_co=htmlspecialchars(trim($_POST['email_co']));
    $mdp_co=htmlspecialchars(trim($_POST['mdp_co']));
    $isOk=true;

    $sqlSelMail_co='SELECT * FROM users
                    WHERE mailUsers=:mail';
    $reqSelMail_co=$db->prepare($sqlSelMail_co);
    $reqSelMail_co->bindParam(':mail',$mail_co);
    $reqSelMail_co->execute();
    $tab_mail_co=array();
    while($data=$reqSelMail_co->fetchObject())
    {
        array_push($tab_mail_co,$data);
    }
    if(empty($tab_mail_co))
    {
        $isOk=false;
    }
    else
    {
        $isOk=password_verify($mdp_co,$tab_mail_co[0]->passUsers);
    }
    if ($isOk)
    {
        $_SESSION['prenom']=$tab_mail_co[0]->prenomUsers;
        $_SESSION['nom']=$tab_mail_co[0]->nomUsers;
        $_SESSION['iduser']=$tab_mail_co[0]->idUsers;
        $_SESSION['role']=$tab_mail_co[0]->roleUsers;
        header('Location:selection?connect=ok');
    }
    else
    {
        echo '<div class="alert-warning p-2 text-center">Mail ou mot de passe incorrect, veuillez réessayer</div>';
    }

}

if (isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["email"]) && isset($_POST["mdp"])
    && isset($_POST["conf_email"]) && isset($_POST["conf_mdp"]) && isset($_POST["adresse"]) &&
    isset($_POST["codePost"]) && isset($_POST["ville"]) && isset($_POST['pays']) && isset($_POST["robot"]))
{
    $pays=htmlspecialchars(trim($_POST['pays']));
    $nom=htmlspecialchars(trim($_POST['nom']));
    $prenom=htmlspecialchars(trim($_POST['prenom']));
    $email=htmlspecialchars(trim($_POST['email']));
    $mdp=password_hash(htmlspecialchars(trim($_POST['mdp'])),PASSWORD_BCRYPT);
    $adresse=htmlspecialchars(trim($_POST['adresse']));
    $complement=htmlspecialchars(trim($_POST['complement']));
    $ville=htmlspecialchars(trim($_POST['ville']));
    $cp=htmlspecialchars(trim($_POST['codePost']));

    if($pays==""||$nom==""||$prenom==""||$email==""||$mdp==""||$adresse==""||$ville==""||$cp=="")
    {
        echo'<div class="alert-warning p-2 text-center">Des champs sont manquants veuillez les remplir.</div>';

    }
    else{
    $sqlSelAd='SELECT idadresse,pays_idpays FROM adresse
                INNER JOIN pays ON pays_idpays=idpays
                WHERE adresse1=:ad
                AND adresse2=:ad2
                AND adresseCP=:cp
                AND adresseVille=:ville
                AND nomPays=:pays';
    $reqSelAd=$db->prepare($sqlSelAd);
    $reqSelAd->bindParam(':ad',$adresse);
    $reqSelAd->bindParam(':ad2',$complement);
    $reqSelAd->bindParam(':cp',$cp);
    $reqSelAd->bindParam(':ville',$ville);
    $reqSelAd->bindParam(':pays',$pays);
    $reqSelAd->execute();
    $tab_ad=array();
    while($data=$reqSelAd->fetchObject())
    {
        array_push($tab_ad,$data);
    }
    if(!empty($tab_ad))
    {
        $idAd=intval($tab_ad[0]->idadresse);
    }
    else
    {
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

            $sqlInsPays='INSERT INTO pays (nomPays) VALUES (:pays)';
            $reqInsPays=$db->prepare($sqlInsPays);
            $reqInsPays->bindParam(':pays',$pays);
            $reqInsPays->execute();
            $idPays=intval($db->lastInsertId());

        }

        $sqlInsAd='INSERT INTO adresse (adresse1,adresse2,adresseCP,adresseVille,pays_idpays)
                    VALUES (:ad1,:ad2,:cp,:ville,:pays)';
        $reqInsAd=$db->prepare($sqlInsAd);
        $reqInsAd->bindParam(':ad1',$adresse);
        $reqInsAd->bindParam(':ad2',$complement);
        $reqInsAd->bindParam(':cp',$cp);
        $reqInsAd->bindParam(':ville',$ville);
        $reqInsAd->bindParam(':pays',$idPays);
        $reqInsAd->execute();
        $idAd=intval($db->lastInsertId());
    }
    $sqlSelMail='SELECT idUsers FROM users
                 WHERE mailUsers=:mail';
    $reqSelMail=$db->prepare($sqlSelMail);
    $reqSelMail->bindParam(':mail',$email);
    $reqSelMail->execute();
    $tab_mail=array();
    while($data=$reqSelMail->fetchObject())
    {
        array_push($tab_mail,$data);
    }
    if(!empty($tab_mail))
    {
        echo'<div class="alert-warning p-2 text-center">Adresse mail déjà utilisée</div>';
    }
    else
    {
        $sqlInsUser="INSERT INTO users (nomUsers,prenomUsers,mailUsers,passUsers,roleUsers,adresse_idadresse)
                     VALUES (:nom,:prenom,:mail,:pass,'client',:ad)";
        $reqInsUser=$db->prepare($sqlInsUser);
        $reqInsUser->bindParam(':nom',$nom);
        $reqInsUser->bindParam(':prenom',$prenom);
        $reqInsUser->bindParam(':mail',$email);
        $reqInsUser->bindParam(':pass',$mdp);
        $reqInsUser->bindParam(':ad',$idAd);
        $reqInsUser->execute();
        echo '<div class="alert-success p-2 text-center">Votre inscription a bien été enregistrée</div>';
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
}
function aff_champ($name_champ)
{
    if (isset($_POST[$name_champ])) {
        echo $_POST[$name_champ];
    }
}
?>

<div class="container">
        <div class="arr_plan row mt-5 justify-content-between">
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 d-flex flex-column">
                <h1 class="text-center titre mb-5">Connexion</h1>
                <form method="post" action="connexion&ins" class="m-1">
                    <div class="row">
                        <label for="email_co">Email</label>
                        <input type="email" name="email_co" id="email_co" class="form-control">
                    </div>
                    <div class="row">
                        <label for="mdp_co">Mot de passe</label>
                        <input type="password" name="mdp_co" id="mdp_co" class="form-control">
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-marron mt-3">Se connecter</button>
                    </div>
                </form>
                <div class="container text-center">
                    <img src="public/img/tasseCafe.png" id="logo">
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex flex-column">
                <div class="d-none d-lg-block">
                    <h1 class="text-center titre mb-5">Inscription</h1>
                    <form method="post" action="connexion&ins" class="m-1" id="form_ins">
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
                                <input type="text" name="complement" value="<?php aff_champ('complement');?>" id="complement" class="form-control w-45">
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
                            <input type="text" value="<?= $tab->country ?>" class="form-control w-45" name="pays" id="pays" required="required"/>
                        </div>
                        <?php }
                        else
                        { ?>
                        <input type="text" id="ville" class="form-control w-45" name="ville" required="required"/>
                </div>
                <div class="row">
                    <label for="pays">Pays :</label>
                </div>
                <div class="row">
                    <input type="text" class="form-control w-45" name="pays" id="pays" required="required"/>
                </div>
                <?php  } } else {?>
                <input type="text" id="ville" class="form-control w-45" name="ville" required="required"/>
            </div>
            <div class="row">
                <label for="pays">Pays :</label>
            </div>
            <div class="row">
                <input type="text" class="form-control w-45" name="pays" id="pays" required="required"/>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

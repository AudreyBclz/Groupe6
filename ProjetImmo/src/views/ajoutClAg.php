<?php

require_once 'src/config/config.php';
require_once 'src/models/connect.php';


$db=connect();



if (isset($_POST['nomAgence']) && isset($_POST['nomRepre']) && isset($_POST['prenomRepre']) && isset($_POST['emailAg']) && isset($_POST['mdpAg']) &&
    isset($_POST['confmdpAg']) && isset($_POST['adresse1Ag']) && isset($_POST['codePostAg']) &&isset($_POST['villeAg']) && isset($_POST['paysAg'])) {

    $sqlSelAg = 'SELECT iduser,mailUser FROM user 
                    INNER JOIN agence ON iduser=user_iduser
                    WHERE agence.nomAgence = :nom OR mailUser = :mail';
    $reqSelAg = $db->prepare($sqlSelAg);
    $reqSelAg->bindParam(':nom', $_POST['nomAg']);
    $reqSelAg->bindParam(':mail',$_POST['emailAg']);
    $reqSelAg->execute();
    $ag = array();
    while ($data = $reqSelAg->fetchObject()) {
        array_push($ag, $data);
    }
    if (!empty($ag)) { ?>
        <div class="alert-warning">L'agence a déjà été enregistrée</div>
        <?php
    }
    elseif ($_POST['mdpAg'] != $_POST['confmdpAg'])
    { ?>
        <div class="alert-warning">Erreur dans la confirmation du mot de passe</div>
        <?php
    } else {
        $sqlInsAdAg = 'INSERT INTO adresse (adresse1, adresse2,ville,codepostal,pays)
                 VALUES(:adresse1,:adresse2,:ville,:cp,:pays)';
        $reqInsAdAg = $db->prepare($sqlInsAdAg);
        $reqInsAdAg->bindParam(':adresse1', $_POST['adresse1Ag']);
        $reqInsAdAg->bindParam(':adresse2', $_POST['adresse2Ag']);
        $reqInsAdAg->bindParam(':ville',$_POST['villeAg']);
        $reqInsAdAg->bindParam(':cp', $_POST['codePostAg']);
        $reqInsAdAg->bindParam(':pays', $_POST['paysAg']);
        $reqInsAdAg->execute();
        $idAd = intval($db->lastInsertId());

        $sqlInsUser='INSERT INTO users (mailUser,mdpUser)
                        VALUES (:mail,:mdp)';
        $reqInsUser=$db->prepare($sqlInsUser);
        $mdpAg = password_hash(htmlspecialchars(trim($_POST['mdpAg'])), PASSWORD_DEFAULT);
        $mailAg=htmlspecialchars(trim($_POST['emailAg']));
        $reqInsUser->bindParam(':mail',$mailAg);
        $reqInsUser->bindParam(':mdp',$mdpAg);
        $reqInsUser->execute();
        $idUs=intval($db->lastInsertId());


        $sqlInsAg = 'INSERT INTO agence (nomAgence,nomRepreAgence,prenomRepreAgence,adresse_idadresse,user_iduser)
                VALUES (:nomAg,:nomRepre,:prenomRe,:idAd,:idU)';
        $reqInsAg = $db->prepare($sqlInsAg);
       // <--- ici le password_default est à Bcrypt
        $reqInsAg->bindParam(':nomAg', $_POST['nomAgence']);
        $reqInsAg->bindParam(':nomRepre', $_POST['nomRepre']);
        $reqInsAg->bindParam(':prenomRe', $_POST['prenomRepre']);
        $reqInsAg->bindParam(':idAd', $idAd);
        $reqInsAg->bindParam(':idU',$idUs);
        $reqInsAg->execute();

        echo'<div class="alert-success">Agence bien enregistrée</div>';
    }
}

if (isset($_POST['nomClient']) && isset($_POST['prenomClient']) && isset($_POST['emailClient']) && isset($_POST['mdp']) && isset($_POST['confmdp']) &&
    isset($_POST['cladresse1']) && isset($_POST['cladresse2']) && isset($_POST['clcodePost']) && isset($_POST['clville']) && isset($_POST['clpays'])) {

    $sqlSelCl = 'SELECT mailUser,mdpUser FROM users
                    INNER JOIN client ON iduser=user_iduser 
                    WHERE (client.nomClient=:nomCl AND client.prenomClient=:prenomCl) OR mailUser=:mail';
    $reqSelCl = $db->prepare($sqlSelCl);
    $reqSelCl->bindParam(':nomCl', $_POST['nomClient']);
    $reqSelCl->bindParam(':prenomCl', $_POST['prenomClient']);
    $reqSelCl->bindParam(':mail',$_POST['emailClient']);
    $reqSelCl->execute();
    $cl = array();
    while ($data = $reqSelCl->fetchObject()) {
        array_push($cl, $data);
    }
    if (!empty($cl)) { ?>
        <div class="alert-warning">Le client a déjà été enregistré</div>
        <?php
    }
    elseif ($_POST['mdp'] != $_POST['confmdp'])
    { ?>
        <div class="alert-warning">Erreur dans la confirmation du mot de passe</div>
        <?php
    } else {
        $sqlInsAdCl = 'INSERT INTO adresse (adresse1, adresse2,ville,codepostal,pays)
                 VALUES(:adresse1,:adresse2,:ville,:cp,:pays)';
        $reqInsAdCl = $db->prepare($sqlInsAdCl);
        $reqInsAdCl->bindParam(':adresse1', $_POST['cladresse1']);
        $reqInsAdCl->bindParam(':adresse2', $_POST['cladresse2']);
        $reqInsAdCl->bindParam(':ville',$_POST['clville']);
        $reqInsAdCl->bindParam(':cp', $_POST['clcodePost']);
        $reqInsAdCl->bindParam(':pays', $_POST['clpays']);
        $reqInsAdCl->execute();
        $idAdCl = intval($db->lastInsertId());

        $sqlInsUser='INSERT INTO users (mailUser,mdpUser)
                        VALUES (:mailC,:mdpC)';
        $reqInsUser2=$db->prepare($sqlInsUser);
        $mdpCl=password_hash(htmlspecialchars(trim($_POST['mdp'])),PASSWORD_BCRYPT);
        $mailCl=htmlspecialchars(trim($_POST['emailClient']));
        $reqInsUser2->bindParam(':mailC',$mailCl);
        $reqInsUser2->bindParam(':mdpC',$mdpCl);
        $reqInsUser2->execute();
        $idUsCl=intval($db->lastInsertId());


        $sqlInsCl = 'INSERT INTO client (nomClient,prenomClient,adresse_idadresse,user_iduser)
                VALUES (:nomCl,:prenomCl,:idCl,:idUs)';
        $reqInsCl = $db->prepare($sqlInsCl);
        $reqInsCl->bindParam(':nomCl', $_POST['nomClient']);
        $reqInsCl->bindParam(':prenomCl', $_POST['prenomClient']);
        $reqInsCl->bindParam(':idCl', $idAdCl);
        $reqInsCl->bindParam(':idUs',$idUsCl);
        $reqInsCl->execute();

        echo'<div class="alert-success">Client bien enregistré</div>';
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-lg-1 mt-sm-5 mt-md-5">
        <h2 class="text-center mb-4"> Vous êtes une agence?</h2>
        <form method="post" action="ajoutClAg.php">
            <div class="form-group">
                <label for="nomAg">Nom de l'agence :</label>
                <input type="text" name="nomAgence" id="nomAg" class="form-control" required="required">
            </div>
            <div class="d-flex justify-content-between">
                <div class="form-group">
                    <label for="nomRepre">Nom du représentant :</label>
                    <input type="text" name="nomRepre" id="nomRepre" class="form-control w-75" required="required">
                </div>
                <div class="form-group">
                    <label for="prenomRepre">Prénom du représentant :</label>
                    <input type="text" name="prenomRepre" id="prenomRepre" class="form-control w-75" required="required">
                </div>
            </div>
            <div class="form-group">
                <label for="emailAg">Email :</label>
                <input type="email" name="emailAg" id="emailAg" class="form-control" required="required">
            </div>
            <div class="form-group">
                <label for="mdpAg">Mot de passe :</label>
                <input type="password" name="mdpAg" id="mdpAg" class="form-control" required="required">
            </div>
            <div class="form-group">
                <label for="confmdpAg">Confirmation mot de passe :</label>
                <input type="password" name="confmdpAg" id="confmdpAg" class="form-control" required="required">
            </div>
            <div class="form-group">
                <label for="adresse1Ag">Adresse :</label>
                <input type="text" name="adresse1Ag" id="adresse1Ag" class="form-control " required="required">
                <label for="adresse2Ag">Complément :</label>
                <input type="text" name="adresse2Ag" id="adresse2Ag" class="form-control">
                <label for="villeAg">Ville :</label>
                <input type="text" name="villeAg" id="villeAg" class="form-control" required="required">
                <div class="d-flex justify-content-between">
                    <div>
                        <label for="codePostAg">Code Postal :</label>
                        <input type="number" name="codePostAg" id="codePostAg" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="paysAg">Pays :</label>
                        <input type="text" name="paysAg" id="paysAg" class="form-control" required="required">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-dark">S'inscrire</button>
        </form>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-lg-1 mt-sm-5 mt-md-5">
            <h2 class="text-center mb-4">Vous êtes un client?</h2>
            <form method="post" action="ajoutClAg.php">
                <div class="d-flex justify-content-between">
                    <div class="form-group">
                        <label for="nomClient">Nom :</label>
                        <input type="text" name="nomClient" id="nomClient" class="form-control w-75" required="required">
                    </div>
                    <div class="form-group">
                        <label for="prenomClient">Prénom :</label>
                        <input type="text" name="prenomClient" id="prenomClient" class="form-control w-75" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="emailClient">Email :</label>
                    <input type="text" name="emailClient" id="emailClient" class="form-control" required="required">
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" name="mdp" id="mdp" class="form-control" required="required">
                </div>
                <div class="form-group">
                    <label for="confmdp">Confirmation mot de passe :</label>
                    <input type="password" name="confmdp" id="confmdp" class="form-control" required="required">
                </div>
                <div class="form-group">
                    <label for="cladresse1">Adresse :</label>
                    <input type="text" name="cladresse1" id="cladresse1" class="form-control " required="required">
                    <label for="cladresse2">Complément :</label>
                    <input type="text" name="cladresse2" id="cladresse2" class="form-control">
                    <label for="clville">Ville :</label>
                    <input type="text" name="clville" id="clville" class="form-control" required="required">
                    <div class="d-flex justify-content-between">
                        <div>
                            <label for="clcodePost">Code Postal :</label>
                            <input type="number" name="clcodePost" id="clcodePost" class="form-control" required="required">
                        </div>
                        <div>
                            <label for="clpays">Pays :</label>
                            <input type="text" name="clpays" id="clpays" class="form-control" required="required">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-dark justify-content-end">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php

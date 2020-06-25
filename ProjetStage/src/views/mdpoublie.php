<?php
require_once 'src/config/config.php';
require_once 'src/config/connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require'vendor/autoload.php';

$db=connect();

if(isset($_POST['mail']))
{
    $mail=htmlspecialchars(trim($_POST['mail']));

    //On vérifie que le compte existe
    $sqlSelCompte='SELECT * FROM users
                   WHERE mailUsers=:mail';

    $reqSelCompte=$db->prepare($sqlSelCompte);
    $reqSelCompte->bindParam(':mail',$mail);
    $reqSelCompte->execute();
    $tab_compte=array();
    while($data=$reqSelCompte->fetchObject())
    {
        array_push($tab_compte,$data);
    }
    if(empty($tab_compte))
    {
        echo'<div class="alert-warning p-2 text-center">Ce compte n\'existe pas.</div>';
    }
    else
    {
        //s'il existe on créer le mail pour init le mot de passe et on l'envoie à l'adresse du compte
        $_SESSION['mail']=$mail;
        $email= new PHPMailer(true);
        try {
            $email->SMTPDebug = 0;
            $email->isSMTP();
            $email->Host = 'smtp.gmail.com';
            $email->SMTPAuth = true;
            $email->Username = 'alohaha638@gmail.com';
            $email->Password = '*******';
            $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $email->Port = 587;

            $email->setFrom('ne-pas-repondre@paradiseCoffee.fr', 'Administrateur Paradise Coffee');
            $email->addAddress($mail);

            $email->isHTML(true);
            $email->Subject = 'Reinitialisation mot de passe';
            $email->Body = "Vous avez perdu votre mot de passe? Cliquer sur <a href=\"localhost/ProjetStage/initMotDePasse\">le lien </a> pour le réinitialiser";

            $email->send();
            echo '<div class="alert-success p-2 text-center">Un mail a été envoyé à l\'adresse du compte.</div>';
        }catch (Exception $e){
            echo'Le message n\a pas pu être envoyé. Erreur: '.$email->ErrorInfo;
        }
    }

}

?>
<div class="container">
    <h1 class="text-center titre mb-5">Demande pour Initialisation Mot de Passe</h1>
    <div class="arr_plan row mt-5 justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-10">
            <form method="post" action="motDePasse">
                <label for="mail">Adresse mail du compte :</label>
                <input type="email" name="mail" id="mail" class="form-control w-lg-50">

                <button type="submit" class="btn btn-marron mt-3">Récupération</button>
            </form>
        </div>

<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once 'src/config/config.php';
require_once 'src/models/connect.php';
require_once 'src/models/notco.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//load Composer's autoloader



$db=connect();


notconnected();

$sqlSelBien='SELECT idbien,titreBien FROM bien';
$reqSelBien=$db->prepare($sqlSelBien);
$reqSelBien->execute();
$list_bien=array();
while($data=$reqSelBien->fetchObject())
{
    array_push($list_bien,$data);
}

if(isset($_POST['ct_email']) && isset($_POST['typeA']) && isset($_POST['typeBien'])
    && isset($_POST['ville']) && isset($_POST['annonce']) && isset($_POST['ct_message'])) {

    $email=htmlspecialchars(trim($_POST['ct_email']));
    $ville=htmlspecialchars(trim($_POST['ville']));
    $message=htmlspecialchars(trim($_POST['ct_message']));
    $nom=htmlspecialchars(trim($_POST['nom']));
    $prenom=htmlspecialchars(trim($_POST['prenom']));
   /* $sqlInsCon = 'INSERT INTO contact (emailContact,typeAnnonceContact,typeBienContact,villechercheeContact,messageContact
                ,bien_idbien)
                VALUES (:mail,:typeA,:typeB,:ville,:message,:idB)';
    $reqInsCon = $db->prepare($sqlInsCon);
    $reqInsCon->bindParam(':mail', $email);
    $reqInsCon->bindParam(':typeA', $_POST['typeA']);
    $reqInsCon->bindParam(':typeB', $_POST['typeBien']);
    $reqInsCon->bindParam(':ville', $ville);
    $reqInsCon->bindParam(':message', $message);
    $reqInsCon->bindParam(':idB', $_POST['annonce']);
    $reqInsCon->execute();*/

   $mailing = 'Bonjour je recherche un(e) ' . $_POST['typeA'] . ' d\'un bien de type ' . $_POST['typeBien'] . ' dans le secteur de la ville de ' . $ville . ' .Pour plus d\'informations voici
    mon message :' . $message;

   $sqlSelB='SELECT titreBien FROM bien
                WHERE idbien=:id';
    $reqSelB=$db->prepare($sqlSelBien);
    $reqSelB->bindParam(':id',$_POST['annonce']);
    $reqSelB->execute();
    $data=$reqSelB->fetchObject();
    $titre=$data->titreBien;
   $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host         = 'smtp.gmail.com';
        $mail->SMTPAuth     = true;
        $mail->Username     = 'alohaha638@gmail.com';
        $mail->Password     = '*********';
        $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port         = 587;

        $mail->setFrom($email,'Renseignement pour: '.$titre);
        $mail->addAddress('alohaha638@gmail.com',$nom.' '.$prenom);

        $mail->isHTML(true);
        $mail->Subject  = 'Formulaire de contact :';
        $mail->Body     = $mailing;

        $mail->send();
        echo '<div class="alert-success p-2 text-center">Votre message a bien été envoyé</div>';

    }catch (Exception $e) { ?>
        <div class="alert-warning p-2 text-center">Le message n'a pas pu être envoyé. Le message d'erreur :<?php $mail->ErrorInfo ?></div>';
    <?php }
}
?>
<div class="container">
    <div class="row">
        <h1 class="mx-auto">Contact</h1>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6  col-lg-6  col-xl-6">
            <form class="mt-5" method="post" action="contact">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="nom">Nom :</label>
                        <input type="text" class="form-control" id="nom" name="nom" required="required">
                    </div><div class="form-group col-md-12">
                        <label for="prenom">Prénom :</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required="required">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="email">Email :</label>
                        <input type="email" class="form-control" id="email" name="ct_email" required="required">
                    </div>
                </div>
                <div class="d-flex justify-content-between">

                    <div class="form-group">
                        <label for="typeA"> Type d'Annonce recherchée :</label>
                        <select name="typeA" id="typeA" class="form-control">
                            <option value="Achat">Achat</option>
                            <option value="Location">Location</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="typeBien"> Type de bien :</label>
                        <select name="typeBien" id="typeBien" class="form-control">
                            <option value="Maison">Maison</option>
                            <option value="Appartement">Appartement</option>
                            <option value="Garage">Garage</option>
                            <option value="Commerce">Commerce</option>
                            <option value="Terrain">Terrain</option>
                        </select>
                    </div>
                </div>
                <div class="w-50">
                    <div class="form-group">
                        <label for="inputCity">Ville recherchée :</label>
                        <input type="text" class="form-control" id="inputCity" name="ville" required="required">
                    </div>
                </div>
                <div class="form-group">
                    <label for="Annonce"> Interessé par :</label>
                    <select name="annonce" id="Annonce" class="form-control">
                        <?php foreach ($list_bien as $bien)
                            { ?>
                                <option value="<?= $bien->idbien ?>"><?= $bien->titreBien ?></option>
                           <?php }?>
                    </select>
                </div>
                        <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputmess">Message :</label>
                        <textarea class="form-control" id="inputmess" name="ct_message" required="required"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-secondary">Envoyer</button>
            </form>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6  col-lg-6  col-xl-6 mt-5">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2542.0047114298313!2d2.79697982663707!3d50.42238385152657!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbf69594a43038fd6!2sAFPA!5e0!3m2!1sfr!2sfr!4v1587645874035!5m2!1sfr!2sfr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
    <?php


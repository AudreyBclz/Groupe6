<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require'../../vendor/autoload.php';
session_start();
head();

if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['mail']) && isset($_POST['message']))
{
    $email=htmlspecialchars(trim($_POST['mail']));
    $nom=htmlspecialchars(trim($_POST['nom']));
    $prenom=htmlspecialchars(trim($_POST['prenom']));
    $message=htmlspecialchars(trim($_POST['message']));
    $mailing=$message.' signé :'.$prenom.' '.$nom;

    $mail= new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'alohaha638@gmail.com';
        $mail->Password = '********';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, 'Contact ParadiseCoffee');
        $mail->addAddress('alohaha638@gmail.com', $nom . ' ' . $prenom);

        $mail->isHTML(true);
        $mail->Subject = 'Contact ParadiseCoffee';
        $mail->Body = $mailing;

        $mail->send();
        echo '<div class="alert-success p-2 text-center">Votre message a bien été envoyé</div>';

    }catch (Exception $e) {?>
        <div class="alert-warning p-2 text-center">Le message n'a pas pu être envoyé? Le message d'erreur: <?php $mail->ErrorInfo ?></div>';
    <?php }
}
?>
<div class="container arr_plan">
    <div class="row justify-content-center">
        <h1 class="text-center titre mb-5">Contact</h1>
    </div>
    <div class="row m-auto">
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 d-flex flex-column">
            <form method="post" action="contact.php" id="form_contact">
                <div class="row">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="nom" class="form-control"required="required"/>
                </div>
                <div class="row">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" class="form-control"required="required"/>
                </div>
                <div class="row">
                    <label for="mail">Mail :</label>
                    <input type="email" name="mail" id="mail" class="form-control"required="required"/>
                </div>
                <div class="row">
                    <label for="message">Message :</label>
                    <textarea id="message" name="message" class="form-control"required="required"></textarea>
                </div>
                <div class="row">
                    <button type="submit" class="btn btn-marron my-3" id="btn_contact">Envoyer</button>
                </div>
            </form>
        </div>
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
            <iframe  class="carte" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d8550.999309399303!2d2.7861483233733626!3d50.
                41823646721785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbf69594a43038fd6!2sAFPA!5e0!3m2!1sfr!2sfr
                !4v1588060907723!5m2!1sfr!2sfr" frameborder="0" ;" allowfullscreen=""
            aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
</div>
<?php
footer();

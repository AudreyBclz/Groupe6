<?php
require_once 'src/config/config.php';
require_once 'src/config/connect.php';

$db=connect();
// si la variable $_SESSION['mail'] n'existe pas c'est que la session n'existe pas donc pas d'envoi de mail immédiat donc retour à l'accueil
if (!isset($_SESSION['mail']))
{
    header('Location:accueil');
}
else
{
    if (isset($_POST['mdp']) && isset($_POST['conf_mdp']))
    {
        $mail=$_SESSION['mail'];
        $mdp_hash=password_hash(htmlspecialchars(trim($_POST['mdp'])),PASSWORD_BCRYPT);
        $mdp=htmlspecialchars(trim($_POST['mdp']));
        $conf_mdp=htmlspecialchars(trim($_POST['conf_mdp']));

            if ($mdp !== $conf_mdp)
            {
                echo '<div class="alert-warning p-2 text-center">Erreur lors de la confirmation du mot de passe</div>';
            } else {

                // récupération des données de l'utilisateur de l'adresse mail
                $sqlSelCompte = 'SELECT * FROM users
                            WHERE mailUsers=:mail';

                $reqSelCompte = $db->prepare($sqlSelCompte);
                $reqSelCompte->bindParam(':mail', $mail);
                $reqSelCompte->execute();
                $tab_compte = array();
                while ($data = $reqSelCompte->fetchObject()) {
                    array_push($tab_compte, $data);
                }
                if (password_verify($conf_mdp, $tab_compte[0]->passUsers)) {
                    echo '<div class="alert-warning p-2 text-center">Veuillez entrer un mot de passe différent de l\'ancien.</div>';
                } else {
                    $sqlUpMdp = 'UPDATE users SET
                                passUsers=:mdp
                                WHERE idUsers=:id';
                    $reqUpMdp = $db->prepare($sqlUpMdp);
                    $reqUpMdp->bindParam(':mdp', $mdp_hash);
                    $reqUpMdp->bindParam(':id', $tab_compte[0]->idUsers);
                    $reqUpMdp->execute();
                    echo '<div class="alert-success p-2 text-center">Votre mot de passe a bien été mis à jour</div>';
                    // on supprime la session et donc $_SESSION['mail']
                    session_destroy();

                }
            }
    }
}
?>
<div class="container">
    <h1 class="text-center titre mb-5">Initialisation Mot de Passe</h1>
    <div class="arr_plan row mt-5 justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-10">
            <form method="post" action="initMotDePasse">
                <label for="mdp">Nouveau mot de passe * :</label>
                <input type="password" name="mdp" id="mdp" class="form-control">
                <label for="conf_mdp">Confirmation mot de passe :</label>
                <input type="password" name="conf_mdp" id="conf_mdp" class="form-control">
                <small id="passhelp"> *8 caractères minimum et au moins une majuscule</small>
                <div>
                    <button type="submit" class="btn btn-marron mt-3" id="modif_mdp">Récupération</button>
                </div>
            </form>
        </div>

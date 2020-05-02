<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
head();
?>
<div class="container mx-auto">
    <div class="arr_plan row justify-content-center">
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 d-flex flex-column">
            <h1 class="text-center titre">Inscription</h1>
            <form method="post" action="connexion.php" class="m-1" id="form_inscription">
                <div class="row justify-content-between">
                    <label for="nom" class="label">Nom :</label>
                    <label for="prenom" class="label">Prénom :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="text" name="nom" id="nom" class="form-control w-45" required="required"/>
                    <input type="text" name="prenom" id="prenom" class="form-control w-45" required="required"/>
                </div>
                <div class="row justify-content-between">
                    <label for="email" class="label">Email :</label>
                    <label for="mdp" class="label">Mot de passe * :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="email" name="email" id="email" class="form-control w-45 " required="required">
                    <input type="password" name="mdp" id="mdp" class="form-control w-45" required="required" aria-describedby="passhelp">
                </div>
                <div class="row justify-content-between">
                    <label for="conf_email" class="label">Confirmer mail :</label>
                    <label for="conf_mdp" class="label">Confirmer mot de passe :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="email" name="conf_email" id="conf_email" class="form-control w-45 " required="required">
                    <input type="password" name="conf_mdp" id="conf_mdp" class="form-control w-45" required="required">
                </div>
                <div class="row justify-content-between">
                    <label for="adresse" class="label">Adresse :</label>
                    <label for="complement" class="label">Complément :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="text" name="adresse" id="adresse" class="form-control w-45" required="required">
                    <input type="text" name="complement" id="complement" class="form-control w-45" required="required">
                </div>
                <div class="row justify-content-between">
                    <label for="codePost" class="label">Code Postal :</label>
                    <label for="ville" class="label">Ville :</label>
                </div>
                <div class="row justify-content-between">
                    <input type="number" name="codePost" id="codePost" class="form-control w-30" required="required">
                    <input type="text" name="ville" id="ville" class="form-control w-45" required="required">
                </div>
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
                <img src="../../public/img/tasseCafe.png" id="logo">
            </div>
        </div>
    </div>
    <?php
footer();

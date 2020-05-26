<?php

require_once 'src/models/notconnect.php';
notco();

if (!isset($_POST['panier']))
{
    header('Location:accueil');
}
?>
<div class="container">
    <div class="arr_plan justify-content-center">
        <h1 class="text-center titre">Adresse</h1>
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex flex-column justify-content-between m-1">
                <div>
                    Adresse de Facturation: Celle du compte
                </div>
                <div class="d-flex flex-column mb-5">
                    <img src="public/img/camion.png" class="w-30"/>
                    <img src="public/img/Colissimo.png" class="w-30">
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 m-1">
                <form method="post" action="recapitulatif" id="form_ad">
                    <input type="text" name="add_adresse" value="ok" class="d-none">
                    <div class="row custom-control custom-checkbox mb-3">
                        <input type="checkbox" name="same" id="livraison" value="same" class="custom-control-input"/>
                        <label for="livraison" class="custom-control-label">Adresse de Livraison identique à celle de facturation</label>
                    </div>
                    <div id="ad_paiement">
                        <div class="row justify-content-between">
                            <label for="nom" class="label">Nom :</label>
                            <label for="prenom" class="label">Prénom :</label>
                        </div>
                        <div class="row justify-content-between">
                            <input type="text" name="nom" id="nom" class="form-control w-45">
                            <input type="text" name="prenom" id="prenom" class="form-control w-45"/>
                        </div>
                        <div class="row">
                            <label for="adresse">Adresse :</label>
                            <input type="text" name="adresse" id="adresse" class="form-control" />
                        </div>
                        <div class="row">
                            <label for="complement">Complément :</label>
                            <input type="text" name="complement" id="complement" class="form-control"/>
                        </div>
                        <div class="row justify-content-between">
                            <label for="cp" class="label">Code Postal :</label>
                            <label for="ville" class="label">Ville :</label>
                        </div>
                        <div class="row justify-content-between">
                            <input type="text" name="codePost" id="cp" class="form-control w-30" />
                            <input type="text" name="ville" id="ville" class="form-control w-45" />
                        </div>
                        <div class="row">
                            <label for="pays">Pays :</label>
                        </div>
                        <div class="row">
                            <input type="text" name="pays" id="pays" class="form-control w-45"/>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <button type="submit" class="btn btn-marron mt-3" id="suivant">Suivant</button>
                        <a href="selection" class="btn btn-marron mt-3">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

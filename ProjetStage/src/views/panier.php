<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
head();
?>
<div class="container">
    <div class="arr_plan justify-content-center">
        <h1 class="text-center titre"><img src="../../public/img/panier.png">Mon panier<img src="../../public/img/panier.png"></h1>
        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 m-auto">
                <table class="table">
                    <thead class= "bg-marron">
                    <tr class="text-light">
                        <th scope="col">Nom du produit</th>
                        <th scope="col" class="w-30">Quantité</th>
                        <th scope="col">Action</th>
                        <th scope="col">Prix</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-wheat">
                        <td scope="col">Arabica</td>
                        <td scope="col"><form method="post" action="adresse_paiement.php"><input type="number" style="border: 0" value="1" maxlength="3" class="w-30 bg-wheat"></td>
                        <td scope="col"><img src="../../public/img/poubelle.png"></td>
                        <td scope="col">8€</td>
                    </tr>
                    <tr class="bg-wheat">
                        <td scope="col">Robusta</td>
                        <td scope="col"><input type="number" value="1" style="border: 0" maxlength="3" class="w-30 bg-wheat"></td>
                        <td scope="col"><img src="../../public/img/poubelle.png"></td>
                        <td scope="col">9€</td>

                    </tr>
                    <tr class="bg-wheat">
                        <td scope="col">Echantillon</td>
                        <td scope="col"><input type="number" value="1" style="border: 0" maxlength="3" class="w-30 bg-wheat"></td>
                        <td scope="col"><img src="../../public/img/poubelle.png"></td>
                        <td scope="col">0€</td>

                    </tr>
                    <tr class="bg-wheat">
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col">Total :</th>
                        <th scope="col">17€</th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex flex-column justify-content-between">
                <div class=" d-flex justify-content-between">
                    <button type="button" class="btn btn-marron">Annuler</button>
                    <button type="submit" class="btn btn-marron">Payer</button>
                </div>
                <div class="mt-3">
                    Statut: Non connecté, cliquer <a href="connexion.php" class=" btn-sm btn-marron">Ici</a>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
footer();

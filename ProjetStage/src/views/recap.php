<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
head();
?>
<div class="container arr_plan mx-auto">
    <h1 class="text-center titre">Récapitulatif de la commande</h1>
    <div class=" row justify-content-center">
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 d-flex flex-column">

            <table class="table">
                <thead class= "bg-marron">
                <tr class="text-light">
                    <th scope="col">Nom du produit</th>
                    <th scope="col" class="w-30">Quantité</th>
                    <th scope="col">Prix</th>
                </tr>
                </thead>
                <tbody>
                <tr class="bg-wheat">
                    <td scope="col">Arabica</td>
                    <td scope="col"><form method="post" action="paiement.php"><input type="number" value="1" style="border: 0" maxlength="3" class="w-30 bg-wheat" readonly="readonly"></td>
                    <td scope="col">8€</td>
                </tr>
                <tr class="bg-wheat">
                    <td scope="col">Robusta</td>
                    <td scope="col"><input type="number" value="1" style="border: 0" maxlength="3" class="w-30 bg-wheat" readonly="readonly"></td>
                    <td scope="col">9€</td>

                </tr>
                <tr class="bg-wheat">
                    <td scope="col">Echantillon</td>
                    <td scope="col"><input type="number" value="1" style="border: 0" maxlength="3" class="w-30 bg-wheat" readonly="readonly"></td>
                    <td scope="col">0€</td>
                <tfoot>
                <tr class="bg-wheat">
                    <th scope="col">Total :</th>
                    <th scope="col">3</th>
                    <th scope="col">17€</th>
                </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 d-flex justify-content-between">
            <div>
                <span class="font-weight-bold">Adresse de Facturation :</span><br/>
                Mr Dupont Jean <br/>
                58 rue des Lilas <br/>
                57000 Metz<br/>
            </div>
            <div>
                <span class="font-weight-bold">Adresse de Livraison:</span><br/>
                Mme Dupont Aurélie <br/>
                67 rue des Joncquilles<br/>
                13000 Marseille<br/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-5=7 col-lg-7 col-md-12 col-sm-12 d-flex justify-content-between">
            <button type="submit" class="btn btn-marron">Confirmer</button>
            <button type="button" class="btn btn-marron">Annuler</button>
        </div>
    </div>
    <div class="row justify-content-center">
        <img src="../../public/img/ter_paiement.png" class="w-50">
    </div>

</div>
<?php
footer();

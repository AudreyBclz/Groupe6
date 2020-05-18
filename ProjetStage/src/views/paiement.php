<?php

require_once 'src/models/notconnect.php';

notco();
?>
<div class="container m-auto">
    <div class="arr_plan">
        <h1 class="text-center titre">Paiement</h1>
        <form method="post" action="confirmation">
            <div class="row justify-content-between">
                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12  align-items-center">
                    <div class="d-flex flex-column">
                        <div>
                            <div class="m-auto">
                                <label for="paypal" class="label"><img src="public/img/paypal.png" class="w-75"></label>
                                <input type="radio" name="paiement" value="paypal" id="paypal"/>
                            </div>
                        </div>
                        <div>
                            <div class="">
                                <label for="cb" class="w-30 label"><img src="public/img/cb.jpg" class="w-50"></label>
                                <input type="radio" name="paiement" value="carte" id="cb" checked="checked" class="ml-15"/>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-marron my-3 d-none" id="bouton_paypal">Payer</button>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
                    <div>
                        <img src="public/img/cb.jpg" class="w-10"/><img src="public/img/MasterCard.png" class="w-10"/><img src="public/img/visa.png" class="w-10"/>
                        <img src="public/img/american-express.png" class="w-10"/>
                    </div>
                    <div id="coord_bancaire">
                        <label for="numero">Numéro de Carte :</label>
                        <input type="text" name="numero" id="numero" class="form-control w-75"/>
                        <label for="crypto">Cryptogramme :</label>
                        <input type="number" name="crypto" id="crypto" class="form-control w-25"/>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-marron mt-3" id="bouton_cb">Payer</button>
                    </div>
                </div>
        </form>
    </div>
    <div class="text-center" id="gr_cafe">
        <img src="public/img/graincafe.png" class="w-50"/>
    </div>
</div>
</div>
</div>


<?php
use App\Models\Panier;
require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/notconnect.php';

notco();

$db=connect();

$panier=new Panier($db);

$url=explode('action=',$_SERVER['REQUEST_URI']);
if (isset($url[1]))
{
    // si url[1] existe cela veut dire que l'on veut supprimer et donc on récupère l'id et on Delete du panier
    $url2=explode('?id=',$url[1]);
    if (isset($url2[1]))
    {
        $id=$url2[1];
        $action=$url2[0];
        $panier->setCafeIdcafe($id);
        $panier->delete_article();
    }
}


$nbArticle=$panier->nb_article();
$panier->update_panier_page_panier($nbArticle);
$tab_pan=$panier->aff_panier();
$pxtotal = 0;
$i = 0;


        ?>
        <div class="container">
            <div class="arr_plan justify-content-center">
                <h1 class="text-center titre"><img src="public/img/panier.png">Mon panier<img
                        src="public/img/panier.png"></h1>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 m-auto">
                        <table class="table">
                            <thead class="bg-marron">
                            <tr class="text-light">
                                <th scope="col">Nom du produit</th>
                                <th scope="col" class="w-30">Quantité *</th>
                                <th scope="col">Action</th>
                                <th scope="col">Prix</th>
                            </tr>
                            </thead>
                            <tbody>
                            <form method="post" action="monpanier" id="form_panier">
                            <?php if (empty($tab_pan)) { ?>
                                <tr>
                                    <td colspan="4">Votre panier est vide</td>
                                </tr>
                            <?php } else {
                                foreach ($tab_pan as $article) {
                                    $total = $article->prixCafe * $article->quantite;
                                    $pxtotal = $pxtotal + $total;
                                    $i = $i + 1;
                                    ?>
                                    <tr class="bg-wheat">
                                        <td scope="col"><a class="text-dark" href="detail?id=<?= $article->idcafe ?>"><?= $article->nomCafe ?></a></td>
                                        <td scope="col">
                                                <input type="number" name="id_<?= $i ?>" value="<?= $article->idcafe ?>"
                                                       class="d-none">
                                                <input type="number" name="quantite_<?= $i ?>" style="border: 0"
                                                       value="<?= intval($article->quantite) ?>" maxlength="3"
                                                       class="w-30 quantite text-center rounded">
                                        </td>
                                        <td scope="col"><a href="monpanier?action=delete?id=<?= $article->idcafe ?>"><img src="public/img/poubelle.png"></a></td>
                                        <td scope="col"><?= $total ?>€</td>
                                    </tr>
                                <?php } ?>
                                <tr class="bg-wheat">
                                    <th colspan="2"></th>
                                    <th scope="col">Total :</th>
                                    <th scope="col"><?= $pxtotal ?>€</th>
                                </tr>
                            <?php } ?>

                            </tbody>
                        </table>
                    </form>
                        <div>
                            <small class="font-italic">*(modifiable)</small>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex flex-column justify-content-between">
                        <div class=" d-flex justify-content-between">
                            <a href="selection" class="btn btn-marron">Poursuivre mes achats</a>
                            <form method="post" action="livraison">
                                <input type="text" name="panier" value="ok" class="d-none">
                                <button type="submit" class="btn btn-marron <?php if(empty($tab_pan)){echo'd-none';} ?>">Commander</button>
                            </form>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


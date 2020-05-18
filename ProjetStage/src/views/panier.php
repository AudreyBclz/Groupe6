<?php

require_once 'src/config/config.php';
require_once 'src/models/connect.php';

$db=connect();


$url=explode('action=',$_SERVER['REQUEST_URI']);
if (isset($url[1]))
{
   $url2=explode('?id=',$url[1]);
   if (isset($url2[1]))
   {
       $id=$url2[1];
       $action=$url2[0];
       $sqlDel='DELETE FROM panier
                WHERE cafe_idcafe='.$id;
       $reqDel=$db->prepare($sqlDel);
       $reqDel->execute();
       echo '<div class="alert-danger p-2 text-center">Produit supprimé</div>';
   }
}

if ((!(isset($_SESSION['nom']) && isset($_SESSION['prenom']) && isset($_SESSION['iduser']) && isset($_SESSION['role']))))
{
    echo '<p class="row justify-content-center align-items-center mt-5"> Vous devez être connecté pour voir votre panier :
            <a href="connexion&ins" class="btn btn-marron">Connexion</a></p>';
}
else {
    $cpteArticle = 'SELECT COUNT(*) as nbarticle FROM panier
                  WHERE users_idUsers=:id';
    $reqcpteArticle = $db->prepare($cpteArticle);
    $reqcpteArticle->bindParam(':id', $_SESSION['iduser']);
    $reqcpteArticle->execute();
    $tab_compte = array();
    while ($data = $reqcpteArticle->fetchObject()) {
        array_push($tab_compte, $data);
    }
    $nbArticle = intval($tab_compte[0]->nbarticle);

    for ($ind=1; $ind<=$nbArticle; $ind++) {
        if (isset($_POST['quantite_' . $ind])) {
            $sqlUpPan = 'UPDATE panier SET
                       quantite=:qte
                       WHERE users_idUsers=:id
                       AND cafe_idcafe=:id_c';
            $reqUpPan = $db->prepare($sqlUpPan);
            $reqUpPan->bindParam(':qte', $_POST['quantite_' . $ind]);
            $reqUpPan->bindParam(':id', $_SESSION['iduser']);
            $reqUpPan->bindParam('id_c', $_POST['id_' . $ind]);
            $reqUpPan->execute();

        }

        }
    $sqlSelPan = 'SELECT * FROM panier
                            INNER JOIN cafe ON cafe_idcafe=idcafe
                            WHERE users_idUsers =:id';
    $reqSelPan = $db->prepare($sqlSelPan);
    $reqSelPan->bindParam(':id', $_SESSION['iduser']);
    $reqSelPan->execute();
    $tab_pan = array();
    $pxtotal = 0;
    $i = 0;
    while ($data = $reqSelPan->fetchObject()) {
        array_push($tab_pan, $data);
    }

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
                                <th scope="col" class="w-30">Quantité</th>
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
                                        <td scope="col"><?= $article->nomCafe ?></td>
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
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-flex flex-column justify-content-between">
                        <div class=" d-flex justify-content-between">
                            <a href="selection" class="btn btn-marron">Poursuivre mes achats</a>
                            <a href="livraison" class="btn btn-marron <?php if(empty($tab_pan)){echo'd-none';} ?>">Commander</a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php } ?>
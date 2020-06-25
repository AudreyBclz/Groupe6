<?php

require_once '../views/elements/head.php';
require_once '../views/elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

head();

$db = connect();

/*if(!isset($_GET['id']) || !isset($_GET['action']))
{
    header('Location:../../products.php');
}*/

if ($_GET['action']=="delete")
{
    $sqlDel='DELETE FROM products
             WHERE id='.$_GET['id'];
    $reqDel=$db->prepare($sqlDel);
    $reqDel->execute();
    header('Location:../../products.php?delete=done');
}

elseif($_GET['action']=="modify") {
    $prod = array();
    $sqlSel = 'SELECT products.id,products.name, products.description,products.price, categories.name AS catName
             FROM products
             INNER JOIN categories ON products.category_id=categories.id
             WHERE products.id=' . $_GET['id'];
    $reqSel = $db->prepare($sqlSel);
    $reqSel->execute();

    while ($data = $reqSel->fetchObject()) {
        array_push($prod, $data);
    }
    ?>

    <h2 class="text-center"> Modification</h2>
    <div class="text-center"><a href="../../products.php" class="btn btn-dark mt-5"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retour à la liste</a></div>
    <form method="post" action="modify.php" class="mx-auto w-25">
        <?php
        foreach ($prod as $product) {
            ?>
            <label for="id_m">ID :</label>
            <input type="text" value="<?= $product->id ?>" name="id_m" id="id_m" readonly="readonly"
                   class="form-control"/>
            <label for="name_modif">Name :</label>
            <input type="text" value="<?= $product->name ?>" name="name_modif" id="name_modif" class="form-control"/>
            <label for="desc_modif">Description :</label>
            <input type="text" value="<?= $product->description ?>" name="desc_modif" id="desc_modif"
                   class="form-control"/>
            <label for="cat_modif">Catégorie</label>
            <input type="text" value="<?= $product->catName ?>" name="cat_modif" id="cat_modif" class="form-control"/>
            <label for="price_modif">Price</label>
            <input type="text" value="<?= $product->price ?>" name="price_modif" id="price_modif" class="form-control"/>
            <?php
        }
        ?>
        <button type="submit" class="btn btn-primary mt-3"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier
        </button>
    </form>

    <?php
}elseif($_GET['action']=='read') {
    $produit = array();
    $sqlSelProd = 'SELECT   products.id,
                        products.name AS prodName,
                        products.description,
                        products.price,
                        categories.name AS catName,
                        DATE_FORMAT(products.created,\'%d/%m/%Y à %Hh %imin %ss\') AS date_crea,
                        DATE_FORMAT(products.modified,\'%d/%m/%Y à %Hh %imin %ss\') AS date_modif,
                        products.modified

                 FROM products
                 INNER JOIN categories ON products.category_id=categories.id
                 WHERE products.id=' . $_GET['id'];
    $reqSelProd = $db->prepare($sqlSelProd);
    $reqSelProd->execute();
    while ($data = $reqSelProd->fetchObject()) {
        array_push($produit, $data);
    }

    ?>
    <div class="container">
        <h2>Product</h2>

        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Category</th>
                <th scope="col">Created</th>
                <th scope="col">Modified</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($produit as $aProduct) { ?>
                <tr>
                    <th scope="row"><?= $aProduct->id ?></th>
                    <td><?= $aProduct->prodName ?></td>
                    <td><?= $aProduct->description ?></td>
                    <td><?= $aProduct->price ?></td>
                    <td><?= $aProduct->catName ?></td>
                    <td><?= $aProduct->date_crea ?></td>
                    <td><?= $aProduct->date_modif ?></td>
                </tr>
                <?php
            } ?>
            </tbody>
        </table>
        <div class="text-center"><a href="../../products.php" class="btn btn-dark mt-5"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retour à la liste</a></div>
    </div>
    <?php
}
footer();
?>

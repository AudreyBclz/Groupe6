<?php
require_once 'src/views/elements/head.php';
require_once 'src/views/elements/footer.php';
require_once 'src/config/config.php';
require_once 'src/models/connect.php';

head();

$db=connect();

// voir si on a supprimé un produit
$url=explode('?delete=',$_SERVER['REQUEST_URI']);
if (isset($url[1]) && $url[1]=='done')
{ ?>
    <div class="alert-danger p-5 text-center">Produit supprimé</div>';
<?php
}

// voir si on a modifié un produit
$url_m=explode('?modify=',$_SERVER['REQUEST_URI']);
if (isset($url_m[1]) && $url_m[1]=='done')
{ ?>
    <div class="alert-success p-5 text-center">Modification effectuée avec succès</div>
<?php
}


$sqlSel='SELECT products.id,products.name,products.price, categories.name AS catName
         FROM products
         INNER JOIN categories ON products.category_id= categories.id';
$reqSel=$db->prepare($sqlSel);
$reqSel->execute();
$listProducts=array();
while($data=$reqSel->fetchObject())
{
    array_push($listProducts,$data);
}

?>

<div class="container">
	<h2>Products</h2>

	<table class="table table-hover">
		<thead class="thead-dark">
		<tr>
			<th scope="col">#</th>
			<th scope="col">Name</th>
			<th scope="col">Price</th>
			<th scope="col">Category</th>
			<th scope="col">Actions</th>
		</tr>
		</thead>
		<tbody>
			<?php foreach ($listProducts as $product)
            { ?>
            <tr>
                <th scope="row"><?= $product->id ?></th>
                <td><?= $product->name ?></td>
                <td><?= $product->price ?></td>
                <td><?= $product->catName ?></td>
                <td class="m-0">
                    <div class="d-flex">
                        <form method="get" action="src/views/action.php" class="form-inline">
                            <input type="number" value="<?= $product->id ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="read" name="action" class="d-none"/>
                            <button class="btn btn-primary mr-1" type="submit"><i class="fa fa-bars" aria-hidden="true"></i> Lire</button>
                        </form>
                        <form method="get" action="src/views/action.php" class="form-inline">
                            <input type="number" value="<?= $product->id ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="modify" name="action" class="d-none"/>
                            <button class="btn btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                        </form>
                        <form method="get" action="src/views/action.php" class="form-inline" >
                            <input type="number" value="<?= $product->id ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="delete" name="action" class="d-none"/>
                            <button class="btn btn-danger mr-1" type="submit"><i class="fa fa-minus-square" aria-hidden="true"></i> Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php
            }?>

		</tbody>
	</table>
</div>

<?php footer(); ?>

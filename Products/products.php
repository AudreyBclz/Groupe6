<?php
require_once 'src/views/elements/head.php';
require_once 'src/views/elements/footer.php';
require_once 'src/config/config.php';
require_once 'src/models/connect.php';

head();

$db=connect();
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
                <td>
                    <div class="inline-flex">
                        <form method="get" action="src/views/action.php" class="form-inline">
                            <input type="number" value="<?= $product->id ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="read" name="action" class="d-none"/>
                            <button class="btn btn-primary" type="submit"><i class="fa fa-bars" aria-hidden="true"></i> Lire</button>
                        </form>
                        <form method="get" action="src/views/action.php" class="form-inline">
                            <input type="number" value="<?= $product->id ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="modify" name="action" class="d-none"/>
                            <button class="btn btn-warning" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                        </form>
                        <form method="get" action="src/views/action.php" class="form-inline" >
                            <input type="number" value="<?= $product->id ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="delete" name="action" class="d-none"/>
                            <button class="btn btn-danger" type="submit"><i class="fa fa-minus-square" aria-hidden="true"></i> Supprimer</button>
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

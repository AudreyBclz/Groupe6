<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once 'src/config/config.php';
require_once 'src/models/connect.php';
require_once 'src/models/notco.php';


notconnected();

$db=connect();
$sqlSelBien='SELECT * 
            FROM bien
            INNER JOIN adresse ON adresse_idadresse=idadresse';
$reqSelBien=$db->prepare($sqlSelBien);
$reqSelBien->execute();
$list_bien=array();
while($data=$reqSelBien->fetchObject())
{
    array_push($list_bien,$data);
}
$url=explode('?delete=',$_SERVER['REQUEST_URI']);
if (isset($url[1]) && $url[1]=='done')
{ ?>
    <div class="alert-danger p-2 text-center">Produit supprimé</div>
<?php
}

$url_m=explode('?modify=',$_SERVER['REQUEST_URI']);
if (isset($url_m[1]) && $url_m[1]=='done')
{ ?>
    <div class="alert-success p-2 text-center">Modification effectuée avec succès</div>
<?php
}
?>


<div class="container">

    <div class="row">
        <h1 class="mx-auto mb-3">Gestion des biens immobiliers </h1>
    </div>


    <div class="card-group">
        <div class="row row-cols-1 row-cols-md-1 row-cols-lg-3 row-cols-xl-3">

        <?php
        foreach ($list_bien as $bien)
        {
            if($bien->typeAnnonce == "Achat")
            {
                $prefix_prix=' € net vendeur';
            }else
            {
                $prefix_prix=' € / mois';
            }
            ?>

            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="<?php __DIR__; ?>public/img/<?= $bien->imageBien ?>" alt="Card image cap">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="font-weight-bold bg-dark p-1 rounded text-light"><?= $bien->typeAnnonce ?></p>
                            <p class=" font-weight-bold"><?= $bien->ville ?></p>
                        </div>
                        <h5 class="card-title"><?= $bien->titreBien ?></h5>
                        <p class="card-text"><?= $bien->resumeBien ?></p>
                        <div class="d-flex justify-content-between">
                            <form method="get" action="gestion" class="form-inline">
                                <input type="number" value="<?= $bien->idbien ?>" name="id" readonly="readonly" class="d-none"/>
                                <input type="text" value="read" name="action" class="d-none"/>
                                <input type="text" value="gererMesBiens" name="page" class="d-none"/>
                                <button class="btn btn-outline-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                            </form>
                            <form method="get" action="gestion" class="form-inline">
                                <input type="number" value="<?= $bien->idbien ?>" name="id" readonly="readonly" class="d-none"/>
                                <input type="text" value="modify" name="action" class="d-none"/>
                                <button class="btn btn-outline-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                            </form>
                            <form method="get" action="gestion" class="form-inline" >
                                <input type="number" value="<?= $bien->idbien ?>" name="id" readonly="readonly" class="d-none"/>
                                <input type="text" value="delete" name="action" class="d-none"/>
                                <button class="btn btn-outline-danger" type="submit"><i class="fa fa-minus-square" aria-hidden="true"></i> Supprimer</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h6><?=$bien->prixBien ?><?= $prefix_prix ?></h6>
                    </div>
                </div>
            </div>
<?php }
        ?>
    </div>
    </div>
    <?php



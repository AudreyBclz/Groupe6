<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once 'src/config/config.php';
require_once 'src/models/connect.php';
require_once 'src/models/notco.php';


$db=connect();

notconnected();

$url=explode('indice=',$_SERVER['REQUEST_URI']);
if (isset($url[1]))
{
    $indice=intval($url[1]);
}
else
{
    $indice=0;
}

$sqlSelBien='SELECT * 
            FROM bien 
            INNER JOIN adresse ON adresse_idadresse=idadresse
            LIMIT '.$indice.',3';
$reqSelBien=$db->prepare($sqlSelBien);
$reqSelBien->execute();
$list_bien=array();
while($data=$reqSelBien->fetchObject())
{
    array_push($list_bien,$data);
}
?>

<div class="container">
    <div class="row">
        <h1 class="mx-auto mb-3">Sélections des biens immobiliers </h1>
    </div>


    <div class="card-group">
<?php

$sqlcpte='SELECT COUNT(*)  AS nbBien FROM Bien';
$reqcpte=$db->prepare($sqlcpte);
$reqcpte->execute();
$cpte=array();
while ($data=$reqcpte->fetchObject())
{
    array_push($cpte,$data);
}
foreach ($cpte as $nb)
{
    $nbre=$nb->nbBien;
}
$nbPage=ceil($nbre/3);
?>
        <div class="card-deck mx-2">
        <div class="d-flex">
            <div class="row">

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

                <div class="col-sm-12 col-xl-4 col-lg-3 col-md-3">
    <div class="card h-100">
        <img class="card-img-top" src="<?php  __DIR__  ?>public/img/<?= $bien->imageBien ?>" alt="Annonce">
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
                    <input type="text" value="location" name="page" class="d-none"/>
                    <input type="number" value="<?= $indice ?>" name="indice" class="d-none"/>
                    <button class="btn btn-outline-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
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
        </div>
        <div class="mx-auto mt-3">
        <nav aria-label="...">
            <ul class="pagination pagination-sm">
                <li class="page-item active" aria-current="page">

                </li>
                <?php
                for ($i=1; $i<=$nbPage;$i++)
                { ?>
                <li class="page-item"><a class="page-link" href="<?= $router->generate('annonces') ?>?indice=<?= ($i-1)*3 ?>"><?= $i ?></a></li>
               <?php
               } ?>
            </ul>
        </nav>
        </div>
        <?php
?>



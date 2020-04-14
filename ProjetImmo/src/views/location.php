<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

head();
$db=connect();

$db=connect();

$url=explode('indice=',$_SERVER['REQUEST_URI']);
if (isset($url[1]))
{
    $indice=intval($url[1]);
}
else
{
    $indice=0;
}

$sqlSelLoc='SELECT * 
            FROM location LIMIT '.$indice.',3';
$reqSelLoc=$db->prepare($sqlSelLoc);
$reqSelLoc->execute();
$loc=array();
while($data=$reqSelLoc->fetchObject())
{
    array_push($loc,$data);
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="../../index.php">DamienLocation</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="../../index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="location.php">Location</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact.php">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ajoutbien.php">Ajout de bien</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="ajoutClAg.php">Ajout Client/Agence</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gererMesBiens.php">Gestion biens</a>
            </li>
        </ul>
    </div>
</nav>
    <div class="container">

    <div class="row">
        <h1 class="mx-auto mb-3">Sélections des biens immobiliers </h1>
    </div>


    <div class="card-group">
<?php

$sqlcpte='SELECT COUNT(*)  AS nbLoc FROM location';
$reqcpte=$db->prepare($sqlcpte);
$reqcpte->execute();
$cpte=array();
while ($data=$reqcpte->fetchObject())
{
    array_push($cpte,$data);
}
foreach ($cpte as $nb)
{
    $nbre=$nb->nbLoc;
}
$nbPage=ceil($nbre/3);
?>
        <div class="card-deck">
        <div class="d-flex">
            <div class="row">

            <?php
foreach ($loc as $location)
{ ?>

                <div class="col-sm-12 col-xl-4 col-lg-4 col-md-4">
    <div class="card h-100">
        <img class="card-img-top" src="../../public/img/<?= $location->imageLocation ?>" alt="Annonce">
        <div class="card-body">
            <h5 class="card-title"><?= $location->titreLocation ?></h5>
            <p class="card-text"><?= $location->resumeLocation ?></p>
            <div class="d-flex justify-content-between">
                <form method="get" action="action.php" class="form-inline">
                    <input type="number" value="<?= $location->idlocation ?>" name="id" readonly="readonly" class="d-none"/>
                    <input type="text" value="read" name="action" class="d-none"/>
                    <button class="btn btn-outline-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                </form>
            </div>
        </div>
        <div class="card-footer">
            <h6><?=$location->prixLocation ?> € net vendeur</h6>
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
                <li class="page-item"><a class="page-link" href="location.php?indice=<?= ($i-1)*3 ?>"><?= $i ?></a></li>
               <?php
               } ?>
            </ul>
        </nav>
        </div>
        <?php
footer();
?>



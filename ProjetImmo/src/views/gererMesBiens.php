<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

head();
$db=connect();
$sqlSelLoc='SELECT * 
            FROM location';
$reqSelLoc=$db->prepare($sqlSelLoc);
$reqSelLoc->execute();
$loc=array();
while($data=$reqSelLoc->fetchObject())
{
    array_push($loc,$data);
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
    <div class="alert-success p-5 text-center">Modification effectuée avec succès</div>
<?php
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
            <li class="nav-item">
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
            <li class="nav-item active">
                <a class="nav-link" href="gererMesBiens.php">Gestion biens</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">

    <div class="row">
        <h1 class="mx-auto mb-3">Gestion des biens immobiliers </h1>
    </div>


    <div class="card-group">
        <?php
        foreach ($loc as $location)
        { ?>
        <div class="card">
            <img class="card-img-top mw-25" src="../../public/img/<?= $location->imageLocation ?>" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title"><?= $location->titreLocation ?></h5>
                <p class="card-text"><?= $location->resumeLocation ?></p>
              <div class="d-flex justify-content-between">
                        <form method="get" action="action.php" class="form-inline">
                            <input type="number" value="<?= $location->idlocation ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="read" name="action" class="d-none"/>
                            <button class="btn btn-outline-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                        </form>
                        <form method="get" action="action.php" class="form-inline">
                            <input type="number" value="<?= $location->idlocation ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="modify" name="action" class="d-none"/>
                            <button class="btn btn-outline-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                        </form>
                        <form method="get" action="action.php" class="form-inline" >
                            <input type="number" value="<?= $location->idlocation ?>" name="id" readonly="readonly" class="d-none"/>
                            <input type="text" value="delete" name="action" class="d-none"/>
                            <button class="btn btn-outline-danger mr-1" type="submit"><i class="fa fa-minus-square" aria-hidden="true"></i> Supprimer</button>
                        </form>
                    </div>
            </div>
            <div class="card-footer">
                <h6><?=$location->prixLocation ?> € net vendeur</h6>
            </div>
        </div>
<?php }
        ?>
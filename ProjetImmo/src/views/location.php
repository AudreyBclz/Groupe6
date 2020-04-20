<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';
require_once '../models/notco.php';

head();
$db=connect();

session_start();
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
                <a class="nav-link" href="ajoutClAg.php">Ajout Client/Agence</a>
            </li>

           <?php
           if(isset($_SESSION['agence']) && isset($_SESSION['client'])) {
               if ($_SESSION['agence'] || $_SESSION['client']) { ?>
                   <li class="nav-item active">
                       <a class="nav-link" href="location.php">Location</a>
                   </li>
                   <li class="nav-item">
                       <a class="nav-link" href="contact.php">Contact</a>
                   </li>
                   <?php if ($_SESSION['agence']) { ?>
                       <li class="nav-item">
                           <a class="nav-link" href="ajoutbien.php">Ajout de bien</a>
                       </li>
                   <?php }

                   if ($_SESSION['agence']) { ?>
                       <li class="nav-item">
                           <a class="nav-link" href="gererMesBiens.php">Gestion biens</a>
                       </li>
                   <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="../models/deconnect.php">Déconnexion</a>
                </li>
               <?php }
           }?>
        </ul>
    </div>
</nav>
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
        <div class="card-deck">
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

                <div class="col-sm-12 col-xl-4 col-lg-4 col-md-4">
    <div class="card h-100">
        <img class="card-img-top" src="../../public/img/<?= $bien->imageBien ?>" alt="Annonce">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <p class="font-weight-bold bg-dark p-1 rounded text-light"><?= $bien->typeAnnonce ?></p>
                <p class=" font-weight-bold"><?= $bien->ville ?></p>
            </div>
            <h5 class="card-title"><?= $bien->titreBien ?></h5>
            <p class="card-text"><?= $bien->resumeBien ?></p>
            <div class="d-flex justify-content-between">
                <form method="get" action="action.php" class="form-inline">
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
                <li class="page-item"><a class="page-link" href="location.php?indice=<?= ($i-1)*3 ?>"><?= $i ?></a></li>
               <?php
               } ?>
            </ul>
        </nav>
        </div>
        <?php
footer();
?>



<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';
session_start();
$db=connect();
head();

$sqlSelVendu='SELECT * FROM cafe
              INNER JOIN pays ON pays_idpays=idpays
              ORDER BY nbventeCafe DESC LIMIT 0,3 ';
$reqSelVendu=$db->prepare($sqlSelVendu);
$reqSelVendu->execute();
$tab_vendu=array();
while($data=$reqSelVendu->fetchObject())
{
    array_push($tab_vendu,$data);
}

$url_m=explode('?modify=',$_SERVER['REQUEST_URI']);
if (isset($url_m[1]) && $url_m[1]=='done')
{ ?>
    <div class="alert-success p-2 text-center">Modification effectuée avec succès</div>
    <?php
}
?>
<div class="container">
    <div class="arr_plan row justify-content-center">
        <h1 class="text-center titre">Les plus vendus</h1>
        <div class="card-deck">
            <div class="row">
                <?php foreach ($tab_vendu as $cafe)
                    {
                        if($cafe->typeCafe==='En grain')
                        {
                            $suffixe=' le sachet d\'1 kg';
                        }
                        else
                        {
                            $suffixe=' le paquet de 250g';
                        }
                    ?>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3">
                    <div class="card h-100 panneau m-1">
                        <img src="../../public/img/<?= $cafe->photoCafe ?>" class="card-img-top h-50" alt="...">
                        <div class="card-body bg-marron2  d-flex flex-column justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $cafe->nomCafe ?></h4>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-bold"><?= $cafe->typeCafe ?></h6>
                                <span class="card-text text-light font-weight-bold"><?= $cafe->nomPays ?></span>
                            </div>
                            <p class="card-text"><?= $cafe->resumeCafe ?></p>
                            <div class="d-flex justify-content-between">
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="<?= $cafe->idcafe ?>" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="plusvendus" name="page" class="d-none"/>
                                    <button class="btn  btn-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                </form>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role']==="admin")
                            { ?>
                                <form method="get" action="modifcafe.php" class="form-inline">
                                    <input type="number" value="<?= $cafe->idcafe ?>" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="plusvendus" name="page" class="d-none"/>
                                    <button class="btn  btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                                </form>
                            <?php } ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p><span class="font-weight-bold"><?= $cafe->prixCafe ?>€</span><?= $suffixe ?></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
footer();

<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';
session_start();
head();
$db=connect();

$url=explode('?connect=',$_SERVER['REQUEST_URI']);
if (isset($url[1]) && $url[1]==='ok')
{
    echo '<div class="alert-success p-2 text-center">Bienvenue '.$_SESSION['prenom'].' '.$_SESSION['nom'].'</div>';
}
$sqlSelect='SELECT * FROM cafe
            INNER JOIN pays ON pays_idpays=idpays
            WHERE selectCafe=1';
$reqSelect=$db->prepare($sqlSelect);
$reqSelect->execute();
$tab_Sel=array();
while($data=$reqSelect->fetchObject())
{
    array_push($tab_Sel,$data);
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
        <h1 class="text-center titre">Sélection de la semaine</h1>
        <div class="card-deck">
            <div class="row">
                <?php foreach ($tab_Sel as $cafe_sel)
                    {
                        if($cafe_sel->typeCafe==='En grain')
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
                        <img src="../../public/img/<?= $cafe_sel->photoCafe ?>" class="card-img-top h-50" alt="...">
                        <div class="card-body bg-marron2 d-flex flex-column justify-content-between">
                            <div>
                                <h4 class="card-title"><?= $cafe_sel->nomCafe ?></h4>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-bold"><?= $cafe_sel->typeCafe ?></h6>
                                <span class="card-text text-light font-weight-bold"><?= $cafe_sel->nomPays ?></span>
                            </div>
                            <p class="card-text"><?= $cafe_sel->resumeCafe ?></p>
                            <div class="d-flex justify-content-between">
                                <form method="get" action="voirplus.php" class="form-inline">
                                    <input type="number" value="<?= $cafe_sel->idcafe ?>" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="selection" name="page" class="d-none"/>
                                    <button class="btn btn-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                </form>
                                <?php if(isset($_SESSION['role']) && $_SESSION['role']==="admin")
                                    { ?>
                                <form method="get" action="modifcafe.php" class="form-inline">
                                    <input type="number" value="<?= $cafe_sel->idcafe ?>" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="selection" name="page" class="d-none"/>
                                    <button class="btn btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
                                </form>
                                        <?php } ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p><span class="font-weight-bold"><?= $cafe_sel->prixCafe ?>€</span><?= $suffixe ?></p>
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

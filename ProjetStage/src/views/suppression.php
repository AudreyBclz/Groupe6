<?php
require_once 'src/config/config.php';
require_once 'src/config/connect.php';
require_once 'src/config/notconnect.php';
notco();

if(!isset($_SESSION['role']) || $_SESSION['role']!=="admin")
{
    header('Location:accueil');
}
else
{

$db=connect();

if(isset($_POST['id']))
{
    $sqlDel='DELETE FROM cafe
             WHERE idcafe=:id';
    $reqDel=$db->prepare($sqlDel);
    $reqDel->bindParam(':id',$_POST['id']);
    $reqDel->execute();
    echo'<div class="alert-danger p-2 text-center">Article supprimé</div>';
}
//on récupère tous les cafés
$sqlSelect='SELECT * FROM cafe
            INNER JOIN pays ON pays_idpays=idpays';
$reqSelect=$db->prepare($sqlSelect);
$reqSelect->execute();
$tab_Sel=array();
while($data=$reqSelect->fetchObject())
{
    array_push($tab_Sel,$data);
}
?>
<div class="container">
    <div class="arr_plan row justify-content-center">
        <h1 class="text-center titre">Admin: Suppression des articles</h1>
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
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
                        <div class="card h-100 panneau m-1">
                            <?php if($cafe_sel->stockCafe==0){echo'<img class="card-img-top h-50" src="public/img/epuise.png">' ;}else{ ?><img src="public/img/<?= $cafe_sel->photoCafe ?>" class="card-img-top h-50" alt="..."><?php ;} ?>
                            <div class="card-body h-25 bg-marron2 d-flex justify-content-center align-items-center">
                                    <h4 class="card-title text-center"><?= $cafe_sel->nomCafe ?></h4>
                            </div>
                            <div class="card-footer h-25 d-flex justify-content-center align-items-center">
                                <div>
                                    <form method="post" action="suppression" class="form-inline">
                                        <input type="number" value="<?= $cafe_sel->idcafe ?>" name="id" readonly="readonly" class="d-none"/>
                                        <button class="btn btn-danger mr-1" type="submit">Supprimer  <i class="fa fa-trash-o" aria-hidden="true"></i> </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>

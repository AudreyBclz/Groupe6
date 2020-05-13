<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';
session_start();
$db=connect();
head();

$url=explode('indice=',$_SERVER['REQUEST_URI']);
if (isset($url[1]))
{
    $url_i=explode('?tri=',$url[1]);
    $indice=intval($url_i[0]);
    $triage=$url_i[1];
}
else
{
    $indice=0;
}

if (isset($triage)) {

    if ($triage === "NomA-Z") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomCafe
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe';
    } elseif ($triage === "NomZ-A") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomCafe DESC
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe';
    } elseif ($triage === "pays") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomPays
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe';
    } elseif ($triage === "decafeine") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE decafCafe=1
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE decafCafe=1';
    } elseif ($triage === "nondeca") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE decafCafe IS NULL
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE decafCafe IS NULL';
    } elseif ($triage === "Bio") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE bioCafe=1
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE bioCafe=1';
    } elseif ($triage === "nonbio") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE bioCafe IS NULL 
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE bioCafe IS NULL';
    } elseif ($triage === "grain") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE typeCafe="En grain"
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE typeCafe="En grain"';
    } elseif ($triage === "moulu") {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE typeCafe="Moulu"
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE typeCafe="Moulu"';
    } else {
        $sqlaff = 'SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 LIMIT ' . $indice . ',3';
        $sqlcpte = 'SELECT COUNT(*)  AS nbCafe FROM cafe';
    }
}
elseif (isset($_POST["tri"]))
{

    if($_POST['tri']==="NomA-Z")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomCafe
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe';
    }
    elseif ($_POST["tri"]==="NomZ-A")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomCafe DESC
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe';
    }
    elseif ($_POST["tri"]==="pays")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 ORDER BY nomPays
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe';
    }
    elseif ($_POST['tri']==="decafeine")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE decafCafe=1
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE decafCafe=1';
    }
    elseif ($_POST['tri']==="nondeca")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE decafCafe IS NULL
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE decafCafe IS NULL';
    }
    elseif ($_POST['tri']==="Bio")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE bioCafe=1
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE bioCafe=1';
    }
    elseif ($_POST['tri']==="nonbio")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE bioCafe IS NULL 
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE bioCafe IS NULL';
    }
    elseif ($_POST['tri']==="grain")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE typeCafe="En grain"
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE typeCafe="En grain"';
    }
    elseif ($_POST['tri']==="moulu")
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 WHERE typeCafe="Moulu"
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe
                  WHERE typeCafe="Moulu"';
    }
    else
    {
        $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 LIMIT '.$indice.',3';
        $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe';
    }


}
else
{
    $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 LIMIT '.$indice.',3';
    $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe';
}

$reqcpte=$db->prepare($sqlcpte);
$reqcpte->execute();
$cpte=array();
while ($data=$reqcpte->fetchObject())
{
    array_push($cpte,$data);
}
foreach ($cpte as $nb)
{
    $nbre=$nb->nbCafe;
}
$nbPage=ceil($nbre/3);


$reqaff=$db->prepare($sqlaff);
$reqaff->execute();
$tab_cafe=array();
while($data=$reqaff->fetchObject())
{
    array_push($tab_cafe,$data);
}

function selec($value,$tri)
{

    if (isset($tri))
    {
        if ($value == $tri)
        {
            echo'selected="selected"';
        }
    }
    elseif (isset($_POST['tri']))
    {
        if ($_POST['tri']==$value)
        {
            echo'selected="selected"';
        }
    }

}
if (!isset($triage))
{
    if (isset($_POST['tri']))
    {
        $triage=$_POST['tri'];
    }
    else
    {
        $triage="tous";
    }
}

// sert à fixer le problème du retour avec les formulaires
if (isset($_POST['tri']))
{
    header('Location:nosproduits.php?indice=0?tri='.$_POST['tri']);
}

?>
<div class="container">
    <div class="arr_plan">
    <div class="row justify-content-center mt-0">
            <h1 class="text-center titre">Tous nos produits</h1>
    </div>
        <div class="row m-auto">
            <div class="col-6 text-center">
                <form action="nosproduits.php" method="post" class="form-inline mb-3">
                    <label for="trier" class="mr-1">Trier par :</label>
                    <select name="tri" id="trier" class="form-control-sm">
                        <option value="tous"<?php selec("tous",$triage) ?>>Tous les produits</option>
                        <option value="NomA-Z"<?php selec("NomA-Z",$triage) ?>>Nom A-Z</option>
                        <option value="NomZ-A"<?php selec("NomZ-A",$triage) ?>>Nom Z-A</option>
                        <option value="pays"<?php selec("pays",$triage) ?>>Pays</option>
                        <option value="decafeine"<?php selec("decafeine",$triage) ?>>Décaféiné</option>
                        <option value="nondeca"<?php selec("nondeca",$triage) ?>>Non décaféiné</option>
                        <option value="Bio"<?php selec("Bio",$triage) ?>>Bio</option>
                        <option value="nonbio"<?php selec("nonbio",$triage) ?>>Non Bio</option>
                        <option value="grain"<?php selec("grain",$triage) ?>>En grain</option>
                        <option value="moulu"<?php selec("moulu",$triage) ?>>Moulu</option>
                    </select>
                    <button type="submit" class="btn-marron rounded  ml-2 mb-2">Trier</button>
                </form>
            </div>
        </div>
        <div class="card-deck">
            <div class="row justify-content-center">
                <?php foreach ($tab_cafe as $cafe)
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
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 ">
                    <div class="card h-100 panneau">
                        <img src="../../public/img/<?= $cafe->photoCafe ?>" class="card-img-top h-50" alt="...">
                        <div class="card-body bg-marron2 d-flex flex-column justify-content-between">
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
                                    <input type="text" value="nosproduits" name="page" class="d-none"/>
                                    <button class="btn btn-sm btn-primary mr-1" type="submit"> Voir <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                </form>
                        <?php if(isset($_SESSION['role']) && $_SESSION['role']==="admin")
                                { ?>
                                <form method="get" action="modifcafe.php" class="form-inline">
                                    <input type="number" value="<?= $cafe->idcafe ?>" name="id" readonly="readonly" class="d-none"/>
                                    <input type="text" value="nosproduits" name="page" class="d-none"/>
                                    <button class="btn btn-sm btn-warning mr-1" type="submit"><i class="fa fa-spinner" aria-hidden="true"></i> Modifier</button>
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
    <div class="d-flex justify-content-center align-items-start">
        <nav aria-label="Page navigation example" id="pagination">
            <ul class="pagination">
                <?php for($i=1;$i<=$nbPage;$i++)
                { ?>
                        <li class="page-item"><a class="page-link" href="nosproduits.php?indice=<?= ($i-1)*3 ?>?tri=<?= $triage ?>
                           "><?= $i ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>
<?php
footer();

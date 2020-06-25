<?php
use App\Models\cafe;
require_once 'src/config/config.php';
require_once 'src/config/connect.php';

$db=connect();

//si on vient de modifier ça affiche ce message
$url_m=explode('?modify=',$_SERVER['REQUEST_URI']);
if (isset($url_m[1]) && $url_m[1]=='done')
{ ?>
    <div class="alert-success p-2 text-center">Modification effectuée avec succès</div>
    <?php
}


// si elle existe,on récupère la manière de trier via l'URL et l'indice pour récupérer la bonne page
$url=explode('indice=',$_SERVER['REQUEST_URI']);
if (isset($url[1]))
{
    $url_i=explode('?tri=',$url[1]);
    $indice=intval($url_i[0]);
    $triage=$url_i[1];
}
else
{
    $indice=0; // si elle n'existe pas alors c'est la première page donc indice =0
}
$cafe=new cafe($db);

if (isset($triage))
{
    $sqlaff=($cafe->tri($triage,$indice))[0];
    $sqlcpte=($cafe->tri($triage,$indice))[1];
}
else
{
    //requête si pas de choix de fait
    $sqlaff='SELECT * FROM cafe
                 INNER JOIN pays ON pays_idpays=idpays
                 LIMIT '.$indice.',3';
    $sqlcpte='SELECT COUNT(*)  AS nbCafe FROM cafe';
}


$nbPage=$cafe->nb_page($sqlcpte);
$tab_cafe=$cafe->recup_cafe($sqlaff);

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

//fonction pour que le tri reste afficher quand on change de page
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


// sert à fixer le problème du retour avec les formulaires
if (isset($_POST['tri']))
{
    header('Location:nosproduits?indice=0?tri='.$_POST['tri']);
}
?>

<div class="container">
    <div class="arr_plan">
    <div class="row justify-content-center mt-0">
            <h1 class="text-center titreproduit">Tous nos produits</h1>
    </div>
        <div class="row m-auto">
            <div class="col-6 text-center">
                <form action="nosproduits" method="post" class="form-inline mb-3">
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
               <?php cafe::aff($tab_cafe,'tous'); ?>
            </div>
    </div>
</div>
    <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation example" id="pagination">
            <ul class="pagination">
                <?php for($i=1;$i<=$nbPage;$i++)
                { ?>
                        <li class="page-item"><a class="page-link" href="nosproduits?indice=<?= ($i-1)*3 ?>?tri=<?= $triage ?>
                           "><?= $i ?></a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>

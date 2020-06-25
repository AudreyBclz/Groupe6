<?php
use App\Models\cafe;
require_once 'src/config/config.php';
require_once 'src/config/connect.php';

$db=connect();

$cafe=new cafe($db);
$sqlAff=($cafe->tri("+vendus",0))[0];
$tab_vendu=$cafe->recup_cafe($sqlAff);

//s'il y a eu modif du café on affiche le message sur la page
$url_m=explode('?modify=',$_SERVER['REQUEST_URI']);
if (isset($url_m[1]) && $url_m[1]=='done')
{ ?>
    <div class="alert-success p-2 text-center">Modification effectuée avec succès</div>
    <?php
}

$file=explode('/',$_SERVER['REQUEST_URI']);
$file=explode('?',$file[2]);
$exist=false;

if (isset($_SESSION['role']) && $_SESSION['role']==="admin" )
{
    if(file_exists('cache/'.$file[0].$_SESSION['role'].'.txt'))
    {
        $exist=true;
        echo file_get_contents('cache/'.$file[0].$_SESSION['role'].'.txt');
    }
}elseif (!(isset($_SESSION['role']) && $_SESSION['role']==="admin" ))
{
    if(file_exists('cache/'.$file[0].'.txt'))
    {
        $exist=true;
        echo file_get_contents('cache/'.$file[0].'.txt');
    }
}
if(!$exist)
{
ob_start();

?>
<div class="container">
    <div class="arr_plan row justify-content-center">
        <h1 class="text-center titre">Les plus vendus</h1>
        <div class="card-deck">
            <div class="row">
               <?php cafe::aff($tab_vendu,"+vendus"); ?>
            </div>
        </div>
    </div>
</div>
<?php
    $content=ob_get_contents();

    if (isset($_SESSION['role']))
    {
        if($_SESSION['role']==="admin")
        {
            file_put_contents('cache/'.$file[0].$_SESSION['role'].'.txt',$content);
        }
        else
        {
            file_put_contents('cache/'.$file[0].'.txt',$content);
        }
    }
    else
    {
        file_put_contents('cache/'.$file[0].'.txt',$content);
    }
} ?>

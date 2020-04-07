<?php
include_once 'elements/head.php';
include_once 'elements/footer.php';
require_once '../../src/config/config.php';
require '../models/connect.php';

$db=connect();
$mod=array();
$mar=array();

if(isset($_POST['marque']) && isset($_POST['modele']))
{
    $marque=htmlspecialchars(trim($_POST['marque']));
    $modele=htmlspecialchars(trim($_POST['modele']));
    $sqlSelectMod='SELECT idModele FROM modele WHERE nomModele = :modele';
    $sqlSelectMar='SELECT idMarque FROM marque WHERE nomMarque = :marque';

    $reqSelMod=$db->prepare($sqlSelectMod);
    $reqSelMod->bindParam(':modele',$modele);
    while ($data=$reqSelMod->fetchObject())
    {
        array_push($mod,$data);
    }


    $sqlInsertMod='INSERT INTO modele(nomModele) VALUES(:modele)';
    $sqlInsertMar='INSERT INTO marque(nomMarque) VALUES(:marque)';

    $req=$db->prepare($sqlInsertMod);
    $req->bindParam(':modele',$modele,PDO::PARAM_STR);
    $req->execute();

    $req2=$db->prepare($sqlInsertMar);
    $req2->bindParam(':marque',$marque,PDO::PARAM_STR);


}

head();
?>

    <h1>Liste de mes véhicules</h1>
    <hr>
    <table class="table table-hover mt-5 mb-5">
        <thead class="thead-dark">
        <tr>
            <th>Marque</th>
            <th>Modèle</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <?php
            foreach ($vehiculeMarque as $marque=>$modele){
            ?>
            <td><?= $marque ?></td>
            <td><?= $modele ?></td>
        </tr>
        <?php
        }
        ?>

        </tbody>
    </table>
    <div>
        <a href="../../index.php">
            <button type="button" class="btn btn-outline-dark">
                Accueil
            </button>
        </a>
    </div>
<?php
footer();
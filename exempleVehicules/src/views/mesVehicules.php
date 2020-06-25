<?php
include_once 'elements/head.php';
include_once 'elements/footer.php';
require_once '../../src/config/config.php';
require '../models/connect.php';

$db=connect();
$mod=array();
$mar=array();
$marNotDb=true;
$modNotDb=true;


if(isset($_POST['marque']) && isset($_POST['modele']))
{
    $marque=htmlspecialchars(trim($_POST['marque']));
    $modele=htmlspecialchars(trim($_POST['modele']));
    $sqlSelectMod='SELECT idModele,nomModele FROM modele';
    $sqlSelectMar='SELECT idMarque,nomMarque FROM marque';

    $reqSelMod=$db->query($sqlSelectMod);
    while ($data=$reqSelMod->fetch())
    {
        if($data['nomModele']=== $modele)
        {
            $modNotDb=false;
            $idMo=intval($data['idModele']);
        }
    }
    if ($modNotDb)
    {
        $sqlInsertMod='INSERT INTO modele(nomModele) VALUES(:modele)';
        $req=$db->prepare($sqlInsertMod);
        $req->bindParam(':modele',$modele,PDO::PARAM_STR);
        $req->execute();
        $idMo=$db->lastInsertId();
    }

    $reqSelMar=$db->query($sqlSelectMar);
    while ($data=$reqSelMar->fetch())
    {
        if($data['nomMarque']===$marque)
        {
            $marNotDb=false;
            $idMa=intval($data['idMarque']);

        }
    }
    if ($marNotDb)
    {
        $sqlInsertMar='INSERT INTO marque(nomMarque) VALUES(:marque)';
        $req=$db->prepare($sqlInsertMar);
        $req->bindParam(':marque',$marque,PDO::PARAM_STR);
        $req->execute();
        $idMa=$db->lastInsertId();
    }

    $sqlInsertVehi='INSERT INTO vehicule(modele_idModele,marque_idMarque) VALUES(:idmodele,:idmarque)';
    $reqInsVehi=$db->prepare($sqlInsertVehi);
    $reqInsVehi->bindParam(':idmodele',$idMo);
    $reqInsVehi->bindParam(':idmarque',$idMa);
    $reqInsVehi->execute();
}
$sqlVehi='SELECT vehicule.idVehicule,marque.nomMarque, modele.nomModele
            FROM vehicule
            INNER JOIN marque ON vehicule.marque_idMarque=marque.idMarque
            INNER JOIN modele ON vehicule.modele_idModele=modele.idModele';



head();
?>

    <h1>Liste de mes véhicules</h1>
    <hr>
    <table class="table table-hover mt-5 mb-5">
        <thead class="thead-dark">
        <tr>
            <th> ID</th>
            <th>Marque</th>
            <th>Modèle</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $reqVehi =$db->prepare($sqlVehi);
        $reqVehi->execute();
        while($donnees=$reqVehi->fetch())
        {
        ?>
        <tr>
            <td><?= $donnees['idVehicule'] ?></td>
            <td><?= $donnees['nomMarque'] ?></td>
            <td><?= $donnees['nomModele'] ?></td>
        </tr>
        <?php }
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

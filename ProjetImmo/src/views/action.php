<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

head();
$db=connect();

if (isset($_GET['action']) && isset($_GET['id']))
{
    if ($_GET['action']=="delete")
    {
        $sqlSelDet='SELECT detail_iddetail FROM location WHERE idlocation='.$_GET['id'];
        $reqSelDet=$db->prepare($sqlSelDet);
        $reqSelDet->execute();
        $det=array();
        while ($data=$reqSelDet->fetchObject())
        {
            array_push($det,$data);
        }
        foreach ($det as $detail)
        {
            $idDet = intval($detail->detail_iddetail);
        }
        $sqlDelDet='DELETE FROM detail
                    WHERE iddetail=:iddet';
        $reqDelDet=$db->prepare($sqlDelDet);
        $reqDelDet->bindParam(':iddet',$idDet);
        $reqDelDet->execute();

        $sqlDelLoc='DELETE FROM location
                    WHERE idlocation=:id';
        $reqDelLoc=$db->prepare($sqlDelLoc);
        $reqDelLoc->bindParam(':id',$_GET['id']);
        $reqDelLoc->execute();

        header('Location:gererMesBiens.php?delete=done');
    }

    if($_GET['action']=="modify")
    {
     $sqlAffloc='SELECT *,Superficiedetail,nbPiecedetail,descdetail
                    FROM location
                    INNER JOIN detail ON detail_iddetail=iddetail
                    WHERE idlocation=:idloc';
        $reqAffloc=$db->prepare($sqlAffloc);
        $reqAffloc->bindParam(':idloc',$_GET['id']);
        $reqAffloc->execute();
        $affLoc=array();
        while($data=$reqAffloc->fetchObject())
        {
            array_push($affLoc,$data);
        }
        foreach ($affLoc as $location)
        {
            $iddetail=intval($location->detail_iddetail);
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
                <h2 class="mx-auto mt-3"> Modification</h2>
            </div>
            <div>
                <form method="post" action="modify.php" class="w-50 mx-auto mt-5" enctype="multipart/form-data">
                    <?php foreach ($affLoc as $location)
                    { ?>
                    <div class="form-group row w-50">
                        <label for="titre" class="form"> ID :</label>
                        <input type="number" name="id" value="<?= $location->idlocation ?>" id="id" class="form-control" readonly="readonly">
                    </div>
                    <div class="form-group row w-50">
                        <label for="titre" class="form"> Titre de l'annonce :</label>
                        <input type="text" name="titre" value="<?= $location->titreLocation ?>" id="titre" class="form-control" required="required">
                    </div>
                    <div class="form-group row">
                        <label for="resume">Résumé de l'annonce :</label>
                        <textarea maxlength="255" name="resume" id="resume" class="form-control" required="required"><?= $location->resumeLocation ?></textarea>

                    </div>
                    <div class="row d-flex justify-content-between">
                        <div class="form-group ">
                            <label for="superficie">Superficie :</label>
                            <input type="number" name="superficie" value="<?= $location->Superficiedetail ?>" id="superficie" class="form-control" required="required">
                        </div>

                        <div class="form-group">
                            <label for="nbpiece">Nombre de pièces :</label>
                            <input type="number" name="nbpiece" value="<?= $location->nbPiecedetail ?>" id="nbpiece" class="form-control" required="required">
                        </div>
                        <div class="form-group">
                            <label for="prix">Prix : :</label>
                            <input type="number" name="prix" value="<?= $location->prixLocation ?>" id="prix" class="form-control" required="required">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="description">Description complète :</label>
                        <textarea class="form-control" name="description" id="description" required="required"><?= $location->descdetail ?></textarea>
                    </div>
                    <div class="row">
                        <label for="image">Photographie du bien :</label><br>
                    </div>
                    <div class="row">
                        <input type="file" name="image" value="<?= $location->imageLocation ?>" id="image">
                    </div>
                    <div class="row">
                        <button type="submit" class="btn btn-dark mt-4">Envoyer</button>
                    </div>
                </form>
           <?php
             } ?>
             </div>
        </div>

    <?php }
}
if ($_GET['action']=='read') {
    $sqlSel1 = 'SELECT *,Superficiedetail,nbPiecedetail,descdetail
                    FROM location
                    INNER JOIN detail ON detail_iddetail=iddetail
                    WHERE idlocation=:id';
    $reqSel1 = $db->prepare($sqlSel1);
    $reqSel1->bindParam(':id', $_GET['id']);
    $reqSel1->execute();
    $selLoc = array();
    while ($data = $reqSel1->fetchObject()) {
        array_push($selLoc, $data);
    }
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../../index.php">DamienLocation</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
    <?php foreach ($selLoc as $loc) { ?>
        <div class="col-lg-6 col-md-6 mx-auto">
            <h1 class="flex-block text-center"><?= $loc->titreLocation ?></h1>
            <div>
                <img class="img-thumbnail" src="../../public/img/<?= $loc->imageLocation ?>">
            </div>
            <div>
                <span>Superficie : <?= $loc->Superficiedetail ?> m²</span>
                <span> Nombre de pièces : <?= $loc->nbPiecedetail ?></span>
            </div>
            <p class="my-3"><?= $loc->descdetail ?></p>
            <div class="mt-5">
                <span class="bg-success p-2 rounded">Prix : <?= $loc->prixLocation ?> € net vendeur</span>
            </div>
        </div>
        </div>
        <?php
    }
}
?>

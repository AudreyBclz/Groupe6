<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

head();
$db=connect();

if (isset($_POST['titre']) && isset($_POST['resume']) && isset($_POST['superficie']) && isset($_POST['nbpiece']) && isset($_POST['prix']) && isset($_POST['description']))
{
    $sqlAffloc2='SELECT *
                    FROM location
                    INNER JOIN detail ON detail_iddetail=iddetail
                    WHERE idlocation=:idloc';
    $reqAffloc2=$db->prepare($sqlAffloc2);
    $reqAffloc2->bindParam(':idloc',$_POST['id']);
    $reqAffloc2->execute();
    $affLoc2=array();
    while($data=$reqAffloc2->fetchObject())
    {
        array_push($affLoc2,$data);
    }
    foreach ($affLoc2 as $location)
    {
        $idDet=intval($location->detail_iddetail);
    }

    $sqlUpDet='UPDATE detail
                        SET Superficiedetail = :super,
                            nbPiecedetail = :nb,
                            descdetail = :descr
                            WHERE iddetail = :id';
    $reqUpDet=$db->prepare($sqlUpDet);

    $reqUpDet->bindParam(':super',$_POST['superficie']);
    $reqUpDet->bindParam(':nb',$_POST['nbpiece']);
    $reqUpDet->bindParam(':descr',$_POST['description']);
    $reqUpDet->bindParam(':id',$idDet);
    $reqUpDet->execute();

    $sqlUpLoc='UPDATE location
                        SET titreLocation = :titre,
                            resumeLocation = :resume,
                            prixLocation = :prix,
                            imageLocation = :image,
                            dateModifLocation = NOW()
                            WHERE idlocation = :id_l';
    $reqUpLoc=$db->prepare($sqlUpLoc);
    $reqUpLoc->bindParam(':titre',$_POST['titre']);
    $reqUpLoc->bindParam(':resume',$_POST['resume']);
    $reqUpLoc->bindParam(':prix',$_POST['prix']);
    $reqUpLoc->bindParam(':image',$_FILES['image']['name']);
    $reqUpLoc->bindParam(':id_l',$_POST['id']);
    $reqUpLoc->execute();

    header('Location:gererMesBiens.php?modify=done');



}

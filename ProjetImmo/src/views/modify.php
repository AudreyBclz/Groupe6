<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

session_start();
head();
$db=connect();

if (isset($_POST['titre']) &&isset($_POST['typeA']) && isset($_POST['typeBien']) && isset($_POST['resume']) &&
    isset($_POST['superficie']) && isset($_POST['nbpiece']) && isset($_POST['prix'])&& isset($_POST['adresse1']) && isset($_POST['ville'])
    && isset($_POST['codePost']) && isset($_POST['pays'])  && isset($_POST['description']))
{
    $sqlAffbien2='SELECT *
                    FROM bien
                    INNER JOIN adresse ON adresse_idadresse=idadresse
                    WHERE idbien=:idbien';
    $reqAffbien2=$db->prepare($sqlAffbien2);
    $reqAffbien2->bindParam(':idbien',$_POST['id']);
    $reqAffbien2->execute();
    $affbien2=array();
    while($data=$reqAffbien2->fetchObject())
    {
        array_push($affbien2,$data);
    }
    foreach ($affbien2 as $bien)
    {
        $idAd=intval($bien->adresse_idadresse);
    }

    $sqlUpAd='UPDATE adresse
                        SET adresse1 = :ad1,
                            adresse2 = :ad2,
                            ville = :ville,
                            codepostal = :cp,
                            pays = :pays
                            WHERE idadresse = :id';
    $reqUpAd=$db->prepare($sqlUpAd);

    $reqUpAd->bindParam(':ad1',$_POST['adresse1']);
    $reqUpAd->bindParam(':ad2',$_POST['adresse2']);
    $reqUpAd->bindParam(':ville',$_POST['ville']);
    $reqUpAd->bindParam(':cp',$_POST['codePost']);
    $reqUpAd->bindParam(':pays',$_POST['pays']);
    $reqUpAd->bindParam(':id',$idAd);
    $reqUpAd->execute();

    $sqlUpBien='UPDATE bien
                        SET titreBien = :titre,
                            typeAnnonce= :typeA,
                            typeBien= :typeB,
                            resumeBien = :resume,
                            superficieBien = :super,
                            nbpieceBien = :nbp,
                            prixBien = :prix,
                            descBien = :descr,
                            imageBien = :image,
                            dateModifBien = NOW()
                            WHERE idbien = :id_b';
    $reqUpBien=$db->prepare($sqlUpBien);
    $reqUpBien->bindParam(':titre',$_POST['titre']);
    $reqUpBien->bindParam(':typeA',$_POST['typeA']);
    $reqUpBien->bindParam(':typeB',$_POST['typeBien']);
    $reqUpBien->bindParam(':resume',$_POST['resume']);
    $reqUpBien->bindParam(':super',$_POST['superficie']);
    $reqUpBien->bindParam(':nbp',$_POST['nbpiece']);
    $reqUpBien->bindParam(':prix',$_POST['prix']);
    $reqUpBien->bindParam(':descr',$_POST['description']);
    $reqUpBien->bindParam(':image',$_FILES['image']['name']);
    $reqUpBien->bindParam(':id_b',$_POST['id']);
    $reqUpBien->execute();

    header('Location:gererMesBiens.php?modify=done');



}

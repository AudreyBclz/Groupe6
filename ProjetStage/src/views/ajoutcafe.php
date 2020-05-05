<?php
require_once 'elements/head.php';
require_once 'elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';
session_start();
head();
$db=connect();

if (isset($_POST["nomCafe"]) && isset($_POST["paysCafe"]) && isset($_POST["type"]) && isset($_POST["prix"]) &&
    isset($_POST["resume"]) && isset($_POST["description"]))
{
    $nomcafe=htmlspecialchars(trim($_POST["nomCafe"]));
    $payscafe=htmlspecialchars(trim($_POST["paysCafe"]));
    $resume=htmlspecialchars(trim($_POST["resume"]));
    $description=htmlspecialchars(trim($_POST["description"]));
    $sqlSelect='SELECT idcafe FROM cafe
                WHERE nomCafe = :nom';
    $reqSelect=$db->prepare($sqlSelect);
    $reqSelect->bindParam(':nom',$nomcafe);
    $reqSelect->execute();
    $tab_cafe=array();
    while($data=$reqSelect->fetchObject())
    {
        array_push($tab_cafe,$data);
    }
    if(!empty($tab_cafe))
    {
        echo'<div class="alert-warning p-2 text-center">Ce café existe déjà!</div>';
    }
    else
    {
        $sqlSelectPays='SELECT idpays FROM pays
                        WHERE nomPays= :pays';
        $reqSelectPays=$db->prepare($sqlSelectPays);
        $reqSelectPays->bindParam(':pays',$payscafe);
        $reqSelectPays->execute();
        $tab_pays=array();
        while($data_p=$reqSelectPays->fetchObject())
        {
            array_push($tab_pays,$data_p);
        }
        if(!(empty($tab_pays)))
        {

            $idpays=intval($tab_pays[0]->idpays);
        }
        else {
            $sqlInsertPays = 'INSERT INTO pays (nomPays) VALUES(:pays_p)';
            $reqInsertPays = $db->prepare($sqlInsertPays);
            $reqInsertPays->bindParam(':pays_p', $payscafe);
            $reqInsertPays->execute();
            $idpays = intval($db->lastInsertId());
        }
            $sqlInsertCafe='INSERT INTO cafe (nomCafe,typeCafe,decafCafe,bioCafe,prixCafe,resumeCafe,descCafe,photoCafe,date_creaCafe,selectCafe,pays_idpays)
                            VALUES(:nom,:type_c,:deca,:bio,:prix,:resume,:descr,:photo,NOW(),:select_c,:id_p)';
            $reqInsertCafe=$db->prepare($sqlInsertCafe);
            $reqInsertCafe->bindParam(':nom',$nomcafe);
            $reqInsertCafe->bindParam(':type_c',$_POST["type"]);
            $reqInsertCafe->bindParam(':deca',$_POST["deca"]);
            $reqInsertCafe->bindParam(':bio',$_POST["bio"]);
            $reqInsertCafe->bindParam(':prix',$_POST["prix"]);
            $reqInsertCafe->bindParam(':resume',$resume);
            $reqInsertCafe->bindParam(':descr',$description);
            $reqInsertCafe->bindParam(':photo',$_FILES["picture"]["name"]);
            $reqInsertCafe->bindParam(':select_c',$_POST['select']);
            $reqInsertCafe->bindParam(':id_p',$idpays);
            $reqInsertCafe->execute();
            move_uploaded_file($_FILES['picture']['tmp_name'],'../../public/img/'.basename($_FILES['picture']['name']));
            echo '<div class="alert-success p-2 text-center">Le café a bien été ajouté</div>';
        }
}
?>
<div class="container">
    <div class="arr_plan justify-content-center">
        <h1 class="text-center titre">Admin: Ajout Café</h1>
        <form method="post" action="ajoutcafe.php" enctype="multipart/form-data">
            <div class="row justify-content-between">
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div >
                        <label for="nomCafe" class="col-form-label">Nom du Café :</label>
                        <input type="text" name="nomCafe" id="nomCafe" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="paysCafe" class="col-form-label">Provenance :</label>
                        <input type="text" name="paysCafe" id="paysCafe" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="type" class="labelcafe col-form-label">Type :</label>
                        <select name="type" id="type" class="form-control w-50">
                            <option value="En grain">En grain</option>
                            <option value="Moulu">Moulu</option>
                        </select>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <div class="form-check form-check-inline">
                            <label for="decaffeine" class="mr-3 col-form-label">Décafféiné :</label>
                            <input type="checkbox" name="deca" value="1" id="decaffeine">
                        </div>
                        <div class="form-check form-check-inline">
                            <label for="bio" class="mr-3 col-form-label">Bio :</label>
                            <input type="checkbox"name="bio" value="1" id="bio">
                        </div>
                        <div class="form-check form-check-inline">
                            <label for="select" class="mr-3 col-form-label">Sélectionné :</label>
                            <input type="checkbox" name="select" value="1" id="select">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="prix" class="labelcafe">Prix :</label>
                        <input type="text" name="prix" id="prix" class="form-control w-30" required="required">
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
                    <div>
                        <label for="resume" class="col-form-label">Résumé :</label>
                        <input type="text" name="resume" id="resume" class="form-control" required="required">
                    </div>
                    <div>
                        <label for="description" class="col-form-label">Description :</label>
                        <textarea name="description" id="description" class="form-control" required="required"></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="image" class="col-form-label">Photos :</label>
                        <input type="file" name="picture" id="image" class="w-100"/>
                    </div>
                    <div class="mt-5">
                        <button type="submit" class="btn btn-marron" id="ajout_cafe">Ajouter</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="text-center">
            <img src="../../public/img/cafe-vrac.png" class="w-25"/>
        </div>
    </div>
</div>
<?php
footer();

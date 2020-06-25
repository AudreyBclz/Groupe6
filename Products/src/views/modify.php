<?php

require_once '../views/elements/head.php';
require_once '../views/elements/footer.php';
require_once '../config/config.php';
require_once '../models/connect.php';

head();

$db = connect();


if (isset($_POST['name_modif']) && isset($_POST['desc_modif']) && isset($_POST['cat_modif']) && isset($_POST['price_modif']))
{
    $cat=array();
    $sqlSelCat='SELECT *
                    FROM categories
                    WHERE categories.name=:name';
    $reqSelCat=$db->prepare($sqlSelCat);
    $reqSelCat->bindParam(':name',$_POST['cat_modif']);
    $reqSelCat->execute();

    while($data=$reqSelCat->fetchObject())
    {
        array_push($cat,$data);
    }


    if (empty($cat))
    {
        $sqlInsCat='INSERT INTO categories (categories.created,categories.name)
                    VALUES (NOW(),:nameCat)';
        $reqInsCat=$db->prepare($sqlInsCat);
        $reqInsCat->bindParam(':nameCat',$_POST['cat_modif']);
        $reqInsCat->execute();
        $idCat=$db->lastInsertId();
    }
    else
    {
        foreach ($cat as $categorie)
        {
            $idCat=intval($categorie->id);
        }
    }

    $name_mo = $_POST['name_modif'];
    $desc_mo = $_POST['desc_modif'];
    $price_mo = intval($_POST['price_modif']);
    $id_mo = intval($_POST['id_m']);

    $sqlUpProd= 'UPDATE products 
                 SET products.name = :nvname,
                 products.description = :descr, 
                 products.price = :nvprice, 
                 products.category_id = :idCat,
                 products.modified= NOW() 
                 WHERE products.id = :nvid';

    $reqUpProd =$db->prepare($sqlUpProd);

    $reqUpProd->bindParam(':nvname',$name_mo);
    $reqUpProd->bindParam(':descr',$desc_mo);
    $reqUpProd->bindParam(':nvprice',$price_mo);
    $reqUpProd->bindParam(':idCat',$idCat);
    $reqUpProd->bindParam(':nvid',$id_mo);

    $reqUpProd->execute();
}
header('Location:../../products.php?modify=done');
?>



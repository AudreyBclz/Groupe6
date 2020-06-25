<?php
$tabSimple =array("BMW","MERCEDES","Renault","Ferrari","Jaguar");
foreach ($tabSimple as $key=>$value)
{
    echo "La voiture n° ".$key." a pour marque".$value."<br>";
}

$tabAsso=array("Apple"=>"Iphone11",
                "Nokia"=>"3310",
                "Huawei"=>"P20 pro"
    );

foreach ($tabAsso as $key=>$value)
{
    echo "Le telephone de la marque ".$key." a pour modèle :".$value."<br>";
}

?>
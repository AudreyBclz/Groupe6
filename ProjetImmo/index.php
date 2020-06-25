<?php
require 'vendor/autoload.php';

$router =new AltoRouter();
$router->setBasePath('/ProjetImmo');

$router->map('GET','/','/','base');
$router->map('GET','/accueil',"accueil",'accueil');
$router->map('GET|POST','/contact', "contact","contact");
$router->map('GET|POST','/annonces','annonces','annonces');
$router->map('GET|POST','/annonces/[i:indice]','annonce_retour','annonce_retour');
$router->map('GET|POST','/ajoutAnnonce','ajoutAnnonce','ajoutAnnonce');
$router->map('GET|POST','/inscription','inscription','inscription');
$router->map('GET|POST','/gestionBiens','gestionBiens','gestionBiens');
$router->map('GET|POST','/gestion','gestion','gestion');
$router->map('GET|POST','/voirPlus/[i:id]/[read|modify|delete:action]/[location|gererMesBiens:page]/[i:indice]','voirPlus_do','voirPlus_do');
$router->map('GET|POST','/disconected','disconected','disconected');
$router->map('GET|POST','/modify','modify','modify');


$match = $router->match();
require 'src/views/elements/head.php';

if($match["target"] === "accueil"){
    require 'src/views/home.php';
}elseif ($match["target"] === "inscription") {
    require 'src/views/ajoutClAg.php';
}elseif ($match["target"] === "contact"){
    require 'src/views/contact.php';
}elseif ($match["target"] === "annonces"){
    require 'src/views/location.php';
}elseif ($match["target"] === "ajoutAnnonce"){
    require 'src/views/ajoutbien.php';
}elseif ($match["target"] === "gestionBiens"){
    require 'src/views/gererMesBiens.php';
}elseif($match["target"] === "gestion") {
    require 'src/views/action.php';
}elseif ($match["target"] === "disconected"){
    require 'src/models/deconnect.php';
}elseif ($match["target"] === "modify") {
    require 'src/views/modify.php';
}else {
    require 'src/views/home.php';
    }


require 'src/views/elements/footer.php';

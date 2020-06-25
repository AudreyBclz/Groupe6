<?php
require 'vendor/autoload.php';

$router=new AltoRouter();
$router->setBasePath('/ProjetStage');

$router->map('GET','/','/','base');
$router->map('GET','/accueil',"accueil",'accueil');
$router->map('GET|POST','/selection',"selection",'selection');
$router->map('GET','/detail',"detail",'detail');
$router->map('GET|POST','/lesplusvendus','lesplusvendus',"lesplusvendus");
$router->map('GET|POST','/nosproduits','nosproduits',"nosproduits");
$router->map('GET|POST','/connexion&ins','connexion&ins',"connexion&ins");
$router->map('GET|POST','/inscription','inscription',"inscription");
$router->map('GET|POST','/monpanier','monpanier',"monpanier");
$router->map('GET|POST','/livraison','livraison',"livraison");
$router->map('GET|POST','/recapitulatif','recapitulatif',"recapitulatif");
$router->map('GET|POST','/paiement','paiement',"paiement");
$router->map('GET|POST','/confirmation','confirmation',"confirmation");
$router->map('GET|POST','/contact','contact',"contact");
$router->map('GET|POST','/ajoutCafe','ajoutCafe',"ajoutCafe");
$router->map('GET|POST','/modification','modification',"modification");
$router->map('GET|POST','/ajout_fournisseur','ajout_fournisseur',"ajout_fournisseur");
$router->map('GET|POST','/historique_commande','histo_com',"histo_com");
$router->map('GET|POST','/deconnexion','deconnexion',"deconnexion");
$router->map('GET|POST','/dateLivraison','dateLivraison','dateLivraison');
$router->map('GET|POST','/monCompte',"moncompte",'moncompte');
$router->map('GET|POST','/motDePasse',"motdepasse",'motdepasse');
$router->map('GET|POST','/initMotDePasse',"initmdp",'initmdp');
$router->map('GET|POST','/suppression',"suppression",'suppression');

$match= $router->match();
require 'src/views/elements/head.php';
require_once 'src/config/config.php';
require_once 'src/config/connect.php';
session_start();
head();
$file=explode('/',$_SERVER['REQUEST_URI']);
$file=explode('?',$file[2]);
$filename=('cache/'.$file[0].'.txt');
    if($match["target"] === "accueil"){
        if(file_exists($filename))
        {
            echo file_get_contents($filename);
        }
        else
        {
            ob_start();
            require 'src/views/home.php';
            $content=ob_get_contents();
            $file=explode('/',$_SERVER['REQUEST_URI']);
            file_put_contents($filename,$content);
        }
    }elseif($match["target"] === "selection"){
        require 'src/views/selection.php';
    }elseif($match["target"] === "detail"){
        require 'src/views/voirplus.php';
    }elseif($match["target"] === "lesplusvendus"){
        require 'src/views/plusvendus.php';
    }elseif($match["target"] === "nosproduits"){
        require 'src/views/nosproduits.php';
    }elseif($match["target"] === "connexion&ins"){
        require 'src/views/connexion.php';
    }elseif($match["target"] === "inscription"){
        require 'src/views/inscription.php';
    }elseif($match["target"] === "monpanier"){
        require 'src/views/panier.php';
    }elseif($match["target"] === "livraison"){
        require 'src/views/adresse_paiement.php';
    }elseif($match["target"] === "recapitulatif"){
        require 'src/views/recap.php';
    }elseif($match["target"] === "paiement"){
        require 'src/views/paiement.php';
    }elseif($match["target"] === "confirmation"){
        require 'src/views/conf_commande.php';
    }elseif($match["target"] === "contact"){
        if(file_exists($filename))
        {
            echo file_get_contents($filename);
        }
        else
        {
            ob_start();
            require 'src/views/contact.php';
            $content=ob_get_contents();
            $file=explode('/',$_SERVER['REQUEST_URI']);
            file_put_contents($filename,$content);
        }
    }elseif($match["target"] === "ajoutCafe"){
        require 'src/views/ajoutcafe.php';
    }elseif($match["target"] === "modification") {
        require 'src/views/modifcafe.php';
    }elseif ($match["target"] === "ajout_fournisseur"){
        require 'src/views/inscription_fournisseur.php';
    }elseif($match["target"] === "histo_com"){
        require 'src/views/histo_commande.php';
    }elseif($match["target"] === "deconnexion"){
        require 'src/config/disconnect.php';
    }elseif($match["target"] === "dateLivraison"){
        require 'src/views/admin_livraison.php';
    }elseif($match["target"] === "moncompte"){
        require 'src/views/moncompte.php';
    }elseif($match["target"] === "motdepasse") {
        require 'src/views/mdpoublie.php';
    }elseif($match["target"] === "initmdp") {
        require 'src/views/initMdP.php';
    }elseif($match["target"] === "suppression") {
        require 'src/views/suppression.php';
    }
    else{
        require 'src/views/home.php';
    }



require 'src/views/elements/footer.php';
footer();

<?php
require_once 'src/views/elements/head.php';
require_once 'src/views/elements/footer.php';
require_once 'src/config/config.php';
require_once 'src/models/connect.php';

head();
$db=connect();

if (isset($_POST['email']) & isset($_POST['mdp']))
{
    $sqlSelAg='SELECT idadresse, mdpAgence FROM adresse
               INNER JOIN agence ON idadresse=adresse_idadresse
                WHERE email=:mail';
    $reqSelAg=$db->prepare($sqlSelAg);
    $reqSelAg->bindParam(':mail',$_POST['email']);
    $reqSelAg->execute();
    $agence=array();
    while($data=$reqSelAg->fetchObject())
    {
        array_push($agence,$data);
    }

    if(empty($agence))
    {
        $okAg=false;
    }
    else
    {
        if( password_verify($_POST['mdp'],$agence[0]->mdpAgence))
        {
            $okAg=true;
        }
    }

    $sqlSelCl='SELECT idadresse, mdpClient FROM adresse
               INNER JOIN client ON idadresse=adresse_idadresse
                WHERE email=:mail';
    $reqSelCl=$db->prepare($sqlSelCl);
    $reqSelCl->bindParam(':mail',$_POST['email']);
    $reqSelCl->execute();
    $client=array();
    while($data=$reqSelCl->fetchObject())
    {
        array_push($client,$data);
    }

    if(empty($client))
    {
        $okCl=false;
    }
    else
        {
        if (password_verify($_POST['mdp'], $client[0]->mdpClient))
        {
            $okCl = true;
        }
    }
    if ($okAg || $okCl)
    {
        echo'<div class="p-2 alert-success">Connexion effectuée avec succès</div>';
    }
    else{
        echo '<div class="p-2 alert-warning">Erreur d\'identification</div>';
    }
}
?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">DamienLocation</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./src/views/location.php">Location</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./src/views/contact.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./src/views/ajoutbien.php">Ajout de bien</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./src/views/ajoutClAg.php">Ajout Client/Agence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./src/views/gererMesBiens.php">Gestion biens</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row mt-5 d-flex justify-content-center">
            <div class="col-xs-5 col-sm-5 col-md-5  col-lg-4  col-xl-4 ">
                <img class="card-img-top" src="public/img/BernardBlier.jpg" alt="Card image cap">
            </div>

            <div class="col-xs-5 col-sm-5 col-md-5  col-lg-5  col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bienvenue sur IMMO-Blier!!</h5>
                        <p class="card-text">Le site de ventes et locations de biens immobiliers de Bernard Blier!</p>

                        <p>"Chez moi on ne vends pas, on ventile!!"</p>
                        <h2 class="mt-5"> Se connecter</h2>
                        <form method="post" action="index.php">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" required="required" id="email" name="email" class="form-control">
                                <label for="mdp">Mot de passe</label>
                                <input type="password" required="required" id="mdp" name="mdp" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-outline-dark">Connexion</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
        <div class="col-xs-5 col-sm-5 col-md-5  col-lg-5  col-xl-5">

            </div>
        </div>
    <?php
footer();

<?php
require_once 'src/config/config.php';
require_once 'src/models/connect.php';

$db=connect();

if (isset($_POST['email']) & isset($_POST['mdp']))
{
    $okAg=false;
    $sqlSelUserAg='SELECT * FROM users
                INNER JOIN agence ON iduser = user_iduser
                WHERE mailUser=:mail';
    $reqSelUserAg=$db->prepare($sqlSelUserAg);
    $reqSelUserAg->bindParam(':mail',$_POST['email']);
    $reqSelUserAg->execute();
    $userAg=array();
    while ($data=$reqSelUserAg->fetchObject())
    {
        array_push($userAg,$data);
    }

    if(empty($userAg))
    {
        $okAg=false;
    }
    else
    {
            $okAg=password_verify($_POST['mdp'],$userAg[0]->mdpUser);

    }

    $okCl=true;
    $sqlSelUserCl='SELECT * FROM users
               INNER JOIN client ON iduser=user_iduser
                WHERE mailUser=:mail';
    $reqSelUserCl=$db->prepare($sqlSelUserCl);
    $reqSelUserCl->bindParam(':mail',$_POST['email']);
    $reqSelUserCl->execute();
    $userCl=array();
    while($data=$reqSelUserCl->fetchObject())
    {
        array_push($userCl,$data);
    }
    
    if(empty($userCl))
    {
        $okCl=false;
    }
    else
        {
            $okCl = password_verify($_POST['mdp'], $userCl[0]->mdpUser);
    }

    if ($okAg || $okCl)
    {
        echo'<div class="p-2 alert-success">Connexion effectuée avec succès</div>';

            $_SESSION['agence'] = $okAg;
            $_SESSION['client'] = $okCl;

    }
    else{
        echo '<div class="p-2 alert-warning">Erreur d\'identification</div>';
    }
}
?>
        <div class="row mt-5 d-flex justify-content-center">
            <div class="col-xs-5 col-sm-5 col-md-5  col-lg-4  col-xl-4 ">
                <img class="card-img-top" src="<?php __DIR__; ?>public/img/BernardBlier.jpg" alt="Card image cap">
            </div>

            <div class="col-xs-5 col-sm-5 col-md-5  col-lg-5  col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bienvenue sur IMMO-Blier!!</h5>
                        <p class="card-text">Le site de ventes et locations de biens immobiliers de Bernard Blier!</p>

                        <p>"Chez moi on ne vends pas, on ventile!!"</p>
                        <h2 class="mt-5"> Se connecter</h2>
                        <form method="post" action="home.php">
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
if(isset($_SESSION['agence']))
{
    header('Location:annonces');
}

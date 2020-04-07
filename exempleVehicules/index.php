<?php
//require'src/views/elements/head.php'; // arrête si y'a erreur
//include 'src/views/elements/head.php'; // va continuer l'exécution du code
require_once 'src/views/elements/head.php';
require_once 'src/views/elements/footer.php';
require_once'src/config/config.php';
require_once 'src/models/connect.php';
$db=connect();
//require 'src/views/elements/footer.php';
//include_once'src/views/elements/head.php';

head();
?>
    <h1>Site de mes véhicules</h1>
    <hr>
    <div>
        <a href="src/views/mesVehicules.php">
            <button type="button" class="btn btn-outline-dark">
                Mes véhicules
            </button>
        </a>
        <form method="post" action="src/views/mesVehicules.php" class="mt-5">
            <div class="form-group">
                <label for="marque">Marque</label>
                <input type="text" name="marque" id="marque" class="form-control">
            </div>
            <div class="form-group">
                <label for="modele">Modèle</label>
                <input type="text" name="modele" id="modele" class="form-control">
            </div>
            <button type="submit" class="btn btn-secondary">Envoyer</button>
        </form>
    </div>
<?php
footer();
?>

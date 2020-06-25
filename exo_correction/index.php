<?php
//require'src/views/elements/head.php'; // arrête si y'a erreur
//include 'src/views/elements/head.php'; // va continuer l'exécution du code
require_once'src/view/elements/head.php';
require_once 'src/view/elements/footer.php';
//include_once'src/views/elements/head.php';
head();
?>
    <h1>Site de mes véhicules</h1>
    <hr>
    <div>
        <a href="src/view/mesVehicules.php">
            <button type="button" class="btn btn-outline-dark">
                Mes véhicules
            </button>
        </a>
    </div>
<?php
footer();
?>

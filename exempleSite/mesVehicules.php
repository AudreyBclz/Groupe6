<?php
$tabVehicule =array("Renault"=>"R25",
                    "Ford"=>"Focus",
                    "Peugeot"=>"206",
                    "Dacia"=>"Duster",
                    "Delorean"=>"DMC-12",
                    "Citroen"=>"2CV",
                    "Pontiac"=>"Trans Am noire",
                    "Dodge"=>"Charger"
    );
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="UTF-8"/>
        <style>
            td
            {
                border: 1px solid black;
            }
            table
            {
                border-collapse: collapse;
            }
        </style>
    </head>
    <body>
        <h1> Voici la liste de mes véhicules</h1>
        <table>
            <thead>
                <tr>
                    <th>Marque</th>
                    <th>Modèle</th>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach ($tabVehicule as $marque=> $modele)
            {?>
                <tr>
                    <td><?= $marque; ?></td>
                    <td><?= $modele; ?></td>
                <tr/>;
            <?php}
            ?>
            </tbody>
        </table>
    </body>
</html>

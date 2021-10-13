<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php


echo json_encode($_POST);

$city=$_POST["city_id"]; // Choix de la ville
$tab=$_POST;


$nom=$_POST["name_id"]; // Mettre son nom de famille
$tab=$_POST;


$prenom=$_POST["prenom_id"]; // Mettre son prénom
$tab=$_POST;


$age=$_POST["age_id"]; // Mettre son âge
$tab=$_POST;


$sexe=$_POST["sexe_id"]; // Choix du sexe
$tab=$_POST;



$adress=$_POST["adress_id"]; // renseignement sur l'adresse
$tab=$_POST;


$codePostal=$_POST["code_id"];
$tab=$_POST;


$portable=$_POST["port_id"]; // Renseignement sur les contacts 
$tab=$_POST;


$fixe=$_POST["fixe_id"];
$tab=$_POST;


$mail=$_POST["mail_id"];
$tab=$_POST;




foreach($tab as $key => $val){
    echo($key);
};


?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de création d'agence.</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<?php
    $tab = [];

    $Ag = $_POST["Agence"];
    $tab=$_POST;
    
    $Ad = $_POST["Adresse"];
    $tab=$_POST;
    
    $Cp = $_POST["Code_Postal"];
    $tab=$_POST;
    
    $T = $_POST["Téléphone"];
    $tab=$_POST;
    
    $M = $_POST["Mail"];
    $tab=$_POST;
    
    foreach($tab as $key => $val){
        print_r("$val |");
    };
    
?>

<!--Voir pour transférer les valeurs dans un tableau appelé das une fonction, puis les renvoyer dans sur la page html et afficher le tout dans une case.-->
    
</body>

</html>
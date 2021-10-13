<?php

require "library.php";

$bdd=opall();

while (true) {
    echo ("\n 1- Créer une agence." . 
        "\n 2- Créer un client." . 
        "\n 3- Créer un compte bancaire." . 
        "\n 4- Recherche de compte (numéro de compte)." . 
        "\n 5- Recherche de client (Nom, Numéro de compte,Identifiant de client)." . 
        "\n 6- Afficher la liste des comptes d'un client (Identifiant client)." .
        "\n 7- Imprimer les infos client (Identifiant client)." .
        "\n 8- Quitter le programme.\n\n");
    $choixMenu = readline("\nVotre choix : ");
    echo ("\n");
        while (!preg_match("/^[1-8]$/", $choixMenu)) {
            $choixMenu = readline("Invalide! refaire votre choix : ");
            echo ("\n");
        };
    switch ($choixMenu){
        case 8 :
            exit;
        case 1:
            $bdd[0]=add_agence($bdd[0]);
            $bdd=sall($bdd);
            clall($bdd);
            break;
        case 2:
            $bdd[1]=add_client($bdd[0],$bdd[1]);
            $bdd=sall($bdd);
            clall($bdd);
            break;
        case 3:       
            $bdd[2]=add_compte($bdd[0],$bdd[1],$bdd[2]);
            $bdd=sall($bdd);
            clall($bdd);
            break;
        case 4:
            search_compte($bdd[0],$bdd[1],$bdd[2]);
            break;
        case 5:
            search_client($bdd[0],$bdd[1]);
            break;
        case 6:
            list_comptes($bdd[0],$bdd[1],$bdd[2]);
            break;
        case 7:
            print_client($bdd[0],$bdd[1],$bdd[2]);
            break;
    };
}
?>
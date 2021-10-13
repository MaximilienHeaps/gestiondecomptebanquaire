<?php

require 'filereader.php';
require 'constants.php';

/*
    1- Créer une agence. --
    2- Crée un client. --
    3- Créer un compte bancaire. --
    4- Recherche de compte (numéro de compte). --
    5- Recherche de client (Nom, Numéro de compte,Identifiant de client). --
    6- Afficher la liste des comptes d'un client (Identifiant client). --
    7- Imprimer les infos client (Identifiant client)
*/

function hfeach1d($array=[],$array2=[]){ // affichage $array (1 dimension)

    echo("\n");
    
    foreach($array as $key => $v){ // affiche toutes les valeurs de $array
        echo($key<count($array)-1) ? "|".$v : "|".$v."|" ;
    }
    unset($key, $v);

    echo("\n");

    foreach($array2 as $key => $v){ // affiche toutes les valeurs de $array2
        echo($key<count($array2)-1) ? "|".$v : "|".$v."|" ;
    }
    unset($key, $v);

    echo("\n\n");
}

function feach2d($array=[]){ // affichage $array (2 dimensions)
    
    foreach($array as $v){ // affiche toutes les valeurs de $array
        foreach($v as $v2){
            echo("|".$v2);
        }
        echo("|\n");
    }
    unset($v, $v2);

    echo("\n");
}

function feach2dbis($array=[]){ // affichage $array (2 dimensions) en ignorant la derniere ligne (a utiliser pour les CSV)
    $count=count($array)-1;

    echo("\n");
    
    foreach($array as $v){ // affiche toutes les valeurs de $array
        if($v!=$array[$count]){
            foreach($v as $v2){
                echo("|".$v2);
            }
            echo("|\n");
        }
    }
    unset($v, $v2);

    echo("\n");
}

function feach3dbis($BDD=[]){ // affichage $BDD (3 dimensions) en ignorant la derniere ligne (a utiliser pour les CSV)
    
    foreach($BDD as $array){ // affiche toutes les valeurs de $array
        $count=count($array)-1;
        foreach($array as $v){ // affiche toutes les valeurs de $array
            if($v!=$array[$count]){
                foreach($v as $v2){
                    echo("|".$v2);
                }
                echo("|<br />");
            }
        }
        echo("<br />");
    }
    unset($v, $v2, $v3);
}

function check_agence($tableAgence=[]){ // entre une agence et verifie qu'elle existe 
    $i=0; // verifie l'existence d'un element

    foreach($tableAgence as $v){ // verifie l'existence de l'agence
        if($v!=null){
            if($v!=$tableAgence[0]){
                $i++;
            }
        }
    }

    if($i==0){ // verifie si une agence existe
        echo("Aucune agence n'est repertorie actuellement...\n");
        return;
    }

    while(1){ // entre une agence

        echo("Voici les agences:\n");
        feach2dbis($tableAgence);
    
        $x=readline("Entrez le numero de votre agence: ");

        foreach($tableAgence as $v){ // verifie l'existence de l'agence
            if($v!=null){
                if($v[0]==$x){
                    unset($v);
                    $i=0;
                    return $x;
                }
            }
        }

        unset($v);
        
        echo("Cette agence n'existe pas. Veuillez reesayer.\n\n");

    }
}

function check_client($tableclient=[]){ // entre un client et verifie qu'il existe 
    $i=0; // verifie l'existence d'un element

    foreach($tableclient as $v){ // verifie l'existence du client
        if($v!=null){
            if($v!=$tableclient[0]){
                $i++;
            }
        }
    }

    if($i==0){ // verifie si un client pour l'agence selectionnee existe
        echo("Aucun client n'est repertorie actuellement pour cette agence...\n");
        return;
    }

    while(1){ // entre un client

        echo("Voici les clients de cette agence:\n\n");
        feach2d($tableclient);
    
        $y=readline("Entrez le numero du client: ");

        foreach($tableclient as $v){ // verifie l'existence du client
            if($v!=null){
                if($v[1]==$y){
                    unset($v);
                    $i=0;
                    return $y;
                }
            }
        }

        unset($v);

        echo("Ce client n'existe pas. Veuillez reesayer.\n\n");
    }
}

function check_compte($tablecompte=[]){ // entre un compte et verifie qu'il existe 
    $i=0; // verifie l'existence d'un element

    foreach($tablecompte as $v){ // verifie l'existence du compte
        if($v!=null){
            if($v!=$tablecompte[0]){
                $i++;
            }
        }
    }

    if($i==0){ // verifie si un compte pour le client selectionne existe
        echo("Aucun compte n'est repertorie actuellement pour ce client...\n");
        return;
    }

    while(1){

        echo("Voici les comptes de ce client:\n\n");
        feach2d($tablecompte);
    
        $z=readline("Entrez le numero du compte: ");

        foreach($tablecompte as $v){ // verifie l'existence du compte
            if($v!=null){
                if($v[2]==$z){
                    unset($v);
                    $i=0;
                    return $z;
                }
            }
        }

        unset($v);

        echo("Ce compte n'existe pas. Veuillez reesayer.\n\n");
    }
}

function add_agence($tableAgence=[]){ // ajoute une agence
    $count=count($tableAgence)-1; // recupere le nombre d'agences
    $i=0; // valeur outil

    $tableAgence[$count][$i]=($tableAgence[1][0]==1) ? $tableAgence[$count-1][0]+1 : 1 ; // Id Agence // ternaire gerant le cas ou il n'y a pas encore d'agence (On pars tous de zero...)

    $tableAgence[$count][++$i]=readline("Entrez le nom de l'agence: ");

    $tableAgence[$count][++$i]=readline("Entrez l'adresse de l'agence: ");

    $tableAgence[$count][++$i]=readline("Entrez la ville de l'agence: ");

    $tableAgence[$count][++$i]=readline("Entrez le code postal de l'agence: ");

    return $tableAgence;
}

function add_client($tableAgence=[], $tableClient=[]){ // ajoute un client
    $tablebackup=$tableClient; // backup en cas de non existence d'agence
    $count=count($tableClient)-1; // recupere le nombre de clients
    $i=0; // valeur outil
    $x=0; // choix agence
    $y=-1; // numero client, auto-attribue
    $c="A"; // confirmation

    $x=check_agence($tableAgence);

    if($x==null){
        return $tablebackup;
    }

    $tableClient[$count][$i]=$x; // Id Agence

    foreach($tableClient as $v){ // recupere le dernier numero de client de l'agence
        if($v!=$tableClient[0] && $v!=$tableClient[$count]){
            if($v[0]==$x){
                $y=$v[1];
            }
        }
    }

    unset($v);

    if($y==-1){// dans le cas ou l'agence n'a pas encore de client (On pars tous de zero...)
        $y=0;
    }

    $tableClient[$count][++$i]=$y+1; // Id Client

    $tableClient[$count][++$i]=readline("Entrez le nom du client: ");

    $tableClient[$count][++$i]=readline("Entrez le prenom du client: ");

    $tableClient[$count][++$i]=readline("Entrez la date de naissance du client (jj/mm/aaaa): ");

    // module conf sex
    $c=readline("Entrez le sexe du client (H/F): ");

    while($c!='H' && $c!='F'){ // si $c est different de "H" et "F" redemande a l'utilisateur de rentrer une valeur correcte
        $c=readline('vous avez entre un mauvais caractere, veuillez entrer "H" ou "F" ');
    }

    $tableClient[$count][++$i]=$c;
    
    $c="A";
    //

    $tableClient[$count][++$i]=readline("Entrez l'adresse du client (numero et rue): ");

    $tableClient[$count][++$i]=readline("Entrez la ville du client: ");

    $tableClient[$count][++$i]=readline("Entrez le code postal du client: ");

    $tableClient[$count][++$i]=readline("Entrez le telephone portable du client: ");

    $tableClient[$count][++$i]=readline("Entrez le telephone fixe du client: ");

    $tableClient[$count][++$i]=readline("Entrez l'adresse e-mail du client: ");

    return $tableClient;
}

function add_compte($tableAgence=[], $tableClient=[], $tableCompte=[]){ // ajoute un compte
    $count=count($tableCompte)-1; // recupere le nombre de comptes
    $tablebackup=$tableCompte; // backup en cas de compte en trop
    $tableclient[]=$tableClient[0]; // liste des clients de l'agence selectionnee
    $count=count($tableCompte)-1; // recupere le nombre de comptes
    $i=0; // valeur outil
    $x=0; // choix agence
    $y=0; // choix client
    $z=-1; // numero compte, auto-attribue
    $c="A"; // confirmation

    $x=check_agence($tableAgence);
    
    if($x==null){
        return $tablebackup;
    }

    $tableCompte[$count][$i]=$x; // Id Agence

    foreach($tableClient as $v){ // recupere la liste de clients de l'agence selectionnee
        if($v!=null){
            if($v[0]==$x){
                $tableclient[]=$v;
            }
        }
    }

    unset($v);

    $y=check_client($tableclient);

    if($y==null){
        return $tablebackup;
    }

    $tableCompte[$count][++$i]=$y; // Id Client

    foreach($tableCompte as $v){ // recupere le dernier Compte du client
        if($v!=$tableCompte[0] && $v!=$tableCompte[$count]){
            if($v[0]==$x && $v[1]==$y){
                $z=$v[2];
            }
        }
    }
    
    unset($v);

    if($z>2){ // dans le cas ou le client a deja 3 comptes
        echo("Desole, ce client a deja le maximum de comptes possibles \n");

        return $tablebackup;

    } else if($z==-1){// dans le cas ou le client n'a pas encore de compte (On pars tous de zero...)
        $z=0;
    }

    $tableCompte[$count][++$i]=$z+1; // Id Compte

    // module conf type
    $c=readline("Entrez le type de compte (C=Courant, A=Livret A, PEL=Plan Epargne Logement): ");

    while($c!='C' && $c!='A' && $c!="PEL"){ // si $c est different de "C" et "A" et "PEL" redemande a l'utilisateur de rentrer une valeur correcte
        $c=readline('vous avez entre un mauvais caractere, veuillez entrer "C" ou "A" ou "PEL" ');
    }

    $tableCompte[$count][++$i]=$c;
    
    $c="A";
    //

    // module conf decouvert
    $c=readline("Un decouvert est il authorise? (O/N): ");

    while($c!='O' && $c!='N'){ // si $c est different de "C" et "A" et "PEL" redemande a l'utilisateur de rentrer une valeur correcte
        $c=readline('vous avez entre un mauvais caractere, veuillez entrer "O" ou "N" ');
    }

    $tableCompte[$count][++$i]=$c;
    
    $c="A";
    //    

    $tableCompte[$count][++$i]=readline("Entrez la solde de depart: ");

    $tableCompte[count($tableCompte)]=null;

    return $tableCompte;
}

function search_compte($tableAgence=[], $tableClient=[] , $tableCompte=[]){ // Recherche de compte
    $tableclient[]=$tableClient[0]; // liste des clients de l'agence selectionnee
    $tablecompte[]=$tableCompte[0]; // liste des comptes du client selectionne
    $x=0; // choix agence
    $y=0; // choix client
    $z=0; // choix compte

    $x=check_agence($tableAgence);

    if($x==null){
        return;
    }

    foreach($tableClient as $v){ // recupere la liste de clients de l'agence selectionnee
        if($v!=null){
            if($v[0]==$x){
                $tableclient[]=$v;
            }
        }
    }

    $y=check_client($tableclient);

    if($y==null){
        return;
    }


    foreach($tableCompte as $v){ // recupere la liste de comptes du client selectionnee
        if($v!=null){
            if($v[0]==$x && $v[1]==$y){
                $tablecompte[]=$v;
            }
        }
    }

    $z=check_compte($tablecompte);

    if($z==null){
        return;
    }

    foreach($tableCompte as $v){ // affiche le header et le compte recherche
        if($v!=null){
            if($v[0]==$x && $v[1]==$y && $v[2]==$z){
                hfeach1d($tableCompte[0], $v);
                break;
            }
        }
    }

    unset($v);
}

function search_client($tableAgence=[], $tableClient=[]){ // Recherche de client
    $tableclient[]=$tableClient[0]; // liste des client des l'agence selectionnee
    $x=0; // choix nom/agence
    $y=0; // choix prenom/client
    $z=0; // valeur outil
    $i=0; // confirmation / verifie l'existence d'un element

    while(1){
    
        $z=readline("souhaitez vous chercher un client par rapport a son nom (1) ou a son identifiant client (2) ou voulez vous revenir au menu (3)? ");

        switch ($z):

            case 1: // par nom
                $x=readline("Entrez le nom du client: ");
                $y=readline("Entrez le prenom du client: ");

                foreach($tableClient as $v){ // affiche le header et le client recherche
                    if($v!=null){
                        if($v[2]==$x && $v[3]==$y){
                            hfeach1d($tableClient[0], $v);
                            $i=1;
                            return;
                        }
                    }
                }

                unset($v);

                if($i!=1){
                    echo("Desole nous n'avons pas trouve de client a ce nom\n\n");
                }else{
                    break 2;
                }
                break;

            case 2: // par identifiant

                $x=check_agence($tableAgence);

                if($x==null){
                    return;
                }

                foreach($tableClient as $v){ // recupere la liste de clients de l'agence selectionnee
                    if($v!=null){
                        if($v[0]==$x){
                            $tableclient[]=$v;
                        }
                    }
                }

                $y=check_client($tableclient);

                if($y==null){
                    return;
                }
        
                foreach($tableClient as $val){ // affiche le header et le client recherche
                    if($val!=null){
                        if($val[0]==$x && $val[1]==$y){
                            hfeach1d($tableClient[0], $val);
                            return;
                        }
                    }
                }

                unset($val);
                break 2;
            
            case 3:
                return;
        
            default: // ^^
                echo("re-essayez avec les option proposee...\n");
                break;

        endswitch;
    }
}

function list_comptes($tableAgence=[], $tableClient=[] , $tableCompte=[]){ // Affiche la liste des comptes d'un client
    $tableclient[]=$tableClient[0]; // liste des client de l'agence selectionnee
    $tablecompte[]=$tableCompte[0]; // liste des comptes du client selectionne
    $x=0; // choix agence
    $y=0; // choix client

    $x=check_agence($tableAgence);

    if($x==null){
        return;
    }

    foreach($tableClient as $v){ // recupere la liste de clients de l'agence selectionnee
        if($v!=null){
            if($v[0]==$x){
                $tableclient[]=$v;
            }
        }
    }

    $y=check_client($tableclient);

    if($y==null){
        return;
    }

    foreach($tableCompte as $v){ // recupere la liste de comptes du client selectionnee
        if($v!=null){
            if($v[0]==$x && $v[1]==$y){
                $tablecompte[]=$v;
            }
        }
    }

    echo("Voici les comptes de ce client:\n\n");
    feach2d($tablecompte);
}

function print_client($tableAgence=[], $tableClient=[], $tableCompte=[]){ // affiche des infos client avec la liste de ses comptes
    $tableclient[]=$tableClient[0]; // liste des client de l'agence selectionnee
    $tablecompte=[]; // liste des comptes du client selectionne
    $tclient[]=$tableClient[0]; // infos du client
    $x=0; // valeur outil
    $y=0; // valeur outil

    $x=check_agence($tableAgence);

    if($x==null){
        return;
    }

    foreach($tableClient as $v){ // recupere la liste de clients de l'agence selectionnee
        if($v!=null){
            if($v[0]==$x){
                $tableclient[]=$v;
            }
        }
    }

    $y=check_client($tableclient);

    if($y==null){
        return;
    }

    foreach($tableCompte as $v){ // recupere la liste de comptes du client selectionne
        if($v!=null){
            if($v[0]==$x && $v[1]==$y){
                $tablecompte[]=$v;
            }
        }
    }

    foreach($tableClient as $val){ // recupere les infos du client recherche
        if($val[0]==$x && $val[1]==$y){
            $tclient=$val;
            break;
        }
    }

    unset($val);

    echo("\nFiche Client\n\n");

    echo("Numero client: ".$tclient[0].$tclient[1]."\n");
    echo("Nom: ".$tclient[2]."\n");
    echo("Prenom: ".$tclient[3]."\n");
    echo("Date de naissance: ".$tclient[4]."\n");

    echo("\n----------------------------------------------------------------------------------------------------\n");

    echo("Liste de comptes");

    echo("\n----------------------------------------------------------------------------------------------------\n");

    echo("Numero de compte                     |".$tableCompte[0][5]);

    echo("\n----------------------------------------------------------------------------------------------------\n");

    foreach($tablecompte as $v){

        echo($v[0].$v[1].$v[2]);
        echo("                                  |".$v[5]." euros");
        if($v[5]>0){
           echo("                                  :-)\n");
        } else {
            echo("                                  ;-(\n");
        }
    }

    unset($v);

}

function sall($array=[]){ // range dans l'ordre les tableaux

    // Table Agence (normalement inutile)
    for($i=1 ; $i<count($array[0])-1 ; $i++){ // Trie par Id Agence (normalement inutile)
        for($j=1 ; $j<count($array[0])-1 ; $j++){ // trie les valeures une par une et les range dans l'ordre croissant
            $x=0;
            ($array[0][$i][0]>$array[0][$j][0] && $i<$j) ? $x=$array[0][$i] and $array[0][$i]=$array[0][$j] and $array[0][$j]=$x : null ;
        }
    }

    // Table Client
    for($i=1 ; $i<count($array[1])-1 ; $i++){ // Trie par Id Agence
        for($j=1 ; $j<count($array[1])-1 ; $j++){ // trie les valeures une par une et les range dans l'ordre croissant
            $x=0;
            ($array[1][$i][0]>$array[1][$j][0] && $i<$j) ? $x=$array[1][$i] and $array[1][$i]=$array[1][$j] and $array[1][$j]=$x : null ;
        }
    }

    for($i=1 ; $i<count($array[1])-1 ; $i++){ // Trie par Id Client (normalement inutile)
        for($j=1 ; $j<count($array[1])-1 ; $j++){ // trie les valeures une par une et les range dans l'ordre croissant
            $x=0;
            ($array[1][$i][1]>$array[1][$j][1] && $array[1][$i][0]==$array[1][$j][0] && $i<$j) ? $x=$array[1][$i] and $array[1][$i]=$array[1][$j] and $array[1][$j]=$x : null ;
        }
    }

    // Table Compte
    for($i=1 ; $i<count($array[2])-1 ; $i++){ // Trie par Id Agence
        for($j=1 ; $j<count($array[2])-1 ; $j++){ // trie les valeures une par une et les range dans l'ordre croissant
            $x=0;
            ($array[2][$i][0]>$array[2][$j][0] && $i<$j) ? $x=$array[2][$i] and $array[2][$i]=$array[2][$j] and $array[2][$j]=$x : null ;
        }
    }

    for($i=1 ; $i<count($array[2])-1 ; $i++){ // Trie par Id Client
        for($j=1 ; $j<count($array[2])-1 ; $j++){ // trie les valeures une par une et les range dans l'ordre croissant
            $x=0;
            ($array[2][$i][1]>$array[2][$j][1] && $array[2][$i][0]==$array[2][$j][0] && $i<$j) ? $x=$array[2][$i] and $array[2][$i]=$array[2][$j] and $array[2][$j]=$x : null ;
        }
    }

    for($i=1 ; $i<count($array[2])-1 ; $i++){ // Trie par Id Compte (normalement inutile)
        for($j=1 ; $j<count($array[2])-1 ; $j++){ // trie les valeures une par une et les range dans l'ordre croissant
            $x=0;
            ($array[2][$i][2]>$array[2][$j][2] && $array[2][$i][1]==$array[2][$j][1] && $array[2][$i][0]==$array[2][$j][0] && $i<$j) ? $x=$array[2][$i] and $array[2][$i]=$array[2][$j] and $array[2][$j]=$x : null ;
        }
    }

    return $array;
}

function opall(){ // ouvre tous les fichiers CSV et les place dans un tableau
    $array=[];

    $array[0]=read(FILE_AGENCE);
    $array[1]=read(FILE_CLIENT);
    $array[2]=read(FILE_COMPTE);
    
    return $array;
}

function clall($array){ // sauvegarde tous les tableaux et les place dans un fichiers CSV

    write(FILE_AGENCE, $array[0]);
    write(FILE_CLIENT, $array[1]);
    write(FILE_COMPTE, $array[2]);
}

/*

// unused functions

function feach1d($array=[]){ // affichage $array (1 dimension)

    foreach($array as $key => $v){ // affiche toutes les valeurs de $array
        echo($key<count($array)-1) ? "|".$v : "|".$v."|" ;
    }
    unset($key, $v);

    echo("\n\n");
}

function feach3d($array=[]){ // affichage $array (3 dimensions)
    
    foreach($array as $v){ // affiche toutes les valeurs de $array
        foreach($v as $v2){
            foreach ($v2 as $v3){
                echo("|".$v3);
            }
            echo("|\n");
        }
        echo("\n");
    }
    unset($v, $v2, $v3);
}

function get_header($array=[]){ // recupere le header d'une table
    $header=[];

    $header=$array[0];

    return $header;
}

function del_header($array=[]){ // supprime le header d'une table
    $count=count($array);

    for($i=0 ; $i<$count-1 ; $i++){ // decale toutes les valeures de $array vers la gauche
        $array[$i]=$array[$i+1];
    }
    unset($array[$count-1]); // supprime la case restante a la fin d'$array
    
    return $array;
}

function add_header($array=[], $header=[]){ // rajoute le header d'une table
    $count=count($array);

    for($i=$count-1 ; $i>0 ; $i--){ // decale toutes les valeures de $array vers la droite
        $array[$i]=$array[$i+1];
    }
    unset($array[$count-1]); // supprime la case restante a la fin d'$array
    
    $array[0]=$header;

    return $array;
}

*/

?>

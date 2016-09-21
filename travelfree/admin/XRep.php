<?php
/**
 * Created by PhpStorm.
 * User: DEV
 * Date: 13/09/2016
 * Time: 14:23
 */


// Ouvrir le repertoire
$dir=opendir('uploads');


// Parcourir le repertoire en lisant le nom d'un fichier à chaque itération
   /* while($fichier = readdir($dir)){
        if($fichier != '.' && $fichier != '..'){
        // echo $fichier,'<br>'; //affiche le nom des fichiers images
            echo '<img src="uploads/'.$fichier.'"> <br>';
        }
    }*/

    $scandir = scandir('uploads'); // mets les mons des fichiers images dans un tableau
    $rand= rand(2,count($scandir)-1); // 2 à partir de la 3éme case  et -1 car on commence à 0
// Affiche les images au hasard
    echo '<img src="uploads/'.$scandir[$rand].'">';

// fermer le repertoire
    closedir($dir);




?>
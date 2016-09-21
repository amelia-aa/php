<?php
/**
 * Created by PhpStorm.
 * User: DEV
 * Date: 13/09/2016
 * Time: 09:53
 */

/*créer un fichier.txt en lui donnant des droits pour ecrire et lire*/
$monfichier = fopen('info.csv','a+');

/*$texte= 'Bonjour !!'.PHP_EOL; PHP_EOL pour les re"tour à la ligne */

/*ecrire dans le fichier
fwrite($monfichier,$texte);*/


/*tableau*/
$Ville='ville';
$Client='client';
$Date='date';

$texte = array($Ville,$Client,$Date);
fputcsv($monfichier,$texte,';');

/*fermer un fichier*/
fclose($monfichier);





?>
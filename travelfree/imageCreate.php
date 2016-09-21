<?php
// image source
    $img=imagecreatefromjpeg('img/hollande.jpg');

// Taille de l'image
    $size=getimagesize('img/hollande.jpg');

        //echo print_r($size);  // pour voir la largeur et la hauteur


/* Methode de redimension 1
// taille de distination  (reduction de l'image)
    $larg=$size[0]*20/100;
    $long=$size[1]*20/100;

// (redimensionner l'image)
    imagecopyresized($img_dest,$img,0,0,0,0,$larg,$long,$size[0],$size[1]);

*/

/*methode de redimension 2*/

// Image de destination (creation de la zone)
    $img_dest=imagecreatetruecolor(200,200);  // parametre de largeur et hauteur

    if ($size[0]>$size[1]){
        $long=200;
        $larg=$size[0]*200/$size[1];

        imagecopyresized($img_dest,$img,0,0,$larg/2,0,$larg,$long,$size[0],$size[1]);
}
    else{
        $larg=200;
        $long= $size[1]*200/$size[0];
        imagecopyresized($img_dest,$img,0,0,0,$long/2,$larg,$long,$size[0],$size[1]);
    }




//On spécifie le type de fichier crée (Format de destination et où on le met)
    header('Content-Type: image/jpeg');  // pour changer le type d'extension
    imagejpeg($img_dest,'thumb/hollande.jpg',60);


?>
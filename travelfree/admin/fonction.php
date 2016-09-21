<?php
// fonction de vérification nombre
function VerifNum($param)
{
    $nospace = str_replace(' ','',$param);  //permet d'enlever les espaces
    $num = str_replace(',','.',$nospace);        //permet de remplacer la virgule(,) du prix par un point(.)
    if (is_numeric($num))
    {
        return $num;
    }
 /*   else
    {
        echo 'Ceci n\'est pas un nombre';
    }
 **/
}


// recuperation de dates
function DateCreate($pardate)
{
    /******  JOUR  ******/
    echo '<select name="'.$pardate.'day">';
    for ($i=1; $i<31; $i++)
    {
        echo '<option value="'.sprintf('%02d',$i).'">'.sprintf('%02d',$i).'</option>'.PHP_EOL;  //sprintf()pour avoir le zero avant
    }
    echo '</select>';
    ///
      echo  '<select name="'.$pardate.'month">
              <option value="01">Janvier</option>
              <option value="02">Février</option>
              <option value="03">Mars</option>
              <option value="04">Avril</option>
              <option value="05">Mai</option>
              <option value="06">Juin</option>
              <option value="07">Juillet</option>
              <option value="08">Août</option>
              <option value="09">Septembre</option>
              <option value="10">Octobre</option>
              <option value="11">Novembre</option>
              <option value="12">Décembre</option>
          </select>';

    /******  ANNEE   ******/
          $year=date('Y');
          echo '<select name="'.$pardate.'year">';
          for($i=$year; $i<=($year +10); $i++)  // +10 pour afficher les 10 dernieres années
          {
              echo '<option value="'.$i.'">' .$i.'</option>'. PHP_EOL;
          }
          echo '</select>';
}




// Creation vignettes images
function imageCreateVignetteJpeg($source,$name){  // $source: chemin de la photo  $name: la destination

// image source
    $img=imagecreatefromjpeg($source);
    
// Taille de l'image
    $size=getimagesize($source);

/*methode de redimension */

// Image de destination (creation de la zone)
    $img_dest=imagecreatetruecolor(200,200);  // parametre de largeur et hauteur

    $img_background=imagecolorallocate($img_dest,255,255,255); // rvb couleur rouge, vert, bleu => couleur blanc
    imagefill($img_dest,0,0,$img_background); // remplir le fond

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

//On spécifie le type de fichier crée (Format de destination et où on le met dans dossier thumb)
    imagejpeg($img_dest,'../thumb/'.$name,60);

    // pour detruire cette image
    imagedestroy($img_dest);
}


function imageCreateVignetteGif($source,$name){  // $source: chemin de la photo  $name: la destination

// image source
    $img=imagecreatefromGif($source);

// Taille de l'image
    $size=getimagesize($source);

    /*methode de redimension */

// Image de destination (creation de la zone)
    $img_dest=imagecreatetruecolor(200,200);  // parametre de largeur et hauteur

    $img_background=imagecolorallocate($img_dest,255,255,0); // rvb couleur rouge, vert, bleu => couleur jaune
    imagefill($img_dest,0,0,$img_background); // remplir le fond


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

//On spécifie le type de fichier crée (Format de destination et où on le met dans dossier thumb)
    imagegif($img_dest,'../thumb/'.$name);

    // pour detruire cette image
    imagedestroy($img_dest);
}

function imageCreateVignettePng($source,$name){  // $source: chemin de la photo  $name: la destination

// image source
    $img=imagecreatefrompng($source);

// Taille de l'image
    $size=getimagesize($source);

    /*methode de redimension */

// Image de destination (creation de la zone)
    $img_dest=imagecreatetruecolor(200,200);  // parametre de largeur et hauteur

    // couleur de fond
    $img_background=imagecolorallocate($img_dest,255,0,255); // rvb couleur rouge, vert, bleu => couleur rose
    imagefill($img_dest,0,0,$img_background); // remplir le fond

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

//On spécifie le type de fichier crée (Format de destination et où on le met dans dossier thumb)
    imagepng($img_dest,'../thumb/'.$name);

    // pour detruire cette image 
    imagedestroy($img_dest);
}

?>
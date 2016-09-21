<?php
session_start();
if(isset($_SESSION['travel'])){
}
else{
    header('Location:index.php');
}
?>


<?php require_once('fonction.php');?>  <!--appel la fonction du fichier 'fonction.php'-->
<?php require_once('../connect.php');?>

<html>

<h2>Ajouter un voyage</h2>
<head>
    <meta charset="utf-8">
    <title>Travel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>

<form method="post" action="SendTravel.php" enctype="multipart/form-data">
    <fieldset>
    <ul class="nav nav-tabs">
        <li class="active"><a href="SendTravel.php">Ajouter un voyage</a></li>
        <li><a href="ListTravel.php">Accueil</a></li>
        <li><a href="info.csv">Téléchargez le fichier csv</a></li>
        <li><a href="Deconnexion.php">Déconnexion</a></li>
    </ul>


     <!-- <legend>Ajouter un voyage</legend>-->
      <p><label>Titre : </label><input type="text" name="title" ></p>  <!--required pour un champs non null-->
      <p><label>Description : </label><br><textarea name="description" ></textarea></p>
      <p><label>Photo : </label><input type="file" name="picture"></p>

      <p><label>Date de départ : </label>
          <?php
          DateCreate('start');
          ?>
          <br></p>

      <p><label>Date de fin : </label>
          <?php
          DateCreate('end');
          ?>
          <br></p>

      <p><label>Prix : </label><input type="text" name="price" value=0></p>

      <p><label>Nombre de voyageurs : </label>
          <!-- creer une liste du nbre de voyageur -->
          <select name="nb_voyageur">
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
              <option value="25">25</option>
              <option value="30">30</option>
          </select>

        </p>

      <p><label>Vaccin : </label><input type="checkbox" name="vaccine"></p>
      <p><label>Enfant de 14 ans minimum : </label><input type="checkbox" name="minage"></p>
      <p><label>Animaux : </label><input type="checkbox" name="animal"></p>
      <p><label>Assurance obligatoire : </label><input type="checkbox" name="insurance"></p>
      <p><label>Permis de conduire obligatoire : </label><input type="checkbox" name="license"></p>
      <P><input type="submit" name="send"><input type="reset"></p>
      
  </fieldset>

</form>



<?php

if (isset($_POST['send']))   // "isset" fonction qui verifie si presence de la variable send ou si la personne a cliquer sur valider
{
    $titre = htmlentities($_POST['title'], ENT_QUOTES); // htmlentities permet de ne pas interpreter le texte entre
    $description = htmlentities($_POST['description'], ENT_QUOTES);

     $datestart = $_POST['startyear'].'-'.$_POST['startmonth'].'-'.$_POST['startday'];
     $dateend = $_POST['endyear'].'-'.$_POST['endmonth'].'-'.$_POST['endday'];

    ///echo $datestart.' '.$dateend;

    $price= VerifNum($_POST['price']);

    $nb_voyageur = $_POST['nb_voyageur'];


    ////// verification des cases a cocher //////
    if (isset($_POST['vaccine'])) {
        $vaccine = 1;
    } else {
        $vaccine = 0;
    }

    if (isset($_POST['minage'])) {
        $minage = 1;
    } else {
        $minage = 0;
    }

    if (isset($_POST['animal'])) {
        $animal = 1;
    } else {
        $animal = 0;
    }

    if (isset($_POST['insurance'])) {
        $insurance = 1;
    } else {
        $insurance = 0;
    }

    if (isset($_POST['license'])) {
        $license = 1;
    } else {
        $license = 0;
    }


    

    /// Controle des fichiers photos ////
    if($_FILES['picture']['error'] !=0)
    {
        switch ($_FILES['picture']['error'])   /// error c'est une des clé de $_FILES
        {
            ///  CAS d'ERREUR  /////
            case 3:
                echo 'Le fichier a été chargé partiellement';
                break;
            /*case 4:
                echo 'Aucun fichier saisi';
            break; */
            case 6:
                echo 'Pas de répertoire temporaire';
                break;
        }
        
        $nom="../img/noimage.jpg";
    }
    else
    {
        ///// VERIFICATION de L'EXTENSION du FICHIER PHOTO /////

        $namenospace=str_replace(' ','',$_FILES['picture']['name']);  //enleve les espaces dans les noms des fichiers
        $namelower=strtolower($namenospace);  // mettre les noms des fichiers photo en minuscules
        $extension= pathinfo($namelower,PATHINFO_EXTENSION);   // extrait l'extension
        $extensionOK=array('jpg','jpeg','gif','png');  // creation d'un tableau avec des extension possibles pour les photos

        if (in_array($extension,$extensionOK))  // on compare les extension avec les extension de $extensionOK
        {
            $destination='../upload/';   //destination des photos dans le dossier upload
            $nom= $destination.$namelower;

            move_uploaded_file($_FILES['picture']['tmp_name'],$nom); // $img

            if ($extension=='jpg' || $extension=='jpeg'){
            
            imageCreateVignetteJpeg($nom,$namelower); // $nom : chemin du fichier  $namelower: nom du fichier en minuscule
            }

            else if ($extension=='gif'){
                imageCreateVignetteGif($nom,$namelower);
            }
            else {
                imageCreateVignettePng($nom,$namelower);
            }
        }
        else
        {
            echo 'L\'extension n\'est pas valide';
            exit();  //on arrete le script a ce niveau
        }
    }

    
    
    // mettre les infos du titre, description, dates et prix dans un fichier .csv
    $monfichier = fopen('info.csv','a+');

    $texte = array($titre,$description,$datestart,$dateend,$price);
    fputcsv($monfichier,$texte,';');

    /*fermer un fichier*/
    fclose($monfichier);



    ///  On insert dans la table
    /** $bdd->exec('INSERT INTO travel
    (titre,description,photo1,date_depart,date_fin,prix,nb_voyageur,vaccin,age_mini,animaux,assurance,permis)
     * VALUES("mytitre","mydescription","myphoto","mydatestart","mydateend","myprice","myvoyageur","myvaccin","myage_mini","myanimaux","myassurance","mypermis")');*/

    $requete = $bdd->prepare('INSERT INTO travel
    (titre,description,photo1,date_depart,date_fin,prix,nb_voyageur,vaccin,age_mini,animaux,assurance,permis)
    VALUES(:mytitre,:mydescription,:myphoto,:mydatestart,:mydateend,:myprice,:myvoyageur,:myvaccin,:myage_mini,:myanimaux,:myassurance,:mypermis)');

    $requete->execute(array(

        'mytitre' => $titre,
        'mydescription' => $description,
        'myphoto' => $nom,
        'mydatestart' => $datestart,
        'mydateend' => $dateend,
        'myprice' => $price,
        'myvoyageur' => $nb_voyageur,
        'myvaccin' => $vaccine,
        'myage_mini' => $minage,
        'myanimaux' => $animal,
        'myassurance' => $insurance,
        'mypermis' => $license
    ));
    

}
?>


</body>
</html>
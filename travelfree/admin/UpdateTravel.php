<?php
session_start();
if(isset($_SESSION['travel'])){
    require_once('../connect.php'); /* pour ce connecter a la BD */
}
else{
    header('Location:index.php');
}
?>

<?php require_once('fonction.php');  //appel la fonction du fichier 'fonction.php'



/// recuperer les infos de la table travel
if(!empty($_GET['id']) && (is_numeric($_GET['id'])))         // verifier si id est renseigné
{
$myid =$_GET['id'];
$requete = $bdd->query('SELECT * FROM travel WHERE id ='.$myid);  // selectionne toutes les donnees de la table travel par son id

$donnees=$requete->fetch();   // fetch cree un tableau associatif clé son les nom des colonnes
}
else
{
header('Location:ListTravel.php');    // renvoi à la listTravel
}
?>



<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Mettre à jour un voyage</title>

            <!-- utilisation de Boostrap  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>

<h2>Modifier les données du voyage</h2>

<?php

if (isset($_POST['send']))   // isset verifie si presence de la variable send ou si la personne a cliquer sur valider
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


    $requete = $bdd->prepare('UPDATE travel SET 
    titre=:mytitre,description=:mydescription,date_depart:mydatestart,date_fin=:mydateend,prix=:myprice,
    nb_voyageur=:myvoyageur,vaccin=:myvaccin,age_mini=:myage_mini,animaux=:myanimaux,assurance=:myassurance,permis=:mypermis WHERE id=:id');

    $requete->execute(array(

        'mytitre' => $titre,
        'mydescription' => $description,
        'mydatestart' => $datestart,
        'mydateend' => $dateend,
        'myprice' => $price,
        'myvoyageur' => $nb_voyageur,
        'myvaccin' => $vaccine,
        'myage_mini' => $minage,
        'myanimaux' => $animal,
        'myassurance' => $insurance,
        'mypermis' => $license,
        'id'=> $myid
    ));

   /* Notification par mail--------------ceci ne marche qu'avec un serveur autre que wamp

    $message ='Le fichier excel est à jour';
    mail('am6andre@gmail.com', 'Mise à jour',$message);*/

    header('Location:ListTravel.php');

}
?>


<form role="form" method="post" action="" enctype="multipart/form-data">
    <fieldset>

        <ul class="nav nav-tabs">
            <li class="active"><a href="UpdateTravel.php">Mise à jour</a></li>
            <!-- <li><a href="UpdateTravel.php">Mise à jour</a></li>-->
            <li><a href="ListTravel.php">Accueil</a></li>
            <li><a href="info.csv">Téléchargez le fichier csv</a></li>
            <li><a href="Deconnexion.php">Déconnexion</a></li>
        </ul>

        <p><label>Titre : </label><input type="text" name="title" value="<?php echo $donnees['titre'] ?>"></p>  <!--"required" pour un champs non null-->
        <p><label>Description : </label><br><textarea name="description"> <?php echo $donnees['description'] ?> </textarea></p>
        <p><label>Photo : </label><input type="file" name="picture"></p>

        <p><label>Date de départ : </label>
            <?php
            //fonction explode() qui va creer un tableau
            $dateexplode= explode('-',$donnees['date_depart']);
            //echo $dateexplode[2];

            /// liste deroulante des jours
                echo '<select name="startday">';
                for ($i=1; $i<31; $i++) {
                    if ($dateexplode[2] == sprintf('%02d', $i)) {
                        echo '<option value="' . sprintf('%02d', $i) . '" selected>' . sprintf('%02d', $i) . '</option>' . PHP_EOL;  //sprintf()pour avoir le zero avant
                    } else {
                        echo '<option value="' . sprintf('%02d', $i) . '">' . sprintf('%02d', $i) . '</option>' . PHP_EOL;
                    }
                }

                echo '</select>';

                /// liste deroulante des mois
            $tabmoi=array('01'=>'Janvier','02'=>'Février','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin','07'=>'Juillet',
             '08'=>'Août','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre');     /// declaration d'un tableau
                echo  '<select name="startmonth">';
                foreach($tabmoi as $cle=>$val)
                {
                    if ($cle== $dateexplode[1])
                    {
                        echo '<option value="' . $cle . '"selected>' . $val . '</option>' . PHP_EOL;
                    }
                    else
                    {
                        echo '<option value="' . $cle . '">' . $val . '</option>' . PHP_EOL;
                    }
                }

            echo '</select>';

            /// liste deroulante des annees
                $year=date('Y');
                echo '<select name="startyear">';
                for($i=$year; $i<=($year +10); $i++)  // +10 pour afficher les 10 dernieres années
                {
                    if ($dateexplode[0] == $i) {
                        echo '<option value="' . $i . '"selected>' . $i . '</option>' . PHP_EOL;
                    } else {
                        echo '<option value="' . $i . '">' . $i . '</option>' . PHP_EOL;

                    }
                }
                    echo '</select>';
            ?>
            <br></p>

        <p><label>Date de fin : </label>

            <?php
            //fonction explode() qui va creer un tableau
            $dateexplode= explode('-',$donnees['date_fin']);
            //echo $dateexplode[2];

            /// liste deroulante des jours
            echo '<select name="endday">';
            for ($i=1; $i<31; $i++) {
                if ($dateexplode[2] == sprintf('%02d', $i)) {
                    echo '<option value="' . sprintf('%02d', $i) . '" selected>' . sprintf('%02d', $i) . '</option>' . PHP_EOL;  //sprintf()pour avoir le zero avant
                } else {
                    echo '<option value="' . sprintf('%02d', $i) . '">' . sprintf('%02d', $i) . '</option>' . PHP_EOL;
                }
            }

            echo '</select>';

            /// liste deroulante des mois
            $tabmoi=array('01'=>'Janvier','02'=>'Février','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin','07'=>'Juillet',
                '08'=>'Août','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre');     /// declaration d'un tableau
            echo  '<select name="endmonth">';
            foreach($tabmoi as $cle=>$val)
            {
                if ($cle== $dateexplode[1])
                {
                    echo '<option value="' . $cle . '"selected>' . $val . '</option>' . PHP_EOL;
                }
                else
                {
                    echo '<option value="' . $cle . '">' . $val . '</option>' . PHP_EOL;
                }
            }

            echo '</select>';

            /// liste deroulante des annees
            $year=date('Y');
            echo '<select name="endyear">';
            for($i=$year; $i<=($year +10); $i++)  // +10 pour afficher les 10 dernieres années
            {
                if ($dateexplode[0] == $i) {
                    echo '<option value="' . $i . '"selected>' . $i . '</option>' . PHP_EOL;
                } else {
                    echo '<option value="' . $i . '">' . $i . '</option>' . PHP_EOL;

                }
            }
            echo '</select>';

            ?>
            <br></p>


        <p><label>Prix : </label><input type="text" name="price" value="<?php echo $donnees['prix'] ?>"></p>

        <p><label>Nombre de voyageurs : </label>
                             <!--             creer une liste du nbre de voyageur                -->
            <!-- <select name="listevoyage">
                <option value="<?php echo $donnees['nb_voyageur'] ?>"><?php echo $donnees['nb_voyageur'] ?></option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="30">30</option>
            </select>  -->

            <!--   autre methode  -->
            <?php
            echo '<select>';
            for($i=10; $i<=25; $i+=5)
            {
                if($donnees['nb_voyageur']==$i ) {
                    echo '<option value="' . $i . '"selected>' . $i . '</option>' . PHP_EOL;
                }
                else
                {
                    echo '<option value="' . $i . '">' . $i . '</option>' . PHP_EOL;
                }
            }
            echo '</select>';
            ?>
        </p>

        <p><label>Vaccin : </label>
            <?php
            if ($donnees['vaccin']==1)
            {
                echo '<input type="checkbox" name="vaccine" checked>';
            }
            else
            {
                echo '<input type="checkbox" name="vaccine">';
            }
            ?>
        </p>

        <p><label>Enfant de 14 ans minimum : </label>
            <?php
            if ($donnees['age_mini']==1)
            {
                echo '<input type="checkbox" name="minage" checked>';
            }
            else
            {
                echo '<input type="checkbox" name="minage">';
            }
            ?>
        </p>

        <p><label>Animaux : </label>
            <?php
            if ($donnees['animaux']==1)
            {
            echo '<input type="checkbox" name="animal" checked>';
            }
            else
            {
            echo '<input type="checkbox" name="animal">';
            }
            ?>
        </p>
        <p><label>Assurance obligatoire : </label>
            <?php
            if ($donnees['assurance']==1)
            {
                echo '<input type="checkbox" name="insurance" checked>';
            }
            else
            {
                echo '<input type="checkbox" name="insurance">';
            }
            ?>
        </p>

        <p><label>Permis de conduire obligatoire : </label>
            <?php
            if ($donnees['permis']==1)
            {
                echo '<input type="checkbox" name="license" checked>';
            }
            else
            {
                echo '<input type="checkbox" name="license">';
            }
            ?>
        </p>
        <p><input type="submit" name="send" class="btn btn-default"></p>
            

    </fieldset>

</form>

</body>
</html>
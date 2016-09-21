<?php
session_start();
if(isset($_SESSION['travel'])){
    require_once('../connect.php');   /* pour ce connecter a la BD */
}
else{
    header('Location:index.php');
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>DetailTravel</title>
</head>

<body>
<table>

    <tr><th>Titre</th><th>Date de depart</th><th>Date de fin</th><th>Prix</th></tr>  <!-- noms des colonnes -->

    <?php

    if(!empty($_GET['id']) && (is_numeric($_GET['id'])))         // verifier si id est renseigné
    {

        $myid =$_GET['id'];
        $requete = $bdd->query('SELECT * FROM travel WHERE id ='.$myid);  // selectionne toutes les donnees de la table travel par son id

        $donnees=$requete->fetch();   // fetch cree un tableau associatif

        $detail= '<h1>';
        $detail.= $donnees['id'].$donnees['titre'];
        $detail.= '</h1>';
        $detail.= '<p>';
        $detail.= $donnees['description'];
        $detail.= '</p>';
        $detail.= '<figure>';
        // ici on change l'image par la vignette (on change le chemin où se trouve la vignette)
        $vignette = str_replace('upload','thumb',$donnees['photo1']);
        $detail.= '<img src="'.$vignette.'">';
        //$detail.= '<img src="'.$donnees['photo1'].'">';  // photo dans la BD
        $detail.= '</figure>';
        $detail.= '<hr>';
        $detail.= '<p>';
        $detail.= 'Date de depart : '.$donnees['date_depart'];
        $detail.= '</p>';
        $detail.= '<p>';
        $detail.= 'Date de fin : '.$donnees['date_fin'];
        $detail.= '</p>';

        // verifier vaccin  //
        if ($donnees['vaccin']==1)
        {
            $detail.= '<p>';
            $detail.= 'Vaccin obligatoire';
            $detail.= '</p>';
        }
        // verifier age  //
        if ($donnees['age_mini']==1)
        {
            $detail.= '<p>';
            $detail.= 'Age minimum 14 ans';
            $detail.= '</p>';
        }
        // verifier animaux  //
        if ($donnees['animaux']==1)
        {
            $detail.= '<p>';
            $detail.= 'Animaux interdit';
            $detail.= '</p>';
        }
        // verifier assurance  //
        if ($donnees['assurance']==1)
        {
            $detail.= '<p>';
            $detail.= 'Assurance obligatoire';
            $detail.= '</p>';
        }
        // verifier permis  //
        if ($donnees['permis']==1)
        {
            $detail.= '<p>';
            $detail.= 'Permis obligatoire';
            $detail.= '</p>';
        }
        echo $detail;
    }
    else
    {
        header('Location:ListTravel.php');    // renvoi à la listTravel
    }

    ?>


</table>

</body>
</html>
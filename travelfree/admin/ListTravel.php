<?php
/* Pour demarrer seulement si identifier */
session_start();
if(isset($_SESSION['travel'])){
    require_once('../connect.php'); /* pour ce connecter a la BD */
}
else{
    header('Location:index.php');
}
?>

<!doctype html>
<html>

<h2>Liste des voyages </h2>
<head>
    <meta charset="utf-8">
    <title>ListTravel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <ul class="nav nav-tabs">
        <li class="active"><a href="ListTravel.php">Accueil</a></li>
        <li><a href="SendTravel.php">Ajouter un voyage</a></li>
        <li><a href="info.csv">Téléchargez le fichier csv</a></li>
        <li><a href="Deconnexion.php">Déconnexion</a></li>
    </ul>
</head>

<body>
<table class="table">

    <tr><th>Titre</th><th>Date de depart</th><th>Date de fin</th><th>Prix</th><th>Detail</th><th>Mise à jour</th><th>Supprimer</th></tr>  <!-- noms des colonnes -->

<?php

$requete = $bdd->query('SELECT * FROM travel ORDER BY id DESC');  // selectionne toutes les donnees de la table travel par son id

while($donnees = $requete->fetch())   // fetch cree un tableau associatif
{
    echo '<tr><td>' . $donnees['titre'].'</td>
        <td>'. $donnees['date_depart'].'</td>
        <td>' . $donnees['date_fin'].'</td>
        <td>'.$donnees['prix'].'</td>
        <td><a href="DetailTravel.php?id='.$donnees['id'].'"class="btn btn-primary">Detail</a></td>  
        <td><a href="UpdateTravel.php?id='.$donnees['id'].'"class="btn btn-info">Mise à jour</a></td>
        <td><a href="DeleteTravel.php?id='.$donnees['id'].'"class="btn btn-danger">Supprimer</a></td></tr>';
}

?>
</table>

</body>
</html>

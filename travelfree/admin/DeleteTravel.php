<?php require_once('../connect.php');  // pour ce connecter a la BD

if(!empty($_GET['id']) && (is_numeric($_GET['id'])))         // verifier si id est renseigné
{
    $bdd->query('DELETE FROM travel WHERE id ='.$_GET['id']);
    header('Location:ListTravel.php');
}

?>
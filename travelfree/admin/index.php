<?php require_once('../connect.php');?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Travel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>

<body>
<p></p>
<div class="alert alert-info">
    <strong>Authentification</strong>
</div>

<form action="" method="post">
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="text" name="log" class="form-control" id="email">
    </div>
    <div class="form-group">
        <label for="pwd">Password</label>
        <input type="text" name="mdp" class="form-control" id="pwd">
    </div>
    <div class="form-group">
        <input type="submit" name="send" class="btn btn-default" value="Connexion"> </input>
        
    </div>

</form>

// page pour ce connecter 
<?php
if(isset($_POST['send'])){
    $log = htmlentities($_POST['log'], ENT_QUOTES);
    $mdp = htmlentities($_POST['mdp'], ENT_QUOTES);

    $mdpHash = crypt($mdp,'toto');
    /*echo $mdpHash; pour avoir le mdp codé dans la BD: 12345=to3OCk4vYljcs et amel=todlJvNFOLznw  */

    $utilisateur = $bdd -> prepare('SELECT * FROM users WHERE email = :mylog AND password = :mymdp ');
    $utilisateur -> execute(array('mylog'=>$log,'mymdp'=>$mdpHash));
    $control = $utilisateur -> fetch();       //on affecte le resultat dans un tableau

    if(($control)){
        session_start();
        $idunique=uniqid();
        $_SESSION['travel']= $idunique;
        header('Location:ListTravel.php');
    }
    else{
        echo '<div class="alert alert-danger" role="alert">Cet utilisateur n\'existe pas !</div>';
    }
}


?>

</body>
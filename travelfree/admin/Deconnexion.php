<?php
/**
 * Creation d'une déconnexion d'une session
 * User: DEV
 * Date: 14/09/2016
 * Time: 15:24
 * 
 */

    session_start();
    session_destroy();
    header('Location:index.php');

?>
<?php   
    session_start();
    unset($_SESSION["nomecliente"]);
    unset($_SESSION["codcliente"]);
    //session_destroy;
    header('Location: ../index.php');
?>

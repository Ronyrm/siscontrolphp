<?php   

session_start();
    unset($_SESSION["nomeusuario"]);
    unset($_SESSION["codusuario"]);
    unset($_SESSION["codunidade"]);
    unset($_SESSION["descunidade"]);
    unset($_SESSION["mesanologado"]);
    unset($_SESSION["descmesanologado"]);
    unset($_SESSION["diainicialmes"]);
    unset($_SESSION["diafinalmes"]);
    unset($_SESSION["mesano"]);
    unset($_SESSION["idgrau1"]);
    unset($_SESSION["idgrau2"]);
    unset($_SESSION["idgrau3"]);
    
    
    
    //session_destroy;
    header('Location: main.php');
?>
<?php
    session_start();
    if (isset($_SESSION["codusuario"])){
        header('Location:Fontes/telas/telaprincipal.php');
    }
    //include_once("connDB.php");
 
?>

<html>
<head>
    <?php include_once("Fontes/corpopag/head.html"); ?>
    <style>
        <?php include_once("css/cabecalho.css"); ?>
    </style>
</head>
<body>
<main id="mainprincipal">
    <?php 
        include_once("Fontes/corpopag/cabecalho.php");  
        include_once("Fontes/telas/telalogin.php");  
    ?>
</main>
</body>
</html>
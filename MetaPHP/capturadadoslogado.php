<?php
    session_start();
    if (!isset($_SESSION["codusuario"])){
        header('Location:../../main.php');
    }

    if (isset($_SESSION["mesanologado"])){
        $mesano = $_SESSION["mesanologado"];
        $descmesano =  $_SESSION["descmesanologado"];
    }
    else{
        echo "primeiravez";
        date_default_timezone_set('America/Sao_Paulo');
        $mesano = date('Y-m');
    
        $descmesano = date('m/Y');
        
        $_SESSION["mesanologado"] = $mesano;
        $_SESSION["descmesanologado"] = $descmesano;
        
    }

    if (isset($_GET["diainicialmes"])){
        $_SESSION["diainicialmes"] = $_GET["diainicialmes"];
        $_SESSION["diafinalmes"]   = $_GET["diafinalmes"];
        $_SESSION["mesano"]        = $_GET["mesanoatt"];
        
        
    }
    else{
        $retorno = "Nao entrou";
    }

    $strmesano= "value='".$mesano."'";
    
    //$strmesano = "<input class='form-control' type='month' ".$strtemp." id='dtmesano'>";

    $codusuario = (isset($_SESSION["codusuario"]))?$_SESSION["codusuario"]:"0";
    $nomeusuario = (isset($_SESSION["nomeusuario"]))?$_SESSION["nomeusuario"]:"0";
    $codunidade = (isset($_SESSION["codunidade"]))?$_SESSION["codunidade"]:"0";
    $descunidade = (isset($_SESSION["descunidade"]))?$_SESSION["descunidade"]:"0";
    $diaini = (isset($_SESSION["diainicialmes"]))?$_SESSION["diainicialmes"]:"0";
    $diafim = (isset($_SESSION["diafinalmes"]))?$_SESSION["diafinalmes"]:"0";
    $mesano = (isset($_SESSION["mesano"]))?$_SESSION["mesano"]:"0";
    $idgrau1 = (isset($_SESSION["idgrau1"]))?$_SESSION["idgrau1"]:"0";
    $idgrau2 = (isset($_SESSION["idgrau2"]))?$_SESSION["idgrau2"]:"0";
    $idgrau3 = (isset($_SESSION["idgrau3"]))?$_SESSION["idgrau3"]:"0";

    
?>
<?php
    session_start();
    if (isset($_GET["indice"])){
      
        $retorno = array();
        $index = $_GET["indice"];
        if (isset($_SESSION["carrinho"][$index])){
        
            $valorbruto = $_SESSION["carrinho"][$index]["valbruto"];
            $valordesc  = $_SESSION["carrinho"][$index]["valdesc"];
            $valorliq   = $_SESSION["carrinho"][$index]["valliquido"];
             
            
            $_SESSION["totais"]["valortotalbruto"]    = $_SESSION["totais"]["valortotalbruto"]    - $valorbruto;
            $_SESSION["totais"]["valortotaldesconto"] = $_SESSION["totais"]["valortotaldesconto"] - $valordesc;
            $_SESSION["totais"]["valortotalliquido"]  = $_SESSION["totais"]["valortotalliquido"]  - $valorliq;
      
            $_SESSION["contadoritens"] = $_SESSION["contadoritens"] - 1;
      
            unset($_SESSION["carrinho"][$index]);
            
            $cont = count($_SESSION["carrinho"]);
            $i = 0;
            
        }
      
  }
  $retorno["carrinho"] = $_SESSION["carrinho"];$retorno["totais"] = $_SESSION["totais"];
  $retorno["contadoritens"]  = $_SESSION["contadoritens"];
  echo json_encode($retorno);
?>
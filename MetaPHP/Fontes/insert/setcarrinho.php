<?php
    session_start();
    $cont = 0;

    $retorno = array();
    $total   = array();
    if (isset($_REQUEST["Item"])){
        
        
        $aItem  = $_REQUEST["Item"]; 
        
        if (!isset($_SESSION["carrinho"])){
            $cont = 0;
            $_SESSION["carrinho"][0] = $aItem;
            $_SESSION["totais"]["valortotalbruto"] = (empty(trim($aItem["valbruto"])))?0:$aItem["valbruto"];
            $_SESSION["totais"]["valortotaldesconto"] = (empty(trim($aItem["valdesc"])))?0:$aItem["valdesc"];
            $_SESSION["totais"]["valortotalliquido"] = (empty(trim($aItem["valliquido"])))?0:$aItem["valliquido"];
            
            
        }
        else{
            $cont = count($_SESSION["carrinho"]);
            
            $_SESSION["carrinho"][$cont] = $aItem;
            
            $valorbruto = (empty(trim($aItem["valbruto"])))?0:$aItem["valbruto"];
            $valordesc  = (empty(trim($aItem["valdesc"])))?0:$aItem["valdesc"];
            $valorliq   = (empty(trim($aItem["valliquido"])))?0:$aItem["valliquido"];
             
            
            $_SESSION["totais"]["valortotalbruto"]    = $_SESSION["totais"]["valortotalbruto"]    + $valorbruto;
            $_SESSION["totais"]["valortotaldesconto"] = $_SESSION["totais"]["valortotaldesconto"] + $valordesc;
            $_SESSION["totais"]["valortotalliquido"]  = $_SESSION["totais"]["valortotalliquido"]  + $valorliq;
        }
        $retorno["carrinho"] = $_SESSION["carrinho"]; 
        $retorno["totais"] = $_SESSION["totais"];
        $retorno["contadoritens"]  = $cont+1;
        $_SESSION["contadoritens"] = $cont+1;
    }
    //echo json_encode(array($total,$retorno));
    echo json_encode($retorno);
    
    
    
    
?>
<?php
    include_once("../../connDB.php");
    $retorno      = array();
    if (isset($_GET["idpedido"]))
    {
        
        $idPed = $_GET["idpedido"];
        $status = $_GET["status"];
        
        
        $strins = "UPDATE TBPEDIDO SET DFSTATUS=? WHERE (DFIDPEDIDO=?);";
        $qry = fbird_prepare($dbh,$strins);
        try
        {
            $ret = ibase_execute($qry,$status,$idPed);
            $retorno["gravou"] = true;
            $retorno["msg"] = "Atualizado";
        }
        catch (Exception $e) 
        {
            $retorno["gravou"] = false;
            $retorno["msg"] = "Falha, ".$e->getMessage();
        }
        fbird_free_query($qry);
    }
    
    fbird_close($dbh);
    echo json_encode($retorno);
        
?>  

<?php
include_once("../../connDB.php");
    $retorno      = array();
    if (isset($_GET["idpedido"]))
    {
        
        $idpedido = $_GET["idpedido"];
        $strcons = "SELECT * FROM TBPEDIDO WHERE DFIDPEDIDO=".$idpedido;
        $numrows = fbird_fetch_row(fbird_query($dbh,$strcons));
        if ($numrows)
        { 
            $strins = "DELETE FROM TBPEDIDO WHERE (DFIDPEDIDO=?);";
            $qry = fbird_prepare($dbh,$strins);
            try
            {
                $ret = fbird_execute($qry,$idpedido);
                $retorno["gravou"] = true;
                $retorno["msg"] = "Excluido:.";
            }
            catch (Exception $e) 
            {
                $retorno["gravou"] = false;
                $retorno["msg"] = "Falha, ".$e->getMessage();
                
            }
            fbird_free_query($qry);
        }
        else
        {
            $retorno["gravou"] = false;
            $retorno["msg"] = "Pedido".$idpedido." não encontrado.";
        }
    }
    fbird_close($dbh);
    echo json_encode($retorno);
    
?>
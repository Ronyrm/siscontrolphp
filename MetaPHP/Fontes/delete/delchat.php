<?php
    include_once("../../connDB.php");
    $retorno      = array();
    if (isset($_GET["idchat"]))
    {
        
        $idchat = $_GET["idchat"];
        $strsql = "SELECT * FROM TBCHAT WHERE DFIDCHAT='".$idchat."'";
        $consulta   = fbird_query($dbh,$strsql);
        
        $numrows = fbird_fetch_row($consulta);
        if($numrows)
        {    
            $strins = "DELETE FROM TBCHAT WHERE (DFIDCHAT=?);";
            $qry = fbird_prepare($dbh,$strins);
            try
            {
                $ret = ibase_execute($qry,$idchat);
                $retorno["gravou"] = true;
                $retorno["msg"] = "Excluido";
            }
            catch (Exception $e) 
            {
                $retorno["gravou"] = false;
                $retorno["msg"] = "Falha, ".$e->getMessage();
            }
        }
        else
        {
            $retorno["sucesso"] = false;
            $retorno["msg"] = "Nenhum Registro encontrado";
        }
        fbird_close($dbh);
        echo json_encode($retorno);
    }
?>
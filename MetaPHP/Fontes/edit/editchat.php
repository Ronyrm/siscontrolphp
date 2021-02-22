<?php
    include_once("../../connDB.php");
    $retorno      = array();
    if (isset($_POST["idchat"]))
    {
        
        $idchat = $_POST["idchat"];
        $nomechat = $_POST["nomechat"];
        
        $strsql = "SELECT * FROM TBCHAT WHERE DFIDCHAT='".$idchat."'";
        $consulta   = fbird_query($dbh,$strsql);
        
        $numrows = fbird_fetch_row($consulta);
        if($numrows)
        {    
            $strins = "UPDATE TBCHAT SET DFNOME=? WHERE (DFIDCHAT=?);";
            $qry = fbird_prepare($dbh,$strins);
            try
            {
                $ret = ibase_execute($qry,strtoupper($nomechat),$idchat);
          
                
                $retorno["gravou"] = true;
                $retorno["msg"] = "Alterado com Sucesso";
            }
            catch (Exception $e) 
            {
                
                $retorno["gravou"] = false;
                $retorno["msg"] = "Falha, ".$e->getMessage();
            }
        }
        else
        {
        
            $retorno["gravou"] = false;
            $retorno["msg"] = "Nenhum Registro encontrado";
        }
        
            
            
        
        
        fbird_close($dbh);
        echo json_encode($retorno);
    }
?>
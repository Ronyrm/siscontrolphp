<?php
    include_once("../../connDB.php");
    $retorno      = array();
    if (isset($_POST["nomechat"]))
    {
        $nomechat = $_POST["nomechat"];
        $SqlStr = "SELECT * FROM TBCHAT WHERE DFNOME='".strtoupper($nomechat)."' OR ".
                  "DFNOME='".strtolower($nomechat)."' ";
        $consulta   = fbird_query($dbh,$SqlStr);
        $numrows = fbird_fetch_row($consulta);
        if ($numrows>=1)
        {
            
            $retorno["gravou"] = false;
            $retorno["msg"] = 'Chat com o mesmo nome Cadastrado';
            
        }
        else
        {
            $strins = "INSERT INTO TBCHAT(DFNOME) VALUES(?);";
            $qry = fbird_prepare($dbh,$strins);
            ibase_execute($qry,strtoupper($nomechat));
            
            $retorno["gravou"] = true;
            $retorno["msg"] = 'Cadastrado com sucesso';
        }
        fbird_free_result($consulta); 
        fbird_close($dbh);
        echo json_encode($retorno);
    }
?>
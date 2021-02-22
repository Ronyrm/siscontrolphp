<?php
    include_once("../../connDB.php");
    $retorno      = array();
    $SqlStr = "SELECT * FROM TBUSUARIO";
    $consulta   = fbird_query($dbh,$SqlStr);
    if ($consulta)
    {
        $cont = 0;
        while ($linha = fbird_fetch_object($consulta))
        {
            $retorno[$cont]["id" ] = ($linha->DFIDUSUARIO);
            $retorno[$cont]["nome"] = ($linha->DFNOMEUSUARIO);
            $retorno[$cont]["login"] = ($linha->DFLOGINUSUARIO);
            $cont+=1;
        }
    }
        
    fbird_free_result($consulta); 
    fbird_close($dbh);
    echo json_encode($retorno);

?>
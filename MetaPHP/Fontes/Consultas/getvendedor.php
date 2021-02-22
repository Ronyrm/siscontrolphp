<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campovendedor"]))
    {
        $isnumero = $_GET["isnumeric"];
        $CampoVendedor = isset($_GET["campovendedor"]) ? $_GET["campovendedor"] :"";
        
        $SqlStr = 'SELECT VE.dfidvendedor,PE.dfnomepessoa AS NOMEVENDEDOR FROM TBVENDEDOR VE';
        $SqlStr .=' LEFT JOIN TBPESSOA PE ON VE.dfidpessoa= PE.dfidpessoa';
        
        if($isnumero=="true"){
            $SqlStr .= " WHERE VE.DFIDVENDEDOR=".$CampoVendedor;
        }
        else{
            $SqlStr .= " WHERE (PE.dfnomepessoa LIKE '%".$CampoVendedor."%')";
        }
        $capturavendedor   = fbird_query($dbh,$SqlStr);
        if($capturavendedor){
            while ($linha = fbird_fetch_object($capturavendedor)){
                $retorno[$cont]["Vendedor"]["idvendedor"] = $linha->DFIDVENDEDOR;
                $retorno[$cont]["Vendedor"]["nomevendedor"] = utf8_encode($linha->NOMEVENDEDOR);
                $cont = $cont + 1;
            }
                
        }
        fbird_free_result($capturavendedor);
    }
    
        
    
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>
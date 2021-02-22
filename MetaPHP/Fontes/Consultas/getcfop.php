<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campoCFOP"]))
    {
        $CampoCfop = isset($_GET["campoCFOP"]) ? $_GET["campoCFOP"] :"";
        $SqlStr  = 'SELECT * FROM tbnatoperacao NT';
        $SqlStr .= " WHERE NT.dfnatoperacao LIKE '%".$CampoCfop."%' OR NT.dfdescnatoperacao LIKE '%".$CampoCfop."%'";
        
        
        $capturaCFOP   = fbird_query($dbh,$SqlStr);
        if($capturaCFOP){
            
            while ($linha = fbird_fetch_object($capturaCFOP)){
                $retorno[$cont]["CFOP"]["idCFOP"] = $linha->DFIDNUMNATOPERACAO;
                $retorno[$cont]["CFOP"]["CFOP"] = $linha->DFNATOPERACAO;
                $retorno[$cont]["CFOP"]["descCFOP"] = utf8_encode($linha->DFDESCNATOPERACAO);
                $cont = $cont + 1;
            }
                
        }
        fbird_free_result($capturaCFOP);
    }
    
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>
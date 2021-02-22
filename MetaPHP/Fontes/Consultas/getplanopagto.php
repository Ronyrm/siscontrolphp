<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campoplanopagto"]))
    {
        $isnumero = $_GET["isnumeric"];
        $CampoPlanoPagto = isset($_GET["campoplanopagto"]) ? $_GET["campoplanopagto"] :"";
        
        $SqlStr = 'SELECT PG.dfidplanopagamento,PG.dfdescplanopagamento FROM tbplanopagamento PG';
        
        if($isnumero=="true"){
            $SqlStr .= " WHERE PG.DFIDPLANOPAGAMENTO=".$CampoPlanoPagto;
        }
        else{
            $SqlStr .= " WHERE (PG.dfdescplanopagamento LIKE '%".$CampoPlanoPagto."%')";
        
        }
        
        $CapturaPlanoPagto   = fbird_query($dbh,$SqlStr);
        if($CapturaPlanoPagto){
            while ($linha = fbird_fetch_object($CapturaPlanoPagto)){
                $retorno[$cont]["planopagto"]["idplanopagto"] = $linha->DFIDPLANOPAGAMENTO;
                $retorno[$cont]["planopagto"]["nomeplanopagto"] = utf8_encode($linha->DFDESCPLANOPAGAMENTO);
                $cont = $cont + 1;
            }
                
        }
        
        fbird_free_result($CapturaPlanoPagto);
    }
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>


<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campotransportador"]))
    {
        $isnumero = $_GET["isnumeric"];
        $CampoTransportador = isset($_GET["campotransportador"]) ? $_GET["campotransportador"] :"";
        
        $SqlStr = 'SELECT TR.dfidtransportador, PE.dfnomepessoa AS NOMETRANSPORTADOR FROM tbtransportador TR';
        $SqlStr .= ' INNER JOIN tbpessoa PE ON TR.dfidpessoa = PE.dfidpessoa';
        
        if($isnumero=="true"){
            $SqlStr .= " WHERE TR.dfidtransportador=".$CampoTransportador;
        }
        else{
            $SqlStr .= " WHERE (PE.DFNOMEPESSOA LIKE '%".$CampoTransportador."%')";
        }
        $CampoTransportador   = fbird_query($dbh,$SqlStr);
        if($CampoTransportador){
            while ($linha = fbird_fetch_object($CampoTransportador)){
                $retorno[$cont]["transportador"]["idtransportador"] = $linha->DFIDTRANSPORTADOR;
                $retorno[$cont]["transportador"]["nometransportador"] = utf8_encode($linha->NOMETRANSPORTADOR);
                $cont = $cont + 1;
            }
                
        }
        fbird_free_result($CampoTransportador);
    }
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>


<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campoportador"]))
    {
        $isnumero = $_GET["isnumeric"];
        $CampoPortador = isset($_GET["campoportador"]) ? $_GET["campoportador"] :"";
        
        $SqlStr = 'SELECT PO.dfidportador,PO.dfdescportador FROM TBPORTADOR PO';
        
        if($isnumero=="true"){
            $SqlStr .= " WHERE PO.DFIDPORTADOR=".$CampoPortador;
        }
        else{

            $SqlStr .= " WHERE (PO.dfdescportador LIKE '%".$CampoPortador."%')";
        }
        
        $ResultPortador   = fbird_query($dbh,$SqlStr);
        if($ResultPortador){
            while ($linha = fbird_fetch_object($ResultPortador)){
                $retorno[$cont]["portador"]["idportador"] = $linha->DFIDPORTADOR;
                $retorno[$cont]["portador"]["nomeportador"] = utf8_encode($linha->DFDESCPORTADOR);
                $cont = $cont + 1;
            }
                
        }
        
        fbird_free_result($ResultPortador);
    }
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>

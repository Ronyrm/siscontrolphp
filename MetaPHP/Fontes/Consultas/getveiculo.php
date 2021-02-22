<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campoveiculo"]))
    {
        $isnumero = $_GET["isnumeric"];
        $CampoVeiculo = isset($_GET["campoveiculo"]) ? $_GET["campoveiculo"] :"";
        
        $SqlStr = 'SELECT VE.dfidveiculo,VE.dfdescveiculo,VE.dfplacaveiculo, VE.dfidufplaca FROM TBVEICULO VE';
        
        if($isnumero=="true"){
            $SqlStr .= " WHERE VE.DFIDVEICULO=".$CampoVeiculo;
        }
        else{
            $SqlStr .= " WHERE (VE.dfdescveiculo LIKE '%".$CampoVeiculo."%')";
        }
        $capturaveiculo   = fbird_query($dbh,$SqlStr);
        if($capturaveiculo){
            while ($linha = fbird_fetch_object($capturaveiculo)){
                $retorno[$cont]["veiculo"]["idveiculo"] = $linha->DFIDVEICULO;
                $retorno[$cont]["veiculo"]["nomeveiculo"] = utf8_encode($linha->DFDESCVEICULO);
                $retorno[$cont]["veiculo"]["placaveiculo"] = $linha->DFPLACAVEICULO;
                $retorno[$cont]["veiculo"]["ufplaca"] = $linha->DFIDUFPLACA;
                $cont = $cont + 1;
            }
                
        }
        fbird_free_result($capturaveiculo);
    }
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>
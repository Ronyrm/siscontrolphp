<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campoproduto"]))
    {
        $isnumero = $_GET["isnumeric"];
        $CampoProduto = isset($_GET["campoproduto"]) ? $_GET["campoproduto"] :"";
        
        $SqlStr = 'SELECT PR.dfidproduto, pr.dfeanproduto, pr.dfdunproduto,PR.dfdescproduto,PR.dfunidmedidaproduto FROM TBPRODUTODT PR';
        
        if($isnumero=="true"){
            $SqlStr .= " WHERE PR.dfidproduto=".$CampoProduto." OR PR.dfeanproduto='".$CampoProduto."'";
        }
        else{
            $SqlStr .= " WHERE (PR.dfdescproduto LIKE '%".$CampoProduto."%')";
        }
        $capturaproduto   = fbird_query($dbh,$SqlStr);
        if($capturaproduto){
            
            while ($linha = fbird_fetch_object($capturaproduto)){
                
                $retorno[$cont]["Produto"]["idproduto"] = $linha->DFIDPRODUTO;
                $retorno[$cont]["Produto"]["descproduto"] = utf8_encode($linha->DFDESCPRODUTO);
                $retorno[$cont]["Produto"]["unidademedida"] = $linha->DFUNIDMEDIDAPRODUTO;
                $cont = $cont + 1;
            }
                
        }
        fbird_free_result($capturaproduto);
    }
    
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>
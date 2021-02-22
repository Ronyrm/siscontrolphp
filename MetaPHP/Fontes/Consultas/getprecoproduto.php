<?php

    include_once("../../connDB.php");

    $result = array();
    $result["achou"] = false;
    
    
    if (isset($_POST["adados"])){
        
        $result["achou"] = true;
        
        $adados = $_REQUEST["adados"];
        $result["dados"] = $adados ;
        $result["preco"] = 0.50;
        
        $continua = true; 
        
        $idplanopagto = $adados["idplanopagto"];
        $idunidade = $adados["idunidade"];
        $identidade = $adados["identidade"];
        $entidade = $adados["entidade"];
        $idvendedor = $adados["idvendedor"];
        $idlocalentrega = $adados["idlocalentrega"];
        $idmicroconta = $adados["idmicroconta"];
        $idproduto = $adados["idproduto"];
        
        if(strlen($idmicroconta)>0){
            $tipopreco = "";
            $strsql = "SELECT DfTipoPreco FROM tbTransFiscal WHERE DfIdTransFiscal=".$idmicroconta;
            $resulttppreco = fbird_query($dbh,$strsql);
            if($resulttppreco){
                $row = fbird_fetch_object($resulttppreco);
                $tipopreco = $row -> DFTIPOPRECO;
            }
            fbird_free_result($resulttppreco);
            
            if ($tipopreco != "V"){
                // Custo Medio e Custo Unitario
                $strsql  = "SELECT DfCustoMedio, DfCustoUnitario FROM tbProdutoEstoque ";
                $strsql .= "WHERE DfIdUnidade=".$idunidade." AND DfIdProduto=".$idproduto;
                
                $resulcusto = fbird_query($dbh,$strsql);
                
                if($resulcusto){
                    $row = fbird_fetch_object($resulcusto);
                    $customedio = $row -> DFCUSTOMEDIO;
                    $custount   = $row -> DFCUSTOUNITARIO;
                }
                
                fbird_free_result($resulcusto);
                
                switch ($tipopreco){
                    case "U":
                        $continua = false;
                        $result["preco"] = (empty($custount)?0:$custount);
                        break;
                    case "M":
                        $continua = false;
                        $result["preco"] = (empty($customedio)?0:$customedio);
                        break;
                    default: 
                        $result["preco"] = 2;
                        $continua = true;
                }
                
            }else{ $continua = true;}
        }
        
        while($continua)
        {
            $preco = 1;
            $result["preco"] = 0.25;    
            $strsql="SELECT DfPreco FROM tbPlanoPagamento WHERE DfIdPlanoPagamento=".$idplanopagto;
            $resulpreco = fbird_query($dbh,$strsql);
            if($resulpreco)
            {
                $row = fbird_fetch_object($resulpreco);
                $preco = $row -> DFPRECO;
                $preco = $preco + 1;
                $result["preco"] = $preco;
                $continua = false;
                        
            }
            
            fbird_free_result($resulpreco);
            
            if(strlen($idvendedor)>0){
                $tipotabpreco="";
                $strsql = "SELECT DfTipoTabPreco FROM tbVendedor WHERE DfIdVendedor=".$idvendedor;
                $resultipotabpreco = fbird_query($dbh,$strsql);
                if($resultipotabpreco){
                    $row = fbird_fetch_object($resultipotabpreco);
                    $tipotabpreco = $row -> DFTIPOTABPRECO;
                }
                fbird_free_result($resultipotabpreco);
                if($tipotabpreco=="P")
                {
                    $dfpreco = 0;
                    $strsql  = "SELECT DFPRECO".$preco." AS DFPRECO ";
                    $strsql .= "FROM tbTabPreco WHERE (DfTipoTabela= 'V') AND (DFCODTABPRECO=".$idvendedor.") ";  
                    $strsql .= "AND (DfIdProduto=".$idproduto.")";
                    
                    $resulpreco = fbird_query($dbh,$strsql);
                    if($resulpreco){
                        $row = fbird_fetch_object($resulpreco);
                        $dfpreco = $row -> DFPRECO;
                    }
                    fbird_free_result($resulpreco);
                    
                    if ((strlen($dfpreco) > 0) && ($dfpreco>0)  ){
                        $result["preco"] = $dfpreco;
                        $continua = false;
                        break;
                    }
                }
                else{
                    $result["preco"] = 0;
                    $continua = true;
                }
                
            }
            if((strlen($identidade)>0) && ($entidade==0)){
                $idrede = 0;
                $strsql = "SELECT DFIDREDE FROM TBCLIENTE WHERE DFIDCLIENTE=".$identidade;
                
                $resulrede = fbird_query($dbh,$strsql);
                if($resulrede){
                    $row = fbird_fetch_object($resulrede);
                    $idrede = $row -> DFIDREDE;
                }
                fbird_free_result($resulrede);
                
                $tipotabpreco = "";
                $strsql ="SELECT DfTipoTabPreco FROM TBREDE WHERE DFIDREDE=".$idrede;
                $resultabpreco = fbird_query($dbh,$strsql);
                
                if($resultabpreco){
                    $row = fbird_fetch_object($resultabpreco);
                    $tipotabpreco = $row -> DFTIPOTABPRECO;
                }
                
                fbird_free_result($resultabpreco);
                if ($tipotabpreco == "P")
                {
                    $dfpreco = 0;
                    $strsql  = "SELECT DFPRECO".$preco." AS DFPRECO ";
                    $strsql .= "FROM tbTabPreco WHERE (DfTipoTabela= 'R') AND (DFCODTABPRECO=".$idrede.") ";  
                    $strsql .= "AND (DfIdProduto=".$idproduto.")";
                    
                    $resulpreco = fbird_query($dbh,$strsql);
                    if($resulpreco){
                        $row = fbird_fetch_object($resulpreco);
                        $dfpreco = $row -> DFPRECO;
                    }
                    fbird_free_result($resulpreco);
                    
                    if ((strlen($dfpreco) > 0) && ($dfpreco>0)  ){
                        $result["preco"] = $dfpreco;
                        $continua = false;
                        break;
                    }
                }
                else{
                    $result["preco"] = 0;
                    $continua = true;
                }
            }
            if(strlen($idlocalentrega)>0){
                $idpes = -1;
                
                $strsql = "SELECT DfTipoTabPreco, DfIdPessoa FROM tbEndereco WHERE DfIdEndereco=".$idlocalentrega;
                $resullocal = fbird_query($dbh,$strsql);
                if($resullocal){
                    $row = fbird_fetch_object($resullocal);
                    $tipotabpreco = $row -> DFTIPOTABPRECO;
                    $idpes        = $row -> DFIDPESSOA;
                }
                fbird_free_result($resullocal);
                
                switch ($tipotabpreco){
                    case "P":
                        $tipotabela = "L";
                        $idtabpreco = $idlocalentrega;
                        break;
                    case "C":
                        $tipotabela = "C";
                        $idtabpreco = $idpes;
                        break;
                    default:
                        $tipotabela = "WW";
                }
                
                if ($tipotabela != "WW"){
                    $dfpreco = 0;
                    $strsql  = "SELECT DFPRECO".$preco." AS DFPRECO ";
                    $strsql .= "FROM tbTabPreco WHERE (DfTipoTabela="."'".$tipotabela."'".") AND (DFCODTABPRECO=".$idtabpreco.") ";  
                    $strsql .= "AND (DfIdProduto=".$idproduto.")";

                    $resulpreco = fbird_query($dbh,$strsql);
                    if($resulpreco){
                        $row = fbird_fetch_object($resulpreco);
                        $dfpreco = $row -> DFPRECO;
                    }
                    fbird_free_result($resulpreco);

                    if ((strlen($dfpreco) > 0) && ($dfpreco>0)  ){
                        $result["preco"] = $dfpreco;
                        $continua = false;
                        break;
                    }

                }
                else{
                    $continua = true;
                    $result["preco"] = 0;
                }
            }  
            if((strlen($identidade)>0) && ($entidade==0)){
                $tipotabpreco = "";
                
                $strsql = "SELECT DfTipoTabPreco FROM tbCliente WHERE DfIdCliente=".$identidade;
                
                $resulclient = fbird_query($dbh,$strsql);
                if($resulclient)
                {
                    $row = fbird_fetch_object($resulclient);
                    $tipotabpreco = $row -> DFTIPOTABPRECO;
                }
                fbird_free_result($resulclient);
                if ($tipotabpreco == "P")
                {
                    $dfpreco = 0;
                    $strsql  = "SELECT DFPRECO".$preco." AS DFPRECO ";
                    $strsql .= "FROM tbTabPreco WHERE (DfTipoTabela='C') AND (DFCODTABPRECO=".$identidade.") ";  
                    $strsql .= "AND (DfIdProduto=".$idproduto.")";

                    $resulpreco = fbird_query($dbh,$strsql);
                    if($resulpreco){
                        $row = fbird_fetch_object($resulpreco);
                        $dfpreco = $row -> DFPRECO;
                    }
                    fbird_free_result($resulpreco);

                    if ((strlen($dfpreco) > 0) && ($dfpreco>0)  ){
                        $result["preco"] = $dfpreco;
                        $continua = false;
                        break;
                    } 
                }
            }
            
            if($continua){
                $dfpreco = 0;
                $strsql  = "SELECT DFPRECO".$preco." AS DFPRECO ";
                $strsql .= "FROM tbTabPreco WHERE (DfTipoTabela='G')";
                $strsql .= "AND (DfIdProduto=".$idproduto.")";

                $resulpreco = fbird_query($dbh,$strsql);
                if($resulpreco){
                    $row = fbird_fetch_object($resulpreco);
                    $dfpreco = $row -> DFPRECO;
                }
                fbird_free_result($resulpreco);

                if ((strlen($dfpreco) > 0) && ($dfpreco>0)  ){
                    $result["preco"] = $dfpreco;
                    $continua = false;
                    break;
                }
                else{
                    $result["preco"] = 0;
                    $continua = false;
                    break;
                }
            }
            
        }
        
    }
    else{
        $result["preco"] = 0;
    }
    
    
    fbird_close($dbh);
    echo json_encode($result);

?>
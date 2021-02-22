<?php
    
    include_once("../../connDB.php");

    $result = array();
    $result["status"] = "N";
    $continua = true;
    if (isset($_POST["adados"])){
        
        $arraydados = $_REQUEST["adados"];
        
        $entidade         = $arraydados["entidade"];
        $identidade       = intval($arraydados["identidade"]);
        $idunidade        = $arraydados["idunidade"];
        $istransfiscal    = $arraydados["istransf"];
        $istransfiscalent = $arraydados["istransfent"];
        $produto          = $arraydados["produto"];
        $isentrada        = $arraydados["isentrada"];
        $idpropriedade    = $arraydados["idpropriedade"];
        $idmicroconta     = $arraydados["idmicroconta"];
        
        
        
        $StrWhere = "";
        $strinner = "";
        switch ($entidade) {
            case 0: // CLIENTE
                $NomeTabela = "TBCLIENTE EN";
                $StrWhere = "EN.DfIdCliente=".$identidade;
                break;
            case 1: // FORNECEDOR
                $NomeTabela = "TBFORNECEDOR EN";
                $StrWhere = "EN.DfIdFornecedor=".$identidade;
                break;
            case 2:// PRODUTOR
                
                if ( $idpropriedade == 0 )
                {
                    $NomeTabela = "TBPRODUTOR EN";
                    $StrWhere = "EN.DFIDPRODUTOR=".$identidade;
                }
                else
                {
                    $NomeTabela = "TBPROPRIEDADE PR "; 
                    $strinner   = "INNER JOIN TBPRODUTOR EN ON PR.DFIDPRODUTOR=EN.DFIDPRODUTOR";
                    $StrWhere = "PR.DFIDPROPRIEDADE=".$idpropriedade;
                }
                
                break;
                
            case 3:// VENDEDOR
                $NomeTabela = "tbvendedor EN";
                $StrWhere = "EN.DFIDVENDEDOR=".$identidade;
                break;
            case 4:// FUNCIONARIO
                $NomeTabela = "tbfuncionario EN";
                $StrWhere = "EN.DfIdFuncionario=".$identidade;
                break;
            case 5://REPRESENTANTE
                $NomeTabela = "tbvendedor EN";
                $StrWhere = "(EN.DFIDVENDEDOR=".$identidade+") AND (DfRepresentante='S')";
                break;
            case 6://CARRETEIRO
                $NomeTabela = "tbcarreteiro EN";
                $StrWhere = "EN.DfIdCarreteiro=".$identidade;
                break;
            case 7://PROMOTOR
                $NomeTabela = "TBVENDEDOR EN";
                $StrWhere = "(EN.DFIDVENDEDOR=".$identidade+") AND (EN.DFPROMOTOR='S')";
                break;
            case 8:
                $NomeTabela = "TBTRANSPORTADOR EN";
                $StrWhere = "EN.DfIdTransportador=".$identidade;
                break;
            case 9:
                $NomeTabela = "TBDEPARTAMENTO EN";
                $StrWhere = "EN.DFIDDEPARTAMENTO=".$identidade;
                $strinner = " INNER JOIN tbUnidade u ON u.DfIdUnidade=EN.DfIdUnidade ";
                break;
            case 10:
                $NomeTabela = "TBUNIDADE EN";
                $StrWhere = "EN.DFIDUNIDADE=".$identidade;
                break;
        }
        
        $strsql  = " SELECT DfIdSiglaUF, p.DFTIPOATIVECONOMICA FROM ". $NomeTabela; 
        $strsql .= $strinner;
        $strsql .= " INNER JOIN tbPessoa p ON p.DfIdPessoa=EN.DfIdPessoa";
        $strsql .= " INNER JOIN tbEndereco e ON e.DfIdPessoa=EN.DfIdPessoa AND DfTipoEndereco=0";
        $strsql .= " INNER JOIN tbMunicipio m ON m.DfIdMunicipio=e.DfIdMunicipio";
        $strsql .= " WHERE ".$StrWhere;
        
        
        
        $UFEntidade = "";
        $tipoAtividade = -1;
        
        $ResultSigla   = fbird_query($dbh,$strsql);
        
        if($ResultSigla){
            $row = fbird_fetch_object($ResultSigla);
            $UFEntidade    = $row -> DFIDSIGLAUF;
            $tipoAtividade = $row -> DFTIPOATIVECONOMICA;
            
            $result["result_enti"]["UFentidade"] = $UFEntidade;
            $result["result_enti"]["ativEntidade_Enti"] = $tipoAtividade;
        }
        fbird_free_result($ResultSigla);
        
  
        $CampoAtividade ="";
        
        if (strlen($produto) != 0 ){
            
            switch ($tipoAtividade) {
                case -1: 
                    $CampoAtividade  = "DFIDNATOPERCOMERCIO"; //COMÉRCIO  
                    break;
                case 0: 
                    $CampoAtividade  = "DFIDNATOPERCOMERCIO"; //COMÉRCIO
                    break;
                case 1:
                    $CampoAtividade  = "DFIDNATOPERINDUSTRIA";//INDÚSTRIA
                    break;
                case 2: 
                    $CampoAtividade  = "DFIDNATOPERCONSUMIDOR";//CONSUMIDOR
                    break;
                case 3: 
                    $CampoAtividade  = "DFIDNATOPERPRODRURAL";//PROD. RURAL
                    break;
                case 4: 
                    $CampoAtividade  = "DFIDNATOPERTRANSFERENCIA"; //Transferencia
                    break;
            }
            
            if($istransfiscal){
                $CampoAtividade = (($istransfiscalent) ? "DFIDNATOPERTRANSFERENCIAENT" : "DFIDNATOPERTRANSFERENCIASAI"); 
            }
            
            
            if ($isentrada){
                $CampoAtividade = 'DFIDNATOPERENTRADA';
            }
            
            
            $strsql  = "SELECT NAT.DFIDNUMNATOPERACAO,NAT.DFNATOPERACAO,NAT.DFDESCNATOPERACAO FROM TBPRODUTODT PDT";
            $strsql .= " LEFT JOIN TBTRIBNFESTADO TBE ON TBE.DFIDTRIBNF=PDT.DFIDTRIBNF";
            $strsql .= " LEFT JOIN TBNATOPERACAO NAT ON NAT.DFIDNUMNATOPERACAO=TBE.".$CampoAtividade;
            $strsql .= " WHERE PDT.DFIDPRODUTO='".$produto."' AND TBE.DFIDSIGLAUF='".$UFEntidade."'";
            $strsql .= " and tbe.dfidunidade=".$idunidade;
            
            $ResultCfop   = fbird_query($dbh,$strsql);
            if($ResultCfop){
                $row = fbird_fetch_object($ResultCfop);
                $NatOperacao   = $row -> DFNATOPERACAO;
                $IdNatOperacao = $row -> DFIDNUMNATOPERACAO;
                $descNatOper   = utf8_encode($row -> DFDESCNATOPERACAO);
            }
            fbird_free_result($ResultCfop);
            
            if ($NatOperacao!=""){
                $result["retorno"]["NumCFOP"]   = $NatOperacao;
                $result["retorno"]["idCFOP"]    = $IdNatOperacao;
                $result["retorno"]["descCFOP"]  = $NatOperacao." - ".$descNatOper;
                $continua = false;
            }
        }
        
        if ($continua){
        
            $strsql = "SELECT DfIdSiglaUF FROM tbUnidade u";
            $strsql .= " INNER JOIN tbPessoa p ON p.DfIdPessoa=u.DfIdPessoa";
            $strsql .= " INNER JOIN tbEndereco e ON e.DfIdPessoa=u.DfIdPessoa AND DfTipoEndereco=0";
            $strsql .= " INNER JOIN tbMunicipio m ON m.DfIdMunicipio=e.DfIdMunicipio";    
            $strsql .= " WHERE DfIdUnidade=".$idunidade;
            
            $ResultUFUni   = fbird_query($dbh,$strsql);
            
            if($ResultUFUni){
                $row = fbird_fetch_object($ResultUFUni);
                $UFUnidade    = $row -> DFIDSIGLAUF;
                $result["result_unidade"]["UFunidade"] = $UFUnidade;
            
            }
            fbird_free_result($ResultUFUni);
            
            $TipoEstadoCFOP = (($UFEntidade!=$UFUnidade) ? "DfIdNatOpInterEstad" : "DfIdNatOperEstadual");
            
            $strsql  = "SELECT NAT.DFIDNUMNATOPERACAO,NAT.DFNATOPERACAO,NAT.DFDESCNATOPERACAO FROM tbTransFiscal TF ";
            $strsql .= "LEFT JOIN tbNatOperacao NAT ON TF.".$TipoEstadoCFOP."=NAT.DfIdNumNatOperacao ";
            $strsql .= "WHERE DfIdTransFiscal=".$idmicroconta;
            
            $ResultCFOP   = fbird_query($dbh,$strsql);
            
            if($ResultCFOP){
                $row = fbird_fetch_object($ResultCFOP);
                $result["retorno"]["NumCFOP"]   = $row -> DFNATOPERACAO;
                $result["retorno"]["idCFOP"] = $row -> DFIDNUMNATOPERACAO;
                $result["retorno"]["descCFOP"] = $row -> DFNATOPERACAO." - ".utf8_encode($row -> DFDESCNATOPERACAO);
            }
            fbird_free_result($ResultCFOP);
                
        }
        
        
        $result["dados"] = $arraydados;
        $result["status"] = "S";
    }
    else{
        $result["status"] =  "N";
    }

    fbird_close($dbh);
    echo json_encode($result);

?>
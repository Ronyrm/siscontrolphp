<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campoentidade"]))
    {
        $isnumero = $_GET["isnumeric"];
        $CampoEntidade = isset($_GET["campoentidade"]) ? $_GET["campoentidade"] :"";
        $Entidade = isset($_GET["entidade"]) ? $_GET["entidade"] :"";
        
        
        
        $NomeTabela  = "";
        $NomeIdCampo = "";
        
        switch ($Entidade) {
            case 0: // CLIENTE
                $NomeTabela = "TBCLIENTE EN";
                $NomeCampo  = "EN.DFIDCLIENTE"; 
                break;
            case 1: // FORNECEDOR
                $NomeTabela = "TBFORNECEDOR EN";
                $NomeCampo  = "EN.DFIDFORNECEDOR"; 
                break;
            case 2:// PRODUTOR
                $NomeTabela = "TBPRODUTOR EN";
                $NomeCampo  = "EN.DFIDPRODUTOR"; 
                break;
            case 3:// VENDEDOR
                $NomeTabela = "tbvendedor EN";
                $NomeCampo  = "EN.DFIDVENDEDOR"; 
                break;
            case 4:// FUNCIONARIO
                $NomeTabela = "tbfuncionario EN";
                $NomeCampo  = "EN.DFIDFUNCIONARIO"; 
                break;
            case 5://REPRESENTANTE
                $NomeTabela = "tbvendedor EN";
                $NomeCampo  = "EN.DFIDVENDEDOR"; 
                break;
            case 6://CARRETEIRO
                $NomeTabela = "tbcarreteiro EN";
                $NomeCampo  = "EN.DFIDCARRETEIRO"; 
                break;
            case 7://PROMOTOR
                $NomeTabela = "TBVENDEDOR EN";
                $NomeCampo  = "EN.DFPROMOTOR='S' AND EN.DFIDVENDEDOR"; 
                break;
            case 8:
                $NomeTabela = "TBTRANSPORTADOR EN";
                $NomeCampo  = "EN.DFIDTRANSPORTADOR"; 
                break;
            case 9:
                $NomeTabela = "TBDEPARTAMENTO EN";
                $NomeCampo  = "EN.DfIdDepartamento"; 
                break;
            case 10:
                $NomeTabela = "TBUNIDADE EN";
                $NomeCampo  = "EN.DFIDUNIDADE";
                break;
        }
        
        
        if($Entidade!=2){
        
            $strSql = "SELECT ".$NomeCampo." AS IDENTIDADE, P.DFNOMEPESSOA AS NOMEENTIDADE, P.DFIDPESSOA FROM ".$NomeTabela;
            $strSql .= " INNER JOIN TBPESSOA P ON EN.DFIDPESSOA=P.DFIDPESSOA";
            if($isnumero=="true"){
                $strSql .=" WHERE ".$NomeCampo."=".$CampoEntidade;
            }
            else{
                $strSql .=" WHERE P.DFNOMEPESSOA LIKE '%".$CampoEntidade."%'";
            }
        }
        else{
            $strSql = "SELECT ".$NomeCampo." AS IDENTIDADE, P.DFNOMEPESSOA AS NOMEENTIDADE, P.DFIDPESSOA, PR.DFNOMEPROPRIEDADE, PR.DFIDPROPRIEDADE,PR.DFIDLINHA,LI.DFNOMELINHA FROM ".$NomeTabela;
            $strSql .= " INNER JOIN TBPROPRIEDADE PR ON ".$NomeCampo."=PR.DFIDPRODUTOR";
            $strSql .= " INNER JOIN TBLINHA LI ON PR.DFIDLINHA=LI.DFIDLINHA";
            $strSql .= " INNER JOIN TBPESSOA P ON EN.DFIDPESSOA=P.DFIDPESSOA";
            
            if($isnumero=="true"){
                $strSql .=" WHERE (".$NomeCampo."=".$CampoEntidade.") or(PR.DFIDPROPRIEDADE=".$CampoEntidade.")";
            }
            else{
                $strSql .=" WHERE P.DFNOMEPESSOA LIKE '%".$CampoEntidade."%' OR( PR.DFNOMEPROPRIEDADE LIKE '%".$CampoEntidade."%')";
            }
        }
            
       
        $capturaentidade   = fbird_query($dbh,$strSql);
        if($capturaentidade){
            while ($linha = fbird_fetch_object($capturaentidade)){
                $retorno[$cont]["Entidade"]["identidade"] = $linha->IDENTIDADE;
                $retorno[$cont]["Entidade"]["nomepessoa"] = utf8_encode($linha->NOMEENTIDADE);
                $retorno[$cont]["Entidade"]["idpessoa"] = $linha->DFIDPESSOA;
                
                if($Entidade==2){
                    $retorno[$cont]["Entidade"]["nomepropriedade"] = utf8_encode($linha->DFNOMEPROPRIEDADE);
                    $retorno[$cont]["Entidade"]["idpropriedade"] = $linha->DFIDPROPRIEDADE;
                    $retorno[$cont]["Entidade"]["nomelinha"] = utf8_encode($linha->DFNOMELINHA);
                    $retorno[$cont]["Entidade"]["idlinha"] = $linha->DFIDLINHA;
                }
                $cont = $cont + 1;
            }
                
        }
        fbird_free_result($capturaentidade);
    }
    
        
    
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>
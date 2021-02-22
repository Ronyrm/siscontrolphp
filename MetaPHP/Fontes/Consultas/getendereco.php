
<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campoendereco"]))
    {
        $isnumero = $_GET["isnumeric"];
        $Campoendereco = isset($_GET["campoendereco"]) ? $_GET["campoendereco"] :"";
        $IdPessoa = isset($_GET["idpessoa"]) ? $_GET["idpessoa"] :"";
        
        $SqlStr = 'SELECT en.DfIdEndereco,en.DfTipoEndereco,en.DfLogradouro,en.DfNumero,en.DfComplemento,en.DfBairro,';
        $SqlStr .='en.DfCep,en.DfIdMunicipio,en.dfedi,mu.dfnomemunicipio,mu.dfidsiglauf,en.DFINSCRURAL,en.DFCODEAN';
        $SqlStr .=' FROM tbendereco en INNER JOIN tbmunicipio mu ON en.dfidmunicipio=mu.dfidmunicipio';

        $SqlStr .= " WHERE (EN.DFIDPESSOA =".$IdPessoa.") AND (EN.DFLOGRADOURO  LIKE '%".$Campoendereco."%')";
        $CapturaEndereco   = fbird_query($dbh,$SqlStr);
        if($CapturaEndereco){
            while ($linha = fbird_fetch_object($CapturaEndereco)){
                
                $tpende= "";
                switch ($linha->DFTIPOENDERECO){
                    case 0:
                        $tpende = "Comercial"; 
                        break;
                    case 1:
                        $tpende = "Entrega"; 
                        break;
                    case 2:
                        $tpende = "CObrança"; 
                        break;
                    case 3:
                        $tpende = "Residencial"; 
                        break;
                    case 4:
                        $tpende = "Rural"; 
                        break;
                }
                
                $logra  = utf8_encode($linha->DFLOGRADOURO).", n ".$linha->DFNUMERO.",  ".utf8_encode($linha->DFCOMPLEMENTO).", ";
                $logra .= utf8_encode($linha->DFBAIRRO).", ".utf8_encode($linha->DFNOMEMUNICIPIO)."-".utf8_encode($linha->DFIDSIGLAUF)." Cep: ".utf8_encode($linha->DFCEP);
                $retorno[$cont]["endereco"]["idendereco"] = $linha->DFIDENDERECO;
                $retorno[$cont]["endereco"]["nomeendereco"] = $logra;
                $retorno[$cont]["endereco"]["tipoendereco"] = $tpende;
                $cont = $cont + 1;
            
                
            }
            fbird_free_result($CapturaEndereco);
        }
    }    
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>

<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["campocarteira"]))
    {
        $isnumero = $_GET["isnumeric"];
        $CampoCarteira = isset($_GET["campocarteira"]) ? $_GET["campocarteira"] :"";
        
        $SqlStr  = 'SELECT CA.DFDESCRICAO,ca.dfcarteira,CA.dfidcarteira, ca.dfidgerconta, ca.dfidbanco, ';
        $SqlStr .= 'BA.dfnomebanco, ca.dfidagencia, AG.dfdescagencia,AG.DFNUMAGENCIA';
        $SqlStr .= ' FROM tbcarteira CA';
        $SqlStr .= ' LEFT JOIN tbbanco BA ON CA.dfidbanco = BA.dfidbanco';
        $SqlStr .= ' LEFT JOIN tbagencia AG ON CA.dfidagencia= AG.dfidagencia';
        
   
        $SqlStr .= " WHERE CA.DFIDGERCONTA LIKE '%".$CampoCarteira."%'";
        
        $CapturaCarteira   = fbird_query($dbh,$SqlStr);
        if($CapturaCarteira){
            while ($linha = fbird_fetch_object($CapturaCarteira)){
                
                $retorno[$cont]["carteira"]["idcarteira"]   = $linha->DFIDCARTEIRA;
                $retorno[$cont]["carteira"]["carteira"]     = $linha->DFCARTEIRA;
                $retorno[$cont]["carteira"]["nomecarteira"] = utf8_encode($linha->DFIDGERCONTA);
                $retorno[$cont]["carteira"]["nomebanco"]    = utf8_encode($linha->DFNOMEBANCO);
                $retorno[$cont]["carteira"]["nomeagencia"]  = utf8_encode($linha->DFDESCAGENCIA);
                $retorno[$cont]["carteira"]["numagencia"]  = utf8_encode($linha->DFNUMAGENCIA);
                $retorno[$cont]["carteira"]["desccarteira"]  = utf8_encode($linha->DFDESCRICAO);
                $cont = $cont + 1;
            }
                
        }
        
        fbird_free_result($CapturaCarteira);
    }
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>

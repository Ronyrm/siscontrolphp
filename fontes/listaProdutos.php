<?php
    include_once("../conexao/conn.php");
    session_start();
    
    $callback    = isset($_GET['callback']) ? $_GET['callback'] : false;
    $pesquisapor = isset($_GET['pesquisapor']) ? $_GET['pesquisapor'] : false;
    $valcampo    = isset($_GET['valcampo']) ? $_GET['valcampo'] : false;
    $posreg      = isset($_GET['posreg']) ? $_GET['posreg'] : 1;
    $numpag      = isset($_GET['numpag']) ? $_GET['numpag'] : 1;
    $pagatual    = isset($_GET['pagatual']) ? $_GET['pagatual'] : 1;
    $idgrupo     = isset($_GET['idgrupo']) ? $_GET['idgrupo'] : -1;


    $qtdporpag     = isset($_GET['qtdporpag']) ? $_GET['qtdporpag'] : false;
    

    $_SESSION["pesquisapor"]   = $pesquisapor;
    $_SESSION["valcampo"]      = $valcampo;
    $_SESSION["posreg"]        = $posreg;
    $_SESSION["numpag"]        = $numpag;
    $_SESSION["qtdporpag"]     = $qtdporpag;
    $_SESSION["pagatual"]      = $pagatual;

    $_SESSION["acaopesquisar"] = "true";
    
    

    
    $retorno[1]["pesquisapor"] = $pesquisapor;
    $retorno[1]["valcampo"]    = $valcampo;
    $retorno[1]["posreg"]      = $posreg;
    $retorno[1]["numpag"]      = $numpag;


    $SqlStr    = "SELECT IDPRODUTO,DESCRICAO,CODBARRA,PRECOVENDA,CAMINHOIMG FROM produto ";
    $SqlStrTot = "SELECT COUNT(*) AS TOTALREG FROM PRODUTO";
    if ($pesquisapor == "grupo"){
        if ($valcampo <> ''){
            $SqlStr    .=" where idgrupoproduto=".$valcampo;
            $SqlStrTot .=" where idgrupoproduto=".$valcampo;
        } 
    } else {
        if ($pesquisapor == "desc"){
            
            $SqlStr    .=" where DESCRICAO like '%".$valcampo."%'".(($idgrupo != -1) ? " and idgrupoproduto=".$idgrupo : "");    
            $SqlStrTot .=" where DESCRICAO like '%".$valcampo."%'".(($idgrupo != -1) ? " and idgrupoproduto=".$idgrupo : " ");    
        }
    }
    if (!$qtdporpag){
        $posreg = 0;    
    }
    if (!$qtdporpag){
        $qtdporpag = 99999999;        
    } 

    $SqlStr .=" limit ".$posreg.",".$qtdporpag; 
    
    
    
    
    $resultconsulta   = mysqli_query($conn,$SqlStr);
    $consultaTotalReg = mysqli_query($conn,$SqlStrTot);

    $TotLinha        = mysqli_fetch_assoc($consultaTotalReg);
    $retorno[1]["TotalReg"] = $TotLinha["TOTALREG"];
    if ($resultconsulta){
        $numrow  = mysqli_num_rows($resultconsulta);
        if  ($numrow != null){
            $retorno[1]["NumLinha"] = $numrow;
            if ($numrow > 0){
                while( $linha = mysqli_fetch_assoc($resultconsulta)){
                    $retorno[0][] = utf8_converter($linha);
            
                }
            }
        }
    }
    else{
        $retorno[1]["NumLinha"];
    }
    echo ($callback ? $callback . '(' : '') . json_encode($retorno)  . ($callback? ')' : ''); 
    mysqli_close($conn);    

?>
<?php
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
        }
    });
 
    return $array;
}

?>

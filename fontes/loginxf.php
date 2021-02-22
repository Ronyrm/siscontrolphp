<?php
//    $config = parse_ini_file('config.ini', true);

// add some additional values

    session_start();
    //CONECTA BANCO FIREBIRD 
    $host = "C:\BancoMeta\MCS.FDB";
    $dbh = fbird_connect($host, "sysdba", "masterkey","ISO8859_1");

    include_once("../conexao/conn.php");
    if (isset($_GET["edtusuario"])){
        $edtusuario = $_GET["edtusuario"];
        $edtsenha   = $_GET["edtsenha"];
        
        $array = array('Login' => array('usuario' => $edtusuario, 'senha' => $edtsenha));
        // write ini file
        write_ini_file($array,'../config.ini');
        
        $output = array();
        exec("C:\\Windows\\system32\\rundll32.exe criptosenha.dll RetornaCriptoSenha", $output);
        
        $readData = parse_ini_file('../config.ini',true);
        $SenhaCripto = $readData['Criptografa']['senhacripto'];
        
        //print_r($readData);
        
        

        //$edtusuario = 'ronygustavo_rm@yahoo.com.br';
        //$edtsenha   = 'rony';
        
        $retorno      = array();
        $SqlStr = "SELECT * FROM TBUSUARIO CL";
        $SqlStr .=" WHERE (CL.DFLOGINUSUARIO='".$edtusuario."' AND (CL.DFSENHAUSUARIO='".$SenhaCripto."' OR CL.DFSENHAUSUARIO='".$edtsenha."' ));"; 
        
        //$SqlStr .=" OR (CL.CPFCNPJ='".$edtusuario."' AND CL.SENHA='".$edtsenha."'))";
        //mysqli_query($conn,'SET CHARACTER SET utf8');
        
        $consulta   = fbird_query($dbh,$SqlStr);
        $retorno["sucesso"] = false;
        $numrow = 0;  
        if ($consulta){
                
                while ($linha = fbird_fetch_object($consulta)){
                    $retorno["sucesso"] = true;
                    $numrow = 1;
                    $retorno["Usuario"]["nome"] = $linha->DFNOMEUSUARIO;
                    $retorno["Usuario"]["id" ] = $linha->DFIDUSUARIO;
                    $retorno["Usuario"]["password" ] = $linha->DFSENHAUSUARIO;
                    
                    $_SESSION["nomecliente"] = $retorno["Usuario"]["nome"];
                    $_SESSION["codcliente"] = $retorno["Usuario"]["id"];
                    
                }
                if ($numrow == 0){
                    $retorno["sucesso"] = false;
                    $numrow = 0;
                    $retorno["Usuario"]["id"] = 0;
                    $retorno["Usuario"]["nome"]  = "";
                    $retorno["Usuario"]["password"]  = "";
                    
        
                }
                
        }
        else{
            $numrow = 0;
            $retorno[1]["sucesso"] = false;
            $retorno["Usuario"]["nome"] = "";
            $retorno["Usuario"]["id"]  = "";
            $retorno["Usuario"]["password"] = "";
        }
                
        $retorno["numrow"] = $numrow;
        echo json_encode($retorno);
        
    }
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
function write_ini_file($array, $path) {
    unset($content, $arrayMulti);

    # See if the array input is multidimensional.
    foreach($array AS $arrayTest){
        if(is_array($arrayTest)) {
          $arrayMulti = true;
        }
    }
    $content = "";

    # Use categories in the INI file for multidimensional array OR use basic INI file:
    if ($arrayMulti) {
        foreach ($array AS $key => $elem) {
            $content .= "[" . $key . "]\n";
            foreach ($elem AS $key2 => $elem2) {
                if (is_array($elem2)) {
                    for ($i = 0; $i < count($elem2); $i++) {
                        $content .= $key2 . "[] = \"" . $elem2[$i] . "\"\n";
                    }
                } else if ($elem2 == "") {
                    $content .= $key2 . " = \n";
                } else {
                    $content .= $key2 . " = \"" . $elem2 . "\"\n";
                }
            }
        }
    } else {
        foreach ($array AS $key2 => $elem2) {
            if (is_array($elem2)) {
                for ($i = 0; $i < count($elem2); $i++) {
                    $content .= $key2 . "[] = \"" . $elem2[$i] . "\"\n";
                }
            } else if ($elem2 == "") {
                $content .= $key2 . " = \n";
            } else {
                $content .= $key2 . " = \"" . $elem2 . "\"\n";
            }
        }
    }

    if (!$handle = fopen($path, 'w')) {
        return false;
    }
    if (!fwrite($handle, $content)) {
        return false;
    }
    fclose($handle);
    return true;
}

fbird_free_result($consulta);
fbird_close($dbh);

?>

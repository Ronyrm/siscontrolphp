<?php
    
    include_once("../../connDB.php");
    include_once("../Funcoes/func.php");

    session_start();
    $_SESSION["codunidade"] =  "";
    $_SESSION["descunidade"] = "";

    if (isset($_GET["edtusuario"])){
        $edtusuario = $_GET["edtusuario"];
        $edtsenha   = $_GET["edtsenha"];
        
        $idunidade = "";
        if (isset($_GET["idunidade"]))
        { 
            $idunidade = $_GET["idunidade"];
        }
        $descunidade = "";
        if (isset($_GET["descunidade"]))
        { 
            $descunidade = $_GET["descunidade"];
        }
        
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
                    
                    $_SESSION["nomeusuario"] = $retorno["Usuario"]["nome"];
                    $_SESSION["codusuario"] = $retorno["Usuario"]["id"];
                    
                    if ($idunidade != "")
                    {
                        $_SESSION["codunidade"] = $idunidade;
                        $_SESSION["descunidade"] = $descunidade;
                    }
                    
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
            $retorno["sucesso"] = false;
            $retorno["Usuario"]["nome"] = "";
            $retorno["Usuario"]["id"]  = "";
            $retorno["Usuario"]["password"] = "";
        }
        fbird_free_result($consulta);        
        $retorno["numrow"] = $numrow;
        
        echo json_encode($retorno);
        
    }

    fbird_close($dbh);

?>

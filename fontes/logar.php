<?php
    session_start();
    include_once("../conexao/conn.php");
    if (isset($_POST["edtusuario"])){
        $edtusuario = $_POST["edtusuario"];
        $edtsenha   = $_POST["edtsenha"];
        
        //$edtusuario = 'ronygustavo_rm@yahoo.com.br';
        //$edtsenha   = 'rony';
        
        $retorno      = array();
        $SqlStr = "SELECT CL.CODCLIENTE,CL.NOME FROM cliente CL";
        $SqlStr .=" WHERE (CL.EMAIL='".$edtusuario."' AND CL.SENHA='".$edtsenha."');"; 
        //$SqlStr .=" OR (CL.CPFCNPJ='".$edtusuario."' AND CL.SENHA='".$edtsenha."'))";
        mysqli_query($conn,'SET CHARACTER SET utf8');
        $consulta   = mysqli_query($conn,$SqlStr);
        $retorno[1]["sucesso"] = false;
        $numrow = 0;  
        if ($consulta){
                
                while ($linha = mysqli_fetch_assoc($consulta)){
                    $retorno[1]["sucesso"] = true;
                    $numrow = 1;
                    $retorno[0]["nomecliente"] = $linha['NOME'];
                    $retorno[0]["codcliente" ] = $linha['CODCLIENTE'];
                    $_SESSION["nomecliente"] = $retorno[0]["nomecliente"];
                    $_SESSION["codcliente"] = $retorno[0]["codcliente"];
                    
                }
                if ($numrow == 0){
                    $retorno[1]["sucesso"] = false;
                    $numrow = 0;
                    $retorno[0]["nomecliente"] = "";
                    $retorno[0]["codcliente"]  = "";
                    
        
                }
                
        }
        else{
            $numrow = 0;
            $retorno[1]["sucesso"] = false;
            $retorno[0]["nomecliente"] = "";
            $retorno[0]["codcliente"]  = "";
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

?>

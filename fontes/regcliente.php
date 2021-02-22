<?php 
    session_start();
    include_once("../conexao/conn.php");

    $retorno  = array();
    $retorno["mensagem"] = "";
    $retorno["sucesso"]  = "";
        
    if (isset($_POST["edtclientereg"])){
        $edtclientereg       = $_POST["edtclientereg"];
        $edtemailreg         = $_POST["edtemailreg"];
        $edtsenhareg         = $_POST["edtsenhareg"];
        //$edtconfirmasenhareg = $_GET["edtconfirmasenhareg"];
        
        //$edtclientereg       = "Rony";
        //$edtemailreg         = "ronygustavo.rm@gmail.com";
        //$edtsenhareg         = "1234";
        //$edtconfirmasenhareg = $_POST["edtconfirmasenhareg"];
        
        $strsql = "SELECT NOME FROM CLIENTE WHERE EMAIL='".$edtemailreg."';";
        mysqli_query($conn,'SET CHARACTER SET utf8');
        if ($select =  mysqli_query($conn,$strsql)){
            $numrow_cnt = mysqli_num_rows($select);
            mysqli_free_result($select);
        }
        if ($numrow_cnt == 0){
            $sqlinsert  = "INSERT INTO CLIENTE(NOME,EMAIL,SENHA)";
            $sqlinsert .= " VALUES('".$edtclientereg."','".$edtemailreg."','".$edtsenhareg."');";
            
            $insert   = mysqli_query($conn,$sqlinsert);
            
            $retorno["mensagem"] = ((!mysqli_errno($conn)) ? "Cliente ".$edtclientereg." cadastrado com sucesso!". "\n" : "Error ao cadastrar o cliente: ".mysqli_error($conn) . "\n");
        
            $retorno["sucesso"] =  ((mysqli_errno($conn)) ? false : true);
                
        } else{
            $retorno["mensagem"] = "Email: ".$edtemailreg." ja cadastrado. Verifique!!";
            $retorno["sucesso"]  = false;
        }
            
        
    }
    echo json_encode($retorno);
    mysqli_close($conn);
    
?>
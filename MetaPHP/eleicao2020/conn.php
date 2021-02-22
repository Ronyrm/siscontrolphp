<?php 
    $hosts   = "siscontrolrm.dyndns.org";
    $usuario = "rony";
    $senha   = "rony";
    $banco   = "siscontrol_teste";
    
    $conn    = mysqli_connect($hosts,$usuario,$senha,$banco);  
    $StatusConn = true;
    if (mysqli_connect_errno() ) {
        echo "Erro";
        die("Erro ao conectar ao banco de dados:. ".mysqli_connect_errno());
        $StatusConn = false;
        $MsgErroConn = "Erro ao conectar ao banco de dados:. ".mysqli_connect_errno();
    }
    else{
        echo "conectado";
    }
    echo $StatusConn;
    


?>
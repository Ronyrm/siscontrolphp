<?php 
    $hosts   = "localhost";
    $usuario = "rony";
    $senha   = "rony";
    $banco   = "siscontrol_teste";
    //$hosts   = "localhost";
    //$usuario = "RMNutri";
    //$senha   = "rony";
    //$banco   = "rmnutri";

    $conn    = mysqli_connect($hosts,$usuario,$senha,$banco);  
    $StatusConn = true;
    if (mysqli_connect_errno() ) {
        
        die("Erro ao conectar ao banco de dados:. ".mysqli_connect_errno());
        $StatusConn = false;
        $MsgErroConn = "Erro ao conectar ao banco de dados:. ".mysqli_connect_errno();
    }

// php.ini tirar ponto e virgula de: 
//extension=pdo_firebird

//$host = "C:\BancoMeta\MCS.FDB";

//$dbh = fbird_connect($host, "sysdba", "masterkey");
//$stmt = "SELECT * FROM tbusuario";
//$sth = fbird_query($dbh, $stmt);
//while ($row = fbird_fetch_object($sth)) {
//    echo $row->DFNOMEUSUARIO, "\n";
//}
//fbird_free_result($sth);
//fbird_close($dbh);

   
//?>
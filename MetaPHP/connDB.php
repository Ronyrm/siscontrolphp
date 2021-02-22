<?php

    //CONECTA BANCO FIREBIRD 
    $host = "C:\BancoMeta\Atalac\MCS.FDB";
    $senha = "sysdba";
    $passwd = "masterkey";
    $dbh = fbird_connect($host,$senha , $passwd,"ISO8859_1");

?>
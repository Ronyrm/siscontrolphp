<?php
    include_once("../../connDB.php");
    $retorno      = array();
    if (isset($_POST["mensagem"]))
    {
        $msg    = $_POST["mensagem"];
        $iduser = $_POST["idusuario"];
        $idchat = $_POST["idchat"];
        
        $strins = "INSERT INTO tbmensagemchat(dfidchat,dfidusuario,dfmensagem) ";
        $strins .="VALUES(?,?,?)";

        
        $qry = fbird_prepare($dbh,$strins);
        ibase_execute($qry,$idchat,$iduser,$msg);
            
        $retorno["gravou"] = true;
        $retorno["msg"] = 'Cadastrado com sucesso';
        
        
        fbird_close($dbh);
        echo json_encode($retorno);
    }
?>
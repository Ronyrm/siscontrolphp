<?php
    include_once("../../connDB.php");
    if (isset($_GET["idchat"]))
    { 
        $idchat = $_GET["idchat"];
        $retorno      = array();
        $SqlStr = "SELECT MC.dfidmensagem, mc.dfidusuario, mc.dfmensagem, mc.dfidchat,";             $SqlStr.= "mc.DFDATAMSG,mc.DFHORAMSG FROM tbmensagemchat MC where DFIDCHAT=".$idchat;
        $SqlStr.= "ORDER BY mc.DFDATAMSG,mc.DFHORAMSG";
        
        $consulta = fbird_query($dbh,$SqlStr);
        if ($consulta)
        {
            $cont = 0;
            while ($linha = fbird_fetch_object($consulta))
            {
                $data = date_create($linha->DFDATAMSG);
                $hora = date_create($linha->DFHORAMSG);
                $datahora =  date_format($data, 'd/m/Y').' - '.date_format($hora,'H:i:s');
             
            
            
                $retorno[$cont]["id"] = $linha->DFIDMENSAGEM;
                $retorno[$cont]["id_Chat" ] = $linha->DFIDCHAT;
                $retorno[$cont]["id_Usuario" ] = $linha->DFIDUSUARIO;
                $retorno[$cont]["mensagem" ] = $linha->DFMENSAGEM;
                $retorno[$cont]["datamsg" ] = $linha->DFDATAMSG;
                $retorno[$cont]["horamsg" ] = $linha->DFHORAMSG;
                $retorno[$cont]["datahoramsg" ] =$datahora;
                
            
                //captura usuario
                $strsql_user = "SELECT * FROM TBUSUARIO WHERE DFIDUSUARIO=".$linha->DFIDUSUARIO.";";
                $captura_user   = fbird_query($dbh,$strsql_user);
                if($row_user = fbird_fetch_object($captura_user))
                {
                    $retorno[$cont]["usuario" ]["id"] = $row_user->DFIDUSUARIO;
                    $retorno[$cont]["usuario" ]["nome"] = $row_user->DFNOMEUSUARIO;
                
                }
                fbird_free_result($captura_user); 
                $cont+=1;
            }
        }
        fbird_free_result($consulta);
        echo json_encode($retorno);
    }
        
     
    fbird_close($dbh);
    

?>    

<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["idunidade"]))
    {
        $CodUni = $_GET["idunidade"];
        $isnumero = $_GET["isnumeric"];
        
        $CampoPesqUni = isset($_GET["edtDescDep"]) ? $_GET["edtDescDep"] :"";
       
        
        if (!isset($_SESSION["idgrau1"]))
        {
            
            $SqlStr = "SELECT UN.DFIDGRAU1, UN.DFIDGRAU2, UN.DFIDGRAU3 FROM tbunidade UN WHERE UN.dfidunidade=".$CodUni;
            $capturauni   = fbird_query($dbh,$SqlStr);
            if ($capturauni)
            {
                $linha = fbird_fetch_object($capturauni);
                
                $idgrau1 = ($linha->DFIDGRAU1);
                $idgrau2 = ($linha->DFIDGRAU2);
                $idgrau3 = ($linha->DFIDGRAU3);
                
                $_SESSION["idgrau1"] = $idgrau1;
                $_SESSION["idgrau2"] = $idgrau2;
                $_SESSION["idgrau3"] = $idgrau3;
            }
            fbird_free_result($capturauni);
        }
        else
        {
            $idgrau1 = $_SESSION["idgrau1"];
            $idgrau2 = $_SESSION["idgrau2"];
            $idgrau3 = $_SESSION["idgrau3"];
        }
        $SqlStr = "";
        if($isnumero=="true"){
            $SqlStr = "SELECT UN.dfidunidade, un.dfrazsocunidade FROM TBUNIDADE UN";
            $SqlStr .= " WHERE UN.dfidunidade=".$CampoPesqUni." AND DFDEPOSITO='S'";
        }
        else{
            $SqlStr = "SELECT UN.dfidunidade, un.dfrazsocunidade FROM TBUNIDADE UN";
            $SqlStr .= " WHERE ((UN.dfidgrau1='".$idgrau1."') AND (UN.dfidgrau2='".$idgrau2."') AND (UN.dfidgrau3<>'000'))";
            $SqlStr .= " AND (UN.dfrazsocunidade LIKE '%".$CampoPesqUni."%')";
        }
        $capturadeposito   = fbird_query($dbh,$SqlStr);
        
        if($capturadeposito){
            
            while ($linha = fbird_fetch_object($capturadeposito)){
                $retorno[$cont]["Unidade"]["idunidade"] = $linha->DFIDUNIDADE;
                $retorno[$cont]["Unidade"]["descdeposito"] = utf8_encode($linha->DFRAZSOCUNIDADE);
                $cont = $cont + 1;
            }
                
        }
        fbird_free_result($capturadeposito);
    }
    
        
    
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>
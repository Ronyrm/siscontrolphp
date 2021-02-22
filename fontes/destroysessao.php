<?php
    session_start();
    if (isset($_GET["acaopesquisar"])){
        if ($_GET["acaopesquisar"] == true){
            unset($_SESSION["acaopesquisar"]); 
            unset($_SESSION["pesquisapor"]);
            unset($_SESSION["valcampo"]);      
            unset($_SESSION["posreg"]);        
            unset($_SESSION["numpag"]);        
            unset($_SESSION["qtdporpag"]);     
            unset($_SESSION["pagatual"]);       
            echo "sucesso";
        }
    } else{
        echo "false";
    }
        
    
?>
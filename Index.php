<?php   
    include_once("conexao/conn.php");
    session_start();
    
    
    if (isset($_SESSION["acaopesquisar"])){
        $_SESSION["acaopesquisar"] = "true";
        $acaopesquisar = $_SESSION["acaopesquisar"];
    } 
    else {
        $acaopesquisar = "false";
    } 
    //    header('Location: fontes/telalogin.php');
    //
?>

<html>
    
    <?php 
        include_once("fontes/cabecalho.php");
        if ($acaopesquisar == "true"){
            
        $pesquisapor   = $_SESSION["pesquisapor"];
        $valcampo      = $_SESSION["valcampo"];
        $posreg        = $_SESSION["posreg"];
        $numpag        = $_SESSION["numpag"];
        $qtdporpag     = $_SESSION["qtdporpag"]; 
           
        echo "Pesquisar por ".$pesquisapor." - Valor Campo ".  
        $valcampo." - Posicao Reg ".     
        $posreg." - Num Pgina ".       
        $numpag." - Qdt por Pagina ".       
        $qtdporpag;     
        
        
        $strget = "numpag=".$numpag."&posreg=".$posreg."&qtdporpag=".$qtdporpag."&pesquisapor=".$pesquisapor."&valcampo=".$valcampo;
            echo '<script src="http://siscontrolrm.dyndns.org/fontes/listaProdutos.php?'.$strget.'&callback=retornatabprod"></script>';
     }  ?>
</html>
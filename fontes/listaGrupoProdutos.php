<?php
    include_once("../conexao/conn.php");
    $resultado = "";
    $SqlStr = 'SELECT IDGRUPOPRODUTO,DESCGRUPOPRODUTO FROM grupoproduto';
    $resultconsulta = mysqli_query($conn,$SqlStr);
    
    $comgrupo = (isset($_GET["comgrupo"]) ? $_GET["comgrupo"] : false ); 
    if ($comgrupo == true){
        $resultado .= "<option value=-1>Todos</option>";    
    }
        
    if ($resultconsulta){
        while( $linha = mysqli_fetch_assoc($resultconsulta)){
            //$resultado .='<li class="navitemgrupo nav-item">';
            if($comgrupo == false){  
                $stemp = "'".$linha['IDGRUPOPRODUTO']."','".$linha['DESCGRUPOPRODUTO']."'";
                $resultado .='<a class="nav-link" '; 
                $resultado .='onclick="AbreProdGrupo('.$stemp.');"';
                $resultado.=' title="'.$linha['IDGRUPOPRODUTO'].'"';
                $resultado.='style="color: white; padding: 12px 16px; text-decoration: none;cursor: pointer;">';
                      
                $resultado .= utf8_encode($linha['DESCGRUPOPRODUTO']);
                $resultado .='</a>';
                //$resultado .='</li>';
                //$resultado .='<div class="dropdown-divider"></div>';
            } else{
                $resultado .= "<option value='".$linha['IDGRUPOPRODUTO']."'>".utf8_encode($linha['DESCGRUPOPRODUTO'])."</option>";
            }
        }
    }
        
        mysqli_free_result($resultconsulta);
        mysqli_close($conn);
        echo $resultado;
?>   
    

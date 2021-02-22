<?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo');
    include_once("../conexao/conn.php");
    session_start();
    
    $divCarocel = "";

    $strsql = "SELECT pp.IDPROMOCAO,pp.IDPRODUTO,CONCAT(pp.IDPRODUTO,' - ',pr.descricao) as descproduto,";
    $strsql .= "pp.IDPLANOPAGTO,plp.descricao as descplanopagto,pp.DATAINI,pp.DATAFIM,pp.MENSAGEM,";
    $strsql .= "pp.PORPLANOPAGTO,PP.VALPROD,pp.VALDESC,PP.PERCDESC,PP.VALVENDA,pp.CAMINHOIMG,pp.CORMSG,"; 
    $strsql .= "pp.CORFONTE from promocaoproduto pp left join produto pr on pp.idproduto = pr.idproduto";
    $strsql .= " left join planopagto plp on pp.idplanopagto=plp.idplanopagto"; 
    
    $dataatual = date('Y-m-d');

    $strsql .= " WHERE '".$dataatual."' BETWEEN pp.DATAINI AND pp.DATAFIM;";
    

    mysqli_query($conn,'SET CHARACTER SET utf8');
    $resultconsulta   = mysqli_query($conn,$strsql);
    
    if ($resultconsulta){
        
        $qtdrow           = mysqli_num_rows($resultconsulta); 
        if ($qtdrow > 0){
            
            //$divCarocel .= '<div id="carouselpromo" class="carousel slide" data-ride="carousel">';
            $divCarocel .= '<div class="carousel-inner bg-padrao mx-auto " role="listbox">';
            $i=0;
            $cont=1;
            $stractive = 'active';
            $divColocaCar = "";
            while( $row = mysqli_fetch_assoc($resultconsulta)){
                $linha = utf8_converter($row);
                $caminhoimg= "/fontes/img/".$linha["CAMINHOIMG"];
                $msg = $linha["MENSAGEM"];
                $idproduto = $linha["IDPRODUTO"];
                
                $cormsg = "bg-dark";
                switch($linha["CORMSG"]){
                    case "Azul":
                        $cormsg = "bg-primary";
                        break;
                    case "Azul Claro":
                        $cormsg = "bg-info";
                        break;
                    case "Branco":
                        $cormsg = "bg-white";
                        break;
                    case "Preto":
                        $cormsg = "bg-dark";
                        break;
                    case "Vermelho":
                        $cormsg = "bg-danger";
                        break;
                    case "Amarelho":
                        $cormsg = "bg-warning";
                        break;
                    case "Verde":
                        $cormsg = "bg-success";
                        break;
                }
                $corfonte = "text-white";
                switch($linha["CORFONTE"]){
                    case "Azul":
                        $corfonte = "text-primary";
                        break;
                    case "Azul Claro":
                        $corfonte = "text-info";
                        break;
                    case "Branco":
                        $corfonte = "text-white";
                        break;
                    case "Preto":
                        $corfonte = "text-dark";
                        break;
                    case "Vermelho":
                        $corfonte = "text-danger";
                        break;
                    case "Amarelho":
                        $corfonte = "text-warning";
                        break;
                    case "Verde":
                        $corfonte = "text-success";
                        break;
                }
                    
                
                $divCarocel .='<div class="carousel-item  mt-3 mb-3 '.$stractive.'">';
                $divCarocel .='<div class="container">';
                $divCarocel .='<div class="row mx-auto text-center '.$cormsg.' ">';
                $divCarocel .='<div class= "col-md-6 col-lg-6">';
                $divCarocel .='<img class="img-fluid py-2 text-center px-2 border border-primary"  src="'.$caminhoimg.'"  alt="'.$i.' slide'.$qtdrow.'" ></div> ';
                $divCarocel .='<div class= "col-md-6 col-lg-6">';
                $divCarocel .='<h4 class="card-title">'.$linha["descproduto"].'</h4>';
                $divCarocel .='<p class="card-text '.$corfonte.'">'.$msg.'</p>';
                $divCarocel .='<a class="btn btn-primary '.$corfonte.'">Comprar</a></div>';
                
                
                $divCarocel .='</div>';
                $divCarocel .='</div>';
                
                /*$divCarocel .='<div class="card text-center mx-auto '.$cormsg.' " style="width:50%;">';
                $divCarocel .='<img class="card-img-top py-2 text-center px-2"  src="'.$caminhoimg.'"  alt="'.$i.' slide'.$qtdrow.'" > ';
                $divCarocel .='<div class="card-body">';
                $divCarocel .='<h4 class="card-title">'.$linha["descproduto"].'</h4>';
                $divCarocel .='<p class="card-text '.$corfonte.'">'.$msg.'</p>';
                
                
               
                $divCarocel .='</div>';
                $divCarocel .='</div>';
                */
                
                //$divCarocel .='<div class="row">';
                //if ($cont == 3){
                    $divCarocel .='</div>';
                    $cont = 1;
                //}
                
                $stractive = '';
                $i=$i+1;
                $cont=$cont+1;
                
            }
           // if ($qtdrow < 3){
                
            $divCarocel .= '</div>';
            
            //$divCarocel .= '<ol class="carousel-indicators">';
            //$stractive = 'class="active"';
            //for($i=0;$i<=$qtdrow-1;$i++){
                
                //$divCarocel .= '<li data-target="#carouselpromo" data-slide-to="'.$i."'".$stractive.'></li>';  
                //$stractive =' ';
            //}
            //$divCarocel .= '</ol>';
            
            $divCarocel .='<a class="carousel-control-prev" href="#carouselpromo" role="button" data-slide="prev">';
            $divCarocel .='<span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span></a>';
            $divCarocel .='<a class="carousel-control-next" href="#carouselpromo" role="button" data-slide="next">';
            $divCarocel .='<span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span></a>';
        }
    }

    echo $divCarocel;


?>
<?php
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
        }
    });
 
    return $array;
}
?>
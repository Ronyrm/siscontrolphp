<?php
    include_once("../conexao/conn.php");
    session_start();
    $cont = 0;
                    
    if (isset($_GET["idprodtemp"])){
        $qtdprodinput   = $_GET["qtdprodinput"];
        $descprodtemp   = $_GET["descprodtemp"];
        $precovendatemp = $_GET["precovendatemp"];
        $idprodtemp     = $_GET["idprodtemp"];
        $caminhoimgtemp = $_GET["caminhoimgtemp"];
        $subtotal       = $precovendatemp * $qtdprodinput;
        
        
        
        if (!isset($_SESSION["carrinho"])){    
            $_SESSION["carrinho"][0] = array('Produtos' => 
                                             array('idproduto' => array($idprodtemp),
                                                   'descproduto' =>array($descprodtemp),
                                                   'caminhoimg' => array($caminhoimgtemp),
                                                   'Quantidade' =>array($qtdprodinput),
                                                   'PrecoVenda' => array($precovendatemp),
                                                   'SubTotal' => array($subtotal) ));
            $_SESSION["carrinho"][1] = array('PrecoTotal' => $subtotal,"Desconto" => "0,50");
        
        } else {
        
            if(isset($_SESSION['carrinho'])){
                $cont = 0;
                $cont = (count($_SESSION["carrinho"][0]['Produtos']['idproduto']));
                
                $_SESSION["carrinho"][0]['Produtos']['idproduto'][$cont]      = $idprodtemp; 
                $_SESSION["carrinho"][0]['Produtos']['descproduto'][$cont]    = $descprodtemp;
                $_SESSION["carrinho"][0]['Produtos']['caminhoimg'][$cont]     = $caminhoimgtemp;
                $_SESSION["carrinho"][0]['Produtos']['Quantidade'][$cont]     = $qtdprodinput; 
                $_SESSION["carrinho"][0]['Produtos']['PrecoVenda'][$cont]     = $precovendatemp;
                $_SESSION["carrinho"][0]['Produtos']['SubTotal'][$cont]       = $subtotal; 
            
                $valtotal = 0; 
            
                for ($i=0; $i<=$cont; $i++){
                    $qtdprod = $_SESSION["carrinho"][0]['Produtos']['Quantidade'][$i];
                    $preco   = $_SESSION["carrinho"][0]['Produtos']['PrecoVenda'][$i];
                    $valtotal = $valtotal + ($qtdprod * $preco);
                }
                $_SESSION["carrinho"][1]['PrecoTotal'] = $valtotal; 
                
            }
        }
        
    }
    else{
        if (isset($_SESSION["carrinho"])){
            //var_dump($_SESSION["carrinho"][0]['Produtos']['descproduto']);
            //var_dump($_SESSION["carrinho"][0]['Produtos']['descproduto']);
        }
        $idproduto = (!isset($_GET["idproduto"]) ? 0 : $_GET["idproduto"]);
        $strsql  = "SELECT PR.DESCRICAO, PR.PRECOVENDA,PR.UNIDADEMEDIDA,";
        $strsql .= "PR.CAMINHOIMG,PR.QTD_ESTOQATUAL,GP.DESCGRUPOPRODUTO";
        $strsql .= " FROM PRODUTO PR ";
        $strsql .= " LEFT JOIN GRUPOPRODUTO GP ON PR.IDGRUPOPRODUTO = GP.IDGRUPOPRODUTO ";

        $strsql .= "WHERE IDPRODUTO=".$idproduto;



        mysqli_query($conn,'SET CHARACTER SET utf8');

        if ($consulta =  mysqli_query($conn,$strsql)){

            $registro =  mysqli_fetch_assoc($consulta); 

            $descProd     = $registro["DESCRICAO"];
            $precovenda   = floatval($registro["PRECOVENDA"]);
            $precovenda   = round($precovenda,2);
            $grupoproduto = "Grupo/". $registro["DESCGRUPOPRODUTO"];

            $unidademed   = $registro["UNIDADEMEDIDA"];
            $Desunidademed = "";
            switch ($unidademed) {
                case "U":
                    $Desunidademed = 'Unidade';
                    break;
                case "P":
                    $Desunidademed = 'Peso';
                    break;
                case "C":
                    $Desunidademed = 'Caixa';
                    break;
            }

            $qtdestoque = $registro["QTD_ESTOQATUAL"];

            $caminhoimg = $registro["CAMINHOIMG"];
            if ($caminhoimg != ""){
                if(file_exists("img/".$caminhoimg)){
                    $caminhoimg = "img/".$caminhoimg;
                } else{
                    $caminhoimg = "img/prodsemimg.jpg";    
                }
            } else{
                $caminhoimg = "img/prodsemimg.jpg";
            }

            mysqli_free_result($consulta);
        }

        mysqli_close($conn);
    }

?>
<html>
<head>
    <?php include_once("head.php"); ?>
    <link href="/css/dadosprodcar.css" rel="stylesheet">
    <link href="/css/cabecalho.css" rel="stylesheet">
        
</head>
<body>
<main>
    <nav class="navbar navbar-expand-lg bg-padrao">
        <a class="navbar-brand" href="../index.php">
            <img  src="img/logo2.png" 
            style=" widht:30px; height:30px; margin-left:0px"     alt=""> SisControl-Stok
        </a>
    </nav>
        
    <div class="container">
        
        <div class="row">
            
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="divprincipal-dadosprod  mx-auto mt-2 border border-primary clearfix ">
                    <div class="col-md-6 d-block text-center float-left">
                            <div class="text-info" style="display:block; float:left"> 
                                <?php echo $grupoproduto; ?>
                            </div>
                            <div class="text-info" style="display:block; float:right"> 
                                <?php echo "Und.: ".$Desunidademed ?>
                            </div>
                            
                            <img class="img-fluid"  src="<?php echo $caminhoimg ?>">
                        
                    </div>
                    
                    <div class="col-md-6 d-block  mx-auto text-center float-right">
                        <div class="my-3">
                            <div class="divtitulo border border-primary bg-padrao ">
                                <h4 class="tituloprod card-title"><?php echo $descProd?>  </h4>
                            </div>
                            <h6 class="text-info text-right"> 
                                <?php echo "Estoque Atual.: ".round($qtdestoque,2) ?>
                            </h6>
                            <div class="row mt-2 mx-auto" style="display:block;">
                                <div class=" mx-auto text-center">
                                    <h1 class="card-subtitle mb-2 text-dark">
                                        R$:<?php echo str_replace(".",",",$precovenda) ?>
                                    </h1>
                                </div>
                            </div>
                            <br>
                            <div class="row mx-auto mt-2">
                                <p class="text-right  text-info">Quantidade:</p>    
                                <div class="input-group mb-3 text-center align-center">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-info" onclick="maismenosQtd(0);" type="button">
                                                <span   class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </div>
                                        <input class="form-control"  type="number" name="qtdcomprado" id="qtdcomprado" min="1" value="1"<?php echo 'max="'.$qtdestoque.'"' ?> style="text-align:center">
                                        
                                        <!-- QTD estoq armazenado -->
                                        <input type="hidden" <?php echo "value='".round($qtdestoque,2)."'" ?>  id="qtdestoqtemp" name="qtdestoqtemp">
                                        
                                        <input type="hidden" <?php echo "value='".$idproduto."'" ?>  id="idprodtemp" name="idprodtemp">
                                        
                                        <!-- Descrição do produto armazenado -->
                                        <input type="hidden" <?php echo "value='".$descProd."'" ?>  id="descprodtemp" name="descprodtemp">
                                        <!-- preco venda armazenado -->
                                        <input type="hidden" <?php echo "value='".$precovenda."'" ?>  id="precovendatemp" name="precovendatemp">
                                        
                                        <input type="hidden" <?php echo "value='".$caminhoimg."'" ?>  id="caminhoimgtemp" name="caminhoimgtemp">
                                        
                                    
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-info" onclick="maismenosQtd(1);" type="button">
                                                <span class="glyphicon glyphicon-minus"></span>
                                            </button>
                                        </div>
                                        
                                </div>
                                
                            </div>
                            <br>
                            <div class="row mx-auto mb-2 d-none text-center" id="divmsgerrologin">
                                <div  class="alert alert-danger alert-dismissible text-center fade show" role="alert" id="msgerro-login">
                                    Produto Sem Estoque
                                                
                                </div>
                            </div>
                            
                            <div class="row mx-auto mb-2 d-block text-center">
                                <button class="btn btn-primary border-2 mb-4" id="btnconfcompra"  >
                                    <span class="glyphicon glyphicon-shopping-cart"></span> Colocar no Carrinho
                                </button>
                            </div>
                            <div id="divmsgsucess" class="col-lg-12 d-none">
                                <div  class="alert alert-primary alert-dismissible fade show" role="alert" id="msgsucess">
                                </div>
                            </div>
                                        
                                
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
    </div>
    <script language="javascript">
        window.addEventListener('load', function(){
            console.log("QT_ESTQ"+$('#qtdestoqtemp').val());
            $qtd_estoq = $('#qtdestoqtemp').val();
            if ($qtd_estoq <= 0){
                console.log("semestoque");
                $("#divmsgerrologin").removeClass("d-none");
                $("#divmsgerrologin").addClass("d-block");
                $("#msgerro-login").html("Produto Sem Estoque");
                document.getElementById("btnconfcompra").disabled = true;
            }
            else{
                console.log("comestoque");
                document.getElementById("btnconfcompra").disabled = false;
            }
            
        });
        
        $("#btnconfcompra").click( function(){
            var qtdprodinput   = parseFloat($('#qtdcomprado').val());
            var qtdestoqtemp   = parseFloat($('#qtdestoqtemp').val());  
            var descprodtemp   = $('#descprodtemp').val();
            var precovendatemp = $('#precovendatemp').val();
            var idprodtemp     = $('#idprodtemp').val();
            var caminhoimgtemp = $('#caminhoimgtemp').val();
                                        
            if ((qtdprodinput <= qtdestoqtemp) && (qtdprodinput > 0)){
                console.log("veio aq");
                 $.ajax({
                    type : "GET",
                    data : "qtdprodinput="+qtdprodinput+"&caminhoimgtemp="+caminhoimgtemp+"&descprodtemp="+descprodtemp+"&precovendatemp="+precovendatemp+"&idprodtemp="+idprodtemp,
                     url  : "/fontes/dadosprodcar.php",
                    async:false,
                    beforeSend: function(){
                        //aqui
                        $("#btnconfcompra").html('<span class="spinner-border spinner-border-sm d-block" role="status" aria-hidden="true" ></span> Aguarde...');
                        
                                    
                    }
            }).done( function(data){
                $('#divmsgsucess').removeClass('d-none');
                var shtm = ""; 
                shtm = '<strong>Produto adicionado no carrinho</strong>';
                shtm +='<button type="button" class="close" data-dismiss="alert"  aria-label="Close">';
                shtm +='<span aria-hidden="true">&times;</span></button>';
                $('#msgsucess').html(shtm);
                $('#divmsgsucess').delay(1000).fadeOut(1000);
                            
                setTimeout(function(){
                    $('#divmsgsucess').addClass('d-none');
                    $('#divmsgsucessreg').delay(1000).fadeIn(2000);
                    window.location.href ="../index.php";
                }, 2000);
                
            }).fail(function(data){
                
            })   
                
            }
        });
        $("#qtdcomprado").change( function(){
            var qtdprodinput = parseFloat($('#qtdcomprado').val());
            var qtdestoqtemp = parseFloat($('#qtdestoqtemp').val());
            console.log("entrando");
            if (qtdprodinput == 0){
                    $("#divmsgerrologin").removeClass("d-none");
                    $("#divmsgerrologin").addClass("d-block");
                    $("#msgerro-login").html("Quantidade deve ser maior que zero");
                    document.getElementById("btnconfcompra").disabled = true;        
            }else{
                if (qtdprodinput > qtdestoqtemp){
                    $("#divmsgerrologin").removeClass("d-none");
                    $("#divmsgerrologin").addClass("d-block");
                    $("#msgerro-login").html("Quantidade excede o limite do estoque");
                    document.getElementById("btnconfcompra").disabled = true;        
                }
                else{
                    $("#divmsgerrologin").removeClass("d-block");
                    $("#divmsgerrologin").addClass("d-none");
                    document.getElementById("btnconfcompra").disabled = false;
            
                }
            }
        });
        function maismenosQtd(tipo){
            var  qtdtemp = 0;
            var qtdprodinput = parseFloat($('#qtdcomprado').val());
            var qtdestoqtemp = parseInt($('#qtdestoqtemp').val());
            console.log(qtdprodinput);
            console.log(tipo);
            if ((qtdprodinput > 0) && (qtdprodinput < qtdestoqtemp)){
                console.log(tipo);
              if (tipo == "0"){
                qtdtemp = parseFloat(qtdprodinput) + 1;  
              }else{
                  if (tipo == "1"){
                    qtdtemp = parseFloat(qtdprodinput) - 1;  
                  }
              }
            }
            if (qtdtemp == 0){ qtdtemp=1;}
            $('#qtdcomprado').val(qtdtemp);
            
            if  (qtdprodinput > qtdestoqtemp){
                $("#divmsgerrologin").removeClass("d-none");
                $("#divmsgerrologin").addClass("d-block");
                $("#msgerro-login").html("Quantidade Exede o Limite do Estoque");
                document.getElementById("btnconfcompra").disabled = true;        
            }
            else{
                $("#divmsgerrologin").removeClass("d-block");
                $("#divmsgerrologin").addClass("d-none");
                document.getElementById("btnconfcompra").disabled = false;
            }
        }
    </script>
</main>
    
</body>
</html>
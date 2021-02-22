<?php
    if (isset($_SESSION["nomecliente"])){
        $userlogado = true;
    }
    else {
        $userlogado = false;
    }
    if (isset($_SESSION["carrinho"])){
        $contcar = count($_SESSION["carrinho"][0]['Produtos']['idproduto']);
    }else{
        $contcar = 0;
    }



?>
<head>
    <?php include_once("fontes/head.php"); ?>
    <style>
        <?php include_once("css/cabecalho.css"); ?>
      /* <link href="/css/cabecalho.css" rel="stylesheet">*/
    </style>
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn"  onclick="closeNav();">&times;</a>
        <ul class="navbar-nav mr-auto text-write"> Grupo
            <?php //include_once("listaGrupoProdutos.php"); ?>
        </ul>
    </div>
    

<main id="mainprincipal">
    
<nav class="navbar navbar-expand-lg  bg-padrao">
    <a class="navbar-brand" href="#" id="btnindex" onclick="retornatelaindex();">
                        <img  src="fontes/img/logo2.png" 
                        style=" widht:30px; height:30px; margin-left:0px"     alt=""> SisControl-Stok
    </a>
    <div class="container">
        <div class="col-lg-1">
             
        </div>
        <div class="col-lg-6">
            <div class="input-group mx-auto">
                    <input type="text" class="form-control border-white border-2 rounded-2" placeholder="Digite aqui o produto" id="edt_Pesq" aria-label="Digite aqui o produto" aria-describedby="button-addon2" style="width:100px;">
                        
                    <div class="input-group-append">
                        <select id="selectgrupo" class="custom-select" style="width:0px;">
                        </select>
                        <button class="btn btn-outline-primary btn-primary" type="button" id="btn_Pesq"><span class="glyphicon glyphicon-search"></span> </button>
                    </div>
            </div>
            <p class="text-danger d-none" id="pmsgcampo" style="float:Left;">Campo Pesquisa Vazio</p>
            <p class="text-white mr-5" id="pselgrupo" style="float:right;">Grupo: Todos</p>
        </div>
        <div class="col-lg-2">
             
        </div>
    </div>
</nav>
<nav class="navbar  bg-padrao">
    <div class="container-fluid">
        <ul class="nav narbar-nav bg-padrao">
            
            <li class="nav-item">
                <div  id="mainside">
                    <button class="navbar-toggler btn btn-primary text-white" onclick="openNav()" type="button"><span style="cursor:pointer" >&#9776;</span>
                    </button>
                </div>

            
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto text-write">
                     <?php //include_once("listaGrupoProdutos.php"); ?>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <div class="dropdowngrupo" id="dropdowngrupo">
                    <button title="Grupo de Produtos" class="navmenugrupo navbar-toggler btn btn-primary text-white ml-1" type="button"><span style="cursor:pointer" >&#9776;</span>
                    </button>
                
                    <div class="dropdowngrupo-content text-center"  aria-labelledby="dropBtnminhaconta">
                    
                    </div>
                </div>
                    
                
            </li>
            
        </ul>
       
        <ul class="nav navbar-right">
            <?php $dbtnlogar = $userlogado ? "d-none" : "d-block"; ?> 
            <li <?php echo "class='".$dbtnlogar." '" ?>>
                <button type="button" class="dropbtn btn btn-primary border-2 rounded-2 "   id="btnlogar">
                <span class="glyphicon glyphicon-user"></span> Logar
                </button>
            </li>
               
            <?php $dbtnconta = $userlogado ? "d-block" : "d-none"; ?> 
            <li <?php echo "class='".$dbtnconta."'" ?>>
                <div class="dropdown" onmouseover="escodepromo()">
                    <button class="dropbtn btn btn-primary" type="button" id="dropBtnminhaconta" aria-haspopup="true" aria-expanded="false" ><span class="glyphicon glyphicon-log-out" aria-hidden="true" title="Minha Conta"> </span> MinhaConta
                         
                    </button>
                    <div class="dropdown-content text-center" aria-labelledby="dropBtnminhaconta"  onmouseout=<?php echo "mostrapromo('".(isset($_SESSION["acaopesquisar"])? $_SESSION["acaopesquisar"] : false )."')" ?>>
                        <a  href="#">Alguma ação</a>
                        <a  href="#">Outra ação</a>
                        <div class="dropdown-divider"></div>
                        <div class="container align-center my-2 mx-auto  justify-content-center">
                            <button class="btn btn-primary  text-white " style="text-align:center; vertical-align: middle;" id="btnlogout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Sair
                             
                            </button>
                        </div>
                    </div>
                </div>
            </li>
            <li class=" d-block ml-2">
                
                <button type="button" class="dropbtn btn btn-primary border-2 rounded-2" id="btncarrinho" data-toggle="modal" data-target=".modalcarrinho">
                    <span class="glyphicon glyphicon-shopping-cart"></span> Carrinho <?php echo ($contcar > 0) ? "(".$contcar.")" : "" ?> 
                </button>
                <div class="modal fade modalcarrinho" id="modalcarrinho" tabindex="-1" role="dialog"   aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="card">
                                <div class="card-header bg-padrao">
                                    <h4 class=" text-white text-center" ><span class="glyphicon glyphicon-shopping-cart"></span> Meu Carrinho</h4>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        if ($contcar == 0) { ?>
                                            <div class="alert alert-danger text-center justify-content-center" role="alert">
                                                Nenhum Item adicionado no carrinho
                                            </div>
                                    <?php 
                                        }
                                        else{ ?>
                                            <table class="table table-sm">
                                                <thead class="thead-primary">
                                                    <tr class="text-center">
                                                        <th scope="col">#</th>
                                                        <th scope="col">Item</th>
                                                        <th scope="col">Quantidade</th>
                                                        <th scope="col">Preço</th>
                                                        <th scope="col">Sub Total</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                        <?php 
                                            for($i=1;$i<=$contcar;$i++){?>
                                                    <tr class="text-center">
                                                        <td>
                                                            <img style="width:70px; height:70px;" <?php echo " src='/fontes/".$_SESSION["carrinho"][0]['Produtos']['caminhoimg'][$i-1]."'" ?>> 
                                                        </td>
                                                        
                                                        <td>
                                                            <?php echo $_SESSION["carrinho"][0]['Produtos']['descproduto'][$i-1] ?>
                                                        </td>
                                                        <td class="align-center text-center">  
                                                            <?php echo $_SESSION["carrinho"][0]['Produtos']['Quantidade'][$i-1] ?>
                                                        </td>
                                                        <td>  
                                                            <?php echo $_SESSION["carrinho"][0]['Produtos']['PrecoVenda'][$i-1] ?>
                                                        </td>
                                                        <td>  
                                                            <?php echo $_SESSION["carrinho"][0]['Produtos']['SubTotal'][$i-1] ?>
                                                        </td>
                                                    </tr>
                                        <?php 
                                            } 
                                        } ?>
                                                </tbody>
                                            </table>
                                </div>
                            </div>
                            <?php if ($contcar > 0) { ?>
                            <div class="row py-3">
                                <div class="col-md-12 text-right">
                                    <h5 class=" text-primary mr-2">Valor Total : R$ 
                                    <?php 
                                        echo round($_SESSION["carrinho"][1]['PrecoTotal'],2);
                                    ?>
                                    </h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    
                                    <button class="btn btn-primary btn-lg my-2" id="btnfechapedido" style="float:right;margin-right:10px;margin-left:10px;" >Fechar Pedido</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-sm my-2" id="btnesvaziacar" style="float:right;margin-right:10px;"  >Esvaziar Carrinho</button>
                                    
                                    <button class="btn btn-primary btn-sm my-2" id="btncontinar" style="float:right;margin-right:10px;" onclick="continuacompra();" >Continuar Comprando</button>
                                </div>
                            </div>

                            <?php } ?>
                        </div>
                    </div>
                
                </div>

            </li>
        </ul>
    </div>
    <form>
        <input type="hidden" name="tipoPesqtemp" id="tipoPesqtemp">
        <input type="hidden" name="valorcampotemp" id="valorcampotemp">
        <input type="hidden" name="totalpagtemp" id="totalpagtemp">
        <input type="hidden" name="pagatualtemp" id="pagatualtemp">
        <input type="hidden" name="posregtemp" id="posregtemp">
        <input type="hidden" name="acaopesquisar" id="acaopesquisar">
        <input type="hidden" name="contcar" id="contcar" <?php echo "value='".$contcar."'"?>>
    </form>
</nav>

<div class="top-content" id="divpromo">
    <div class="container">
        <div id="carouselpromo" class="carousel slide bg-dark  mt-4 mb-4 w-100" data-ride="carousel">
                    
        </div>      
    </div>
</div>
    
<div class="container" id="divprincipalCAB" >
    <div class="row" id="divpesqprod" style="display:none;">
        <div class="card my-4 mx-auto border-primary" id ="divcardprod">
            <div class="card-header text-white bg-padrao" id="divprincipalprod" style="display:none;">
                <div id="titulodadosprod" style="display:none;">
                    <h5 class="card-title text-center justify-content-center" id="tituloCard" >Produtos em Promoção</h5>

                    <div class="input-group col-lg-3 col-md-3" style="float:right;">
                        <?php $qtdporpag = (isset($_SESSION["qtdporpag"])) ? $_SESSION["qtdporpag"] : 10; ?>
                        <select class="custom-select" id="inputNumPag" aria-label="Exemplo de   select com botão addon">  
                            <option <?php echo ($qtdporpag==5) ? "selected" :"" ?> value="5" title="5">Cinco</option>  
                            <option <?php echo ($qtdporpag==10) ? "selected" :"" ?> value="10" title="10">Dez</option>
                            <option <?php echo ($qtdporpag==30) ? "selected" :"" ?> value="30">Trinta</option>
                            <option <?php echo ($qtdporpag==60) ? "selected" :"" ?> value="60">Sessenta</option>
                        </select>

                    </div>
                </div>
                <div id="titulodadosNaoprod" style="display:none;">
                </div>
            </div>
            <div class="card-body" id="gridProdutosPesq" style="diplay:none;">
                <div class="row d-flex justify-content-center my-2 mx-auto" id="tabProduto">
                    
                </div>
                <div class="row d-flex justify-content-center my-2" id="Paginacao">

                </div>
            </div>
        </div>
    </div>
    <script language="javascript">
        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });
        
        function MostraDivCar(idprod){
            console.log("testantoooooo");
            $('#divcarr'+idprod).removeClass("d-none");
            $('#divcarr'+idprod).addClass("my-2");
            
        }
        function EscondeDivCar(idprod){
            
            $('#divcarr'+idprod).addClass("d-none");
        }
        function mostra(idprod){
            var div='';
           
            $('#btncolocacari'+idprod).popover({
                placement:"top", 
                trigger:"manual",
                html: true,
                container: "body", 
                title : "Carrinho",
                content:'<form><input type="text"/></form>'

             
                 
            }); 
            $('#btncolocacari'+idprod).popover('show');
            }
               

            
        
        
        
        
        
        $('.carousel.carousel-multi-item.v-2 .carousel-item').each(function(){
            var next = $(this).next();
            if (!next.length) {
                next = $(this).siblings(':first');
            }
            next.children(':first-child').clone().appendTo($(this));

            for (var i=0;i<4;i++) {
                next=next.next();
                if (!next.length) {
                    next=$(this).siblings(':first');
                }
                next.children(':first-child').clone().appendTo($(this));
            }
        });
        
        window.tdiff = []; fred = function(a,b){return a-b;};
            
        function TamanhoTela(){
            var larguratela  = window.innerWidth;
            var alturatela   = window.innerHeight;
            var shtmconta  = "";
            var shtmlogar  = "";
            var shtmcar    = "";
            $('#dropBtnminhaconta').html("");
            $('#btnlogar').html("");
            $('#btncarrinho').html("");
            if (larguratela <= 719){
                console.log("Menor:."+larguratela);
                shtmconta  = '<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>';
                var contcar = $("#contcar").val();
                if (contcar <= 0){
                    shtmcar    = '<span class="glyphicon glyphicon-shopping-cart"></span>';
                } else{
                    shtmcar    = '<span class="glyphicon glyphicon-shopping-cart">('+contcar+')</span>';
                }
                shtmlogar = '<span class="glyphicon glyphicon-user"></span>';
            }else{
                shtmconta = '<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span> Minha Conta';
                var contcar = $("#contcar").val();
                if (contcar <= 0){
                    shtmcar   = '<span class="glyphicon glyphicon-shopping-cart"></span> Meu Carrinho';
                }else{
                    shtmcar   = '<span class="glyphicon glyphicon-shopping-cart"></span> Meu Carrinho('+contcar+')';    
                }
                
                shtmlogar = '<span class="glyphicon glyphicon-user"></span> Logar';
            }
            $('#btnlogar').html(shtmlogar);
            $('#btncarrinho').html(shtmcar);
            $('#dropBtnminhaconta').html(shtmconta);
            
            //console.log("Largura e Altura" +larguratela +" - "+ alturatela );
            <?php ?>
            var screenWidth = screen.width;
            var screenHeight = screen.height;
        }
        window.addEventListener('resize', function(){
	        TamanhoTela();
        });
         window.addEventListener('load', function(){
            document.getElementById("divpromo").style.display = "block";
	        TamanhoTela();
            CapturaGrupoProd();
            CapturaPromoProduto();
        });
        
        function CapturaPromoProduto(){
            $.ajax({
                type : "GET",
                data : "visualiza=true",
                url  : "/fontes/divpromocoesprod.php",
                async:false
                
            }).done( function(html){
                console.log("Aqui:"+html);
                $("#carouselpromo").html(html);
                
            }).fail(function(){
                
            })
    
            
            
        }
        
        function CapturaGrupoProd(){
            $.ajax({
                type : "GET",
                data : "comgrupo=true",
                url  : "/fontes/listaGrupoProdutos.php",
                async:false
                
            }).done( function(html){
                console.log("Aqui:"+html);
                $("#selectgrupo").html(html);
                
            }).fail(function(){
                
            })
            
            $.ajax({
                type : "GET",
                
                url  : "/fontes/listaGrupoProdutos.php",
                async:false
                
            }).done( function(html){
                console.log("Aqui22:"+html);
                $(".dropdowngrupo .dropdowngrupo-content").html(html);
                
            }).fail(function(){
                
            })
            
        }
    </script>
    
    <script>
        $('#btnesvaziacar').click(function(e){
            e.preventDefault();
            window.location.href ="fontes/esvaziacar.php";
        });
        $('#btnlogar').click(function(e){
            e.preventDefault();
            window.location.href ="fontes/loginuser.php";
        });
        
        $('#btnlogout').click(function(e){
            e.preventDefault();
            window.location.href ="fontes/logout.php";
        });
        
        $('#selectgrupo').change(function(e){
            $("#pselgrupo").html("Grupo: "+$('#selectgrupo option:selected').text());
        });
        
        function is_empty(x){
           return ( 
                (typeof x == 'undefined')
                            ||
                (x == null) 
                            ||
                (x == false)  //same as: !x
                            ||
                (x.length == 0)
                            ||
                (x == "")
                            ||
                (x.replace(/\s/g,"") == "")
                            ||
                (!/[^\s]/.test(x))
                            ||
                (/^\s*$/.test(x))
          );
        }
        
        $('#btn_Pesq').click(function(e){
            var valcampo= $('#edt_Pesq').val();
            var grupo   = $('#selectgrupo').val();
            
            var qtdlimitpag = retornaLimitePag();
            $('#tituloCard').html("Pesquisando por: "+valcampo);
            if (is_empty(valcampo)){
                
                $('#pmsgcampo').removeClass('d-none');
                $('#pmsgcampo').delay(500).fadeIn(1000);
                setTimeout(function(){
                    $('#pmsgcampo').delay(500).fadeOut(1000);
                    $('#pmsgcampo').addClass('d-none');
                    $('#edt_Pesq').focus();
                },2000);
                
            } 
            else{
                $.ajax({
                    type : "GET",
                    data : "posreg=0&qtdporpag="+qtdlimitpag+"&pesquisapor=desc&valcampo="+valcampo+"&idgrupo="+grupo,
                    url  : "fontes/listaProdutos.php",
                    async:false,
                    beforeSend: function(){
                            //aqui
                            $("#btn_Pesq").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Aguarde...');
                    }
                }).done( function(data){
                    var Dados = $.parseJSON(data);
                        retornatabprod(Dados);

                    setTimeout(function(){
                        $("#btn_Pesq").html('<span class="glyphicon glyphicon-search"></span>');
                    }, 1000);


                }).fail(function(data){

                })
            }
        });
        $('#btngrupo').click( function(e){
            $("#navbarSupportedContent").show();    
        });
        
        // clica em grupo de produto
        $('.dropdowngrupo').hover(function(){
                                            $('.dropdowngrupo-content').css("display","block");
                                          },function(){
                                            $('.dropdowngrupo-content').css("display","none");  
                                          });
       
        
        function AbreProdGrupo(codgrupo,nomegrupo){
            console.log("enrtrouu");
            var qtdlimitpag = retornaLimitePag();
            var idgrupo = codgrupo;
            $('#tituloCard').html("Grupo de Produto: "+nomegrupo);
            $("#navbarSupportedContent").hide();
            $(".dropdowngrupo-content").css("display","none");
            closeNav();
            
            $.ajax({
                type : "GET",
                data : "posreg=0&qtdporpag="+qtdlimitpag+"&pesquisapor=grupo&valcampo="+idgrupo,
                url  : "/fontes/listaProdutos.php",
                async:false
            }).done( function(data){
                var Dados = $.parseJSON(data);
                retornatabprod(Dados);
                
            }).fail(function(data){
                
            })
        }            
        
        $(".dropdowngrupo .dropdowngrupo-content a.nav-link").click( function(e){
            e.preventDefault();
            console.log("enrtrouu");
            var qtdlimitpag = retornaLimitePag();
            var idgrupo = $(this).attr("title");
            $('#tituloCard').html("Grupo de Produto: "+$(this).html());
            $("#navbarSupportedContent").hide();
            $(".dropdowngrupo-content").css("display","none");
            closeNav();
            
            $.ajax({
                type : "GET",
                data : "posreg=0&qtdporpag="+qtdlimitpag+"&pesquisapor=grupo&valcampo="+idgrupo,
                url  : "fontes/listaProdutos.php",
                async:false
            }).done( function(data){
                var Dados = $.parseJSON(data);
                retornatabprod(Dados);
                
            }).fail(function(data){
                
            })
        });
        
        $('#divPrincipalCAB div#Paginacao nav ul li a').click(function(e){
            e.preventDefault();
           
            var strtitle = $(this).attr("title");
            alert(strtitle);
            
        });
        
        $('#inputNumPag').change(function(e){
            console.log(retornaLimitePag()); 
            e.preventDefault();
            var qtdlimitpag  = retornaLimitePag();
            var vcampo       = document.getElementById("valorcampotemp").value;
            var spesquisapor = document.getElementById("tipoPesqtemp").value;
            
            $.ajax({
                type : "GET",
                data : "posreg=0&qtdporpag="+qtdlimitpag+"&pesquisapor="+spesquisapor+"&valcampo="+vcampo,
                url  : "fontes/listaProdutos.php",
                async:false
            }).done( function(data){
                var Dados = $.parseJSON(data);
                retornatabprod(Dados);
                
            }).fail(function(data){
                
            })    
        
        });
        function retornaLimitePag(){
            var e = document.getElementById("inputNumPag");
            var itemSelecionado = e.options[e.selectedIndex].value;
            return itemSelecionado;
        }
        
        function retornatabprod(data){
            var lista = '';
            var imgProd ='';
            var hadados = false;
                   
            $.each(data[0], function(chave,valor){
                var valorimg = valor['CAMINHOIMG'];
                hadados = true;
                if (valorimg == ''){
                    valorimg = 'imgexp123342.jpg';     
                }else {
                    console.log(valorimg)
                }
                
                if (verificaUrl("/fontes/img/"+valorimg)){
                    imgProd = "/fontes/img/"+valor['CAMINHOIMG']; 
                }
                else{
                    imgProd = "/fontes/img/prodsemimg.jpg";
                     
                }
                 
                    lista += '<div class="card text-center col-sm-6  col-md-4 col-lg-2 ml-2 mr-auto my-1 border-primary rounded-2">';
                    lista += '<img  class="card-img-top mx-auto my-2" style="width:100px;"  src="'+imgProd+'">';
                    lista += '<div class="card-body mx-auto">';
                    lista += '<h5 class="card-title">'+valor['DESCRICAO'].substring(50,0)+'</h5>';
                    lista +='<p class="card-subtitle">Preço: '+arredondarN(valor['PRECOVENDA'],2)+'</p>';
                    lista += '</div>';
                    lista += ' <div class="card-footer d-block">';
                    lista +='<a href="fontes/dadosprodcar.php?idproduto='+valor['IDPRODUTO']+'" class=" btn btn-primary mx-auto">Comprar</a>';
                    lista += '</div>';
                    
                    lista += '</div>'; 
            });
            
            if (hadados == true){
                document.getElementById("divpromo").style.display = "none";
                document.getElementById("divpesqprod").style.display = "block";
                document.getElementById("gridProdutosPesq").style.display = "block";
                document.getElementById("divprincipalprod").style.display = "block";
                document.getElementById("titulodadosprod").style.display = "block";
                document.getElementById("titulodadosNaoprod").style.display = "none";
                
                
                $('#tabProduto').html(lista);
                var TotalReg    = 0;
                var pesquisapor = "";
                var valcampo    = "";
                var pospag      = 0;
                var pagatual   = 1;

                $.each(data[1], function(chave,valor){

                    if (chave == "TotalReg"){
                        document.getElementById("totalpagtemp").value = valor;
                        TotalReg = valor;
                    }
                    if (chave == "pesquisapor"){
                        document.getElementById("tipoPesqtemp").value = valor;
                        pesquisapor = valor;
                    }
                    if (chave == "valcampo"){
                        document.getElementById("valorcampotemp").value = valor;
                        valcampo = valor;
                    }

                    if (chave == "posreg"){
                        document.getElementById("posregtemp").value = valor;
                        pospag = valor;
                    }
                    if (chave == "numpag"){
                        document.getElementById("pagatualtemp").value = valor;
                        pagatual = parseInt(valor);
                    }

                })
                console.log('total reg>'+TotalReg);
                var NumdPag  = Math.ceil(TotalReg/retornaLimitePag());
                var UltPag       = "\'"+NumdPag+"\'"; 
                var tipopesquisa = "\'"+pesquisapor+"\'";
                var valcamppesq  = "\'"+valcampo+"\'";
                var valtotreg    = "\'"+TotalReg+"\'";
                var ProxPagina   = 0;
                var AntPagina    = 0;
                if (pagatual < parseInt(NumdPag)){
                    ProxPagina   = parseInt(pagatual) + 1;
                }
                else{
                    ProxPagina = parseInt(NumdPag);
                }
                if (pagatual != 1){
                    AntPagina   = pagatual - 1;
                }
                else{
                    AntPagina = 1;
                }

                var tempproxpag = "\'"+ProxPagina+"\'";
                var tempantpag  = "\'"+AntPagina+"\'";

                var estilo = "";

                console.log('Proxima Página>'+ProxPagina+' Pagina Anterior>'+AntPagina+
                            'Pagina Atual:'+pagatual);
                console.log('Total Página>'+NumdPag+' Total Registro>'+TotalReg);
                lista = '';
                lista +='<div class="row" id="divPaginacao">';
                lista +='<nav">';
                lista +='<ul class="bg-primary my-auto pagination pagination rounded-circle ">';

                if (pagatual==1){
                    estilo = 'class="page-item disabled"';
                }else{
                    estilo = 'class="page-item"';
                }

                lista +='<li '+estilo+'>';
                lista +=' <a class="page-link mx-auto my-auto" href="#"';
                lista +=' onclick="AbrirPagina('+tipopesquisa+','+valcamppesq+','+valtotreg+','+tempantpag+','+pagatual+');"';
                lista +=' aria-label="Previous">';
                lista +=' <span aria-hidden="true">&laquo;</span> Anterior';
                lista +=' <span class="sr-only">Primeiro</span>';
                lista +=' </a></li>';
                
                console.log('numero total: '+NumdPag+' Numero atual pagina: '+pagatual);
                
                Numtemp = pagatual + 9;
                if (Numtemp > NumdPag){
                    Numtemp = NumdPag;
                }
                
                for(var i=pagatual;i<=Numtemp;i++){
                            
                    if (pagatual==i){
                        estilo= 'class="page-item active mr-1 rounded-circle"';
                    }
                    else{
                        estilo= 'class="page-item mr-1 rounded-circle"';
                    }

                    var numpag       = "\'"+i+"\'";
                    lista +='<li '+estilo+' ><button btn btn-primary  mr-1 href="#" onclick="AbrirPagina('+tipopesquisa+','+valcamppesq+','+valtotreg+','+numpag+','+pagatual+');" class="page-link"'; 
                    lista +='       title="pesquisapor='+pesquisapor+'&valcampo='+valcampo+'&NumPag='+i+'">';
                    lista +=i+'</button></li>';
                }
                if (pagatual==NumdPag){
                    estilo = 'class="page-item disabled"';
                }else{
                    estilo = 'class="page-item"';
                }

                lista +='<li '+estilo+'>';
                lista +=' <a class="page-link" href="#"';
                lista +=' onclick="AbrirPagina('+tipopesquisa+','+valcamppesq+','+valtotreg+','+tempproxpag+','+pagatual+');"';
                lista +=' aria-label="Previous">';
                lista +=' <span aria-hidden="true">&raquo;</span> Próximo';
                lista +=' <span class="sr-only">Último</span>';
                lista +=' </a></li></ul></nav>';
                lista +='</div>';
                $('#Paginacao').html(lista);

            }
            else{
                document.getElementById("divpromo").style.display = "block";
                document.getElementById("divpesqprod").style.display = "block";
                document.getElementById("divprincipalprod").style.display = "block";
                document.getElementById("gridProdutosPesq").style.display = "none"; 
                document.getElementById("titulodadosprod").style.display = "none";
                document.getElementById("titulodadosNaoprod").style.display = "block";
                
                lista = '<div class="alert alert-danger text-center justify-content-center" role="alert">';
                lista += 'Nenhum Produto Encontrado</div>';
                $('#titulodadosNaoprod').html(lista);
                $('#Paginacao').html("");
            }
        }
        function Logout(){
            
        }
        function AbrirPagina(pesquisapor,valcampo,totreg,numpag,pagatual){
            var posreg = ((numpag*retornaLimitePag()) - retornaLimitePag() ); 
            
            console.log(retornaLimitePag()+' NumPagi:'+numpag+' Posicao:'+posreg);
            $.ajax({
                type : "GET",
                data : "numpag="+numpag+"&posreg="+posreg+"&qtdporpag="+retornaLimitePag()+"&pesquisapor="+pesquisapor+"&valcampo="+valcampo+"&pagatual"+pagatual,
                url  : "fontes/listaProdutos.php",
                async:false
            }).done( function(data){
                var Dados = $.parseJSON(data);
                retornatabprod(Dados);
            }).fail(function(data){
                
            })   
        }
            
        function verificaUrl(url) {
            var http = new XMLHttpRequest();
            http.open('HEAD', url, false);
            http.send();
            return http.status != 404;
        }
        function openNav() {
            console.log("saiu");
            document.getElementById("mySidenav").style.width = "20%";
            document.getElementById("mainside").style.marginLeft = "20%";
            document.getElementById("mainprincipal").style.marginLeft = "20%";
            
        }

        function closeNav() {
            console.log("entrou");
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("mainside").style.marginLeft= "0";
            document.getElementById("mainprincipal").style.marginLeft = "0";
        }
        function retornatelaindex(){
            $.ajax({
                type : "GET",
                data : "acaopesquisar=true",
                url  : "/fontes/destroysessao.php",
                async:false
            }).done( function(data){
                window.location.href ="index.php";    
            }).fail(function(data){
            })
            
        }
        function continuacompra(){
            $('#modalcarrinho').modal('toggle');
        }
        
        function mostrapromo(pesquisa){
            console.log("Saiuuuuuuu");
            console.log("ver"+pesquisa);
            if (pesquisa == false){
            document.getElementById("divpromo").style.display = "block";
            }
            
        }
        function escodepromo(){
            console.log("entrouuuuuuuuuuuuuuuuuuuuuuuuuu");
            document.getElementById("divpromo").style.display = "none";
            
        }
        

    </script>
    <script src="/js/jsFuncoes.js">  </script>
    
    

</div>
</main>
</body>
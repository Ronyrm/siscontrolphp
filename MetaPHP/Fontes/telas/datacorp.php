<?php
    include_once("../../connDB.php");
    include_once("../../capturadadoslogado.php");
    
    if (($codusuario!="") || ($codusuario!="0") ){
        $userlogado = true;
        $codusp   = "'".$codusuario."'";
        $codunip  = "'".$codunidade."'"; 
        $DiaInip  = "'".$diaini."'";
        $DiaFimp  = "'".$diafim."'";
        $MesAno   = "'".$mesano."'";
        $DescUni  = "'".$descunidade."'";
        
        $MovEntrada = "E"; 
        $MovSaida   = "S"; 
        $MovEntrada  = "'".$MovEntrada."'";
        $MovSaida  = "'".$MovSaida."'";
    }
    else {
        $userlogado = false;
    }
?>
<html>
<head>
    <?php include_once("../corpopag/head.html"); ?>
    <style>
        <?php include_once("../../css/cabecalho.css"); ?>
        <?php include_once("../../css/datacorp.css"); ?>
    </style>
</head>
<body data-spy="scroll" id="bodyprinc" data-target="#DivPrincipal" data-offset="50">
<main id="mainprincipal">
    <div class="d-flex" id="wrapper">
        <nav id="sidebar" class="bg-padrao">
            <div class="sidebar-header">
                <a class="navbar-brand text-white"  href="#" id="btnindex" onclick=" MostraTelaPrincipal();">
                        <img  src="../../img/corp.ico" 
                                 style=" widht:30px; height:30px; margin-left:0px" alt=""> Data Corp
                </a>
            </div>
            <ul class="list-unstyled components">
                <div class="dropdown-divider"></div>
                <li>
                    <a href="#PedidoSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Pedidos</a>
                    <ul class="collapse list-unstyled bg-padrao" id="PedidoSubmenu">
                        <li>
                            <a href="#NovoPedido" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Novo Pedido</a>
                            <ul  class="collapse list-unstyled bg-padrao" id="NovoPedido">
                                <li>
                                    <a  href="#" onclick="InserirNovoPedido('S',<?php echo $codunip.','.$codusp.','.$DiaInip.','.$DiaFimp.','.$MesAno.','.$DescUni; ?>);">Saída</a>
                                </li>
                                <li>
                                    <a href="#" onclick="InserirNovoPedido('E',<?php echo $codunip.','.$codusp.','.$DiaInip.','.$DiaFimp.','.$MesAno.','.$DescUni; ?>);">Entrada</a>
                                </li>
                            </ul>
                            
                            
                        </li>
                        <li>
                            <a href="#" onclick="BuscarPedidos(<?php echo $codusp.','.$codunip.','.$DiaInip.','.$DiaFimp.','.$MovSaida.','.$MesAno.','.$DescUni; ?>);">Pedidos de Saídas</a>
                        </li>
                        <li>
                            <a href="#" onclick="BuscarPedidos(<?php echo $codusp.','.$codunip.','.$DiaInip.','.$DiaFimp.','.$MovEntrada.','.$MesAno.','.$DescUni; ?>);">Pedidos de Entradas</a>
                        </li>
                        
                    </ul>
                </li>
                <div class="dropdown-divider"></div>
                <li >
                    <a href="#NFSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Notas Fiscais</a>
                    <ul class="collapse list-unstyled bg-padrao" id="NFSubmenu">
                        <li>
                            <a href="#" onclick="BuscarPedidos(<?php echo $codusp.','.$codunip.','.$DiaInip.','.$DiaFimp.','.$MovSaida.','.$MesAno.','.$DescUni; ?>);">Notas de Saídas</a>
                        </li>
                        <li>
                            <a href="#" onclick="BuscarPedidos(<?php echo $codusp.','.$codunip.','.$DiaInip.','.$DiaFimp.','.$MovEntrada.','.$MesAno.','.$DescUni; ?>);">Notas de Entradas</a>
                        </li>
                    </ul>
                </li>
                <div class="dropdown-divider"></div>
            </ul>
           
        </nav>
        
        <div id="content" class="container-fluid" p-0>
            <nav class="navbar navbar-expand-lg navbar-light bg-padrao d-block" id="NavMenucontent">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-padrao">
                        <a class="d-none d-lg-block"><span class="glyphicon glyphicon-menu-hamburger"></span> Menu </a> 
                        <a class="d-block d-lg-none d-xl-none"><span class="glyphicon glyphicon-menu-hamburger"></span></a> 
                    </button>
                    <ul class="nav narbar-nav bg-padrao">
                        <li class="nav-item dropdown bg-padrao">
                            <button class="btn btn-padrao" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        <?php echo "Olá ".$nomeusuario.", Seja Bem-Vindo!" ?>
                            </button>
                            <div class="bg-padrao justify-content-center dropdown-menu px-2 "  aria-labelledby="navbarDropdown">
                                <button type="button" class="btn btn-padrao  my-1  " onclick="VoltarPag();">Voltar Menu DataCorp</button>
                                <button type="button" class="btn btn-padrao my-1 " onclick="Logout();" href="#">Sair</button>

                            </div>
                            </li>
                    </ul>

                    <!--<button class="navbar-toggler text-white" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span style="cursor:pointer" >&#9776;</span>
                    </button>-->
                    

                </div>
            </nav>
            <div id="DivPrincipal" class="d-block mt-1 p-0 mx-auto" >
                <div class="modal fade" id="ModalMSG" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="ModalCenterTitle">Atenção</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body p-2">
                                <p id="pMSGModal"></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid" id="DivTelas">

                <!-- DIV LOGO TIPO IMAGEM -->
                    <div class = "mx-auto my-5" id="DivLogo" >
                    <img src="../../img/logometa2.png" class="img-fluid d-block mx-auto" alt="Meta Corporate SOlutions">
</div> 
                <!-- DIV GRID PEDIDOS -->
                    <div class="d-block" id="Divacaogrid">
                    <div id="DivMostraDados" class="d-none border bg-ligth" >
                        <div class="row d-flex align-items-center flex-column mx-0 bg-padrao" >
                            <p class="text-white h5" id="lblTituloMenu">Pedidos de Venda</p>
                        </div>
                        <div class="card mx-2" id="CardDados">
                            
                        </div>
                    </div>
                    <div class="d-none" id="DivMsgAlert" >
                        <div class="row w-50 d-flex align-items-center flex-column my-auto  mx-auto alert alert-warning" role="alert">
                            <p id="pMsgAlerta"></p>
                        </div>
                    </div>
                    <div class="d-none my-auto" id="DivLoading">
                        <div class="row d-flex align-items-center flex-column my-auto  mx-auto">
                            <p id="pLoading" class="text-primary">Buscando Pedidos </p>
                            <div class="spinner-border text-primary" role="status">

                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    </div>
                <!-- DIV DETALHES PEDIDOS -->
                    <div class="d-none" id="DivacaoDetalhes">
                        <!--//aqui vai os detalhes-->
                        <div id="DivDetail" class="d-block" >
                        <button class="btn btn-primary position-absolute ml-1 mt-1" onclick="Voltargridped();"> <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar</button>



                        <div class="row d-flex-inline align-items-center flex-column p-2  mx-0 bg-padrao" >
                            <p class="text-white h5" id="lblNumPedido"></p>
                        </div>
                        <div class="card mx-0" id="CardDados">

                            <div class="card-body border border-success p-1">
                                <div class="container p-0">
                                    <ul class="nav nav-tabs" >
                                        <li class="active"><a id="btnDadosGerais" data-toggle="tab" class="active mr-1 mb-1 btn btn-outline-primary" type="button" href="#tabItemdadosgerais">Dados Gerais</a></li>
                                        <li><a id="btnDestina" data-toggle="tab" class="mr-1 mb-1 btn btn-outline-primary" type="button" href="#tabItemDestinatario">Destinatário</a></li>
                                        <li><a data-toggle="tab" class="mr-1 mb-1 btn btn-outline-primary" type="button" href="#tabItemitens">Itens</a></li>
                                        <li><a data-toggle="tab" class="mr-1 mb-1 btn btn-outline-primary" type="button" href="#tabItemCobranca">Cobrança</a></li>
                                        <li><a data-toggle="tab" class="mr-1 mb-1 btn btn-outline-primary" type="button" href="#tabItemValores">Valores</a></li>
                                        <li><a data-toggle="tab" class="btn btn-outline-primary" type="button" href="#tabItemObservacao">Observação</a></li>
                                    </ul>

                                    <div class="tab-content mt-2 p-2">
                                        <div id="tabItemdadosgerais" class="tab-pane active">


                                        </div>
                                        <div id="tabItemDestinatario" class="tab-pane ">


                                        </div>
                                        <div id="tabItemitens" class="tab-pane fade ">


                                        </div>
                                        <div id="tabItemCobranca" class="tab-pane fade ">

                                        </div>
                                        <div id="tabItemValores" class="tab-pane fade ">

                                        </div>
                                        <div id="tabItemObservacao" class="tab-pane fade ">

                                        </div>
                                    </div>
                                </div>
                                <!--<a href="#" class="btn btn-success" onclick="Voltargridped();">Voltar</a>-->
                            </div>
                        </div>
                    </div>

                    </div> 
                <!-- DIV NOVO PEDIDOS -->
                    <div class=" d-none container-fluid p-0" id="DivNovoPedido">
                        

                    </div>
                </div>

                
                
                
                
                


        </div>
        
            <nav id="navbottom" class="navbar fixed-bottom navbar-light bg-padrao align-items-center d-block">
            <div class="d-flex align-items-center flex-column col-12">
                <h6 class="text-white text-center">Unidade: <small><?php echo $descunidade; ?></small>
                    Mês/Ano: <small><?php echo $mesano; ?></small></h6>
            </div>
        </nav>
        </div>
    </div>
</main>
</body>
<script>
    
    

    var dadospedido = Array();
    var dadosrec= Array();
    var apedidoindex = Array();
    

    var indexfiltro = '0';
    
   
    
    $(document).ready(function () {

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
         
            
        
        
        
    });
    window.onload = function(e)
    {
        VerificaTela();
        
    }
    window.addEventListener('resize', function(){
        VerificaTela();
    });
    window.addEventListener('load', function(){
        
        
    });
    

    
    function VoltarPag(){
        window.location.href ="telaprincipal.php";
    } 
    function Logout() {
        window.location.href ="../../logout.php";
    }
    
    function edtpesqchange(){
        
    }

    function VerificaTela(){
        var larguratela = window.innerWidth;
        var alturatela = window.innerHeight;
        console.log(larguratela);
        console.log(alturatela);
        
	    if (larguratela < 640 || alturatela < 480) {
             // sirva a versão pra celular
             $('#DivPrincipal').addClass('p-1');
        } else if (larguratela < 1024 || alturatela < 768) {
             // talvez seja uma boa usar versão pra tablet
            $('#DivPrincipal').removeClass('p-1');
        } else {
            // sirva a versão normal
            $('#DivPrincipal').removeClass('p-1');
        }
    }
    
</script>
<script>
    var sSppiner = '<span class="spinner-border spinner-border-sm d-block" role="status" aria-hidden="true" ></span>';
    
    var varDataInicial = <?php echo "'".$diaini."'"; ?>;
    var varDataFinal = <?php echo "'".$diafim."'"; ?>;
    var varCodUsuario = <?php echo $codusuario; ?>;
    var varCodUnidade = <?php echo $codunidade; ?>;
    var varDescUnidade = <?php echo "'".$descunidade."'"; ?>;
    var varMesano = <?php echo $mesano; ?>;
    var varTipoMovimento = '';
    var varTipoCFOP = "";
    var aretorno = new Array();
    var arrayMicroConta = new Array();
        

    <?php include "../../js/jsfunc.js";  ?>
    <?php include "../../js/jsretornadadostabela.js";  ?>
    <?php include "../../js/telaspedido.js";  ?>
    <?php include "../../js/jsdatacorp.js"; ?>  
    <?php include "../../js/jspedido.js";  ?>
    
</script>
<script src="../../js/validator.js"></script>
<script src="../../js/validator.min.js"></script>
    
</html>
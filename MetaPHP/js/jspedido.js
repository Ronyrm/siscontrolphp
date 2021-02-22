function InserirNovoPedido (TpMov,CodUnidade,CodUsuario,DiaIni,DiaFim,MesAno,DescUni){
    varTipoMovimento = TpMov;
    console.log("Unidade:"+CodUnidade);
    $("#DivLogo").hide();
       
    $("#Divacaogrid").removeClass("d-block");
    $("#DivacaoDetalhes").removeClass("d-block");
    $("#navbottom").removeClass("d-block");
    
    $("#Divacaogrid").addClass("d-none");
    $("#DivacaoDetalhes").addClass("d-none");
    $("#navbottom").addClass("d-none");
    
    $("#navbottom").hide();
    
    $('#sidebar').toggleClass('active');
    
    $("#DivNovoPedido").removeClass("d-none");
    $("#DivNovoPedido").addClass("d-block");
    $("#DivNovoPedido").html(RetornaTelaNovoPedido(TpMov,CodUnidade,CodUsuario));
    $("#modalcarrinho").html(MontaModalItens(null));
    
    
    
    validateCamposDadosGerais();
    validateCamposCobranca();
    validateItemPedido();
    
    $('#edtUnidade, #edtTransFiscal, #edtVendedor, #edtEntidade, #edtCFOPPed').change(
        function(e){ 
            e.preventDefault();
            validateCamposDadosGerais()
    });
    $('#edtProduto,#edtCFOPItem,#edtQtdItem,#edtVolumeItem,#edtPesoItem,#edtValUntItem,#edtValDescItem').change(
        function(e){
            e.preventDefault();
            validateItemPedido();
        });
    $('#edtLocalEntrega, #edtPlanoPagto, #edtTransportador, #edtPortador, #edtCarteira').change( 
        function(e){
            e.preventDefault();
            validateCamposCobranca();
        });
    $('#edtLocalEntrega, #edtPlanoPagto, #edtTransportador, #edtPortador, #edtCarteira').blur( 
        function(e){
            e.preventDefault();
            validateCamposCobranca();
        });
    
    var aPedido = new Array(); 
    
    $('#sidebar').toggleClass('none');
    
    $('#NavMenucontent').fadeOut(1000).removeClass('d-block');
   
    $('#colDadosGerais').collapse();  
    //

    //$('#NavMenucontent').addClass('d-none');
    //$('#NavMenucontent').removeClass('d-block');
    
    
    

    
}
function BuscarPedidos(CodUs,CodUni,DiaIni,DiaFim,TpMov,MesAno,DescUni){
    
    $("#DivNovoPedido").removeClass("d-block");
    $("#DivNovoPedido").addClass("d-none");
    
    $('#sidebar').toggleClass('active');
    $("#DivLogo").hide();
    Voltargridped();
    var Strget ="CodUs="+CodUs+"&CodUni="+CodUni+"&DiaIni="+DiaIni+"&DiaFim="+DiaFim+"&TpMov="+TpMov;
    console.log(Strget);
    var TipoMov= (TpMov == 'S')?"Saída":"Entrada";
        
        
    $("#DivLoading").removeClass("d-none");
    $("#DivLoading").addClass("d-block");
    var strpload="";
        
    $.ajax({
        type:"GET",
        url:"../Consultas/getpedidos.php?"+Strget,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            var strpload="Buscando Pedidos de: "+TipoMov;
            $("#pLoading").html(strpload);
                       
        },
        afterSend: function(){
            $("#DivLoading").removeClass("d-block");
            $("#DivLoading").addClass("d-none");
            console.log("Sair=Ajax");
        }
                    
    }).done( function(data){
                
        dadosrec = $.parseJSON(data);
        var achou = dadosrec[0]["pesquisa"];
                
        if (achou){
                    
            dadospedido = dadosrec[1];
                    
            PovoaDivDadosPedido(dadospedido,TpMov);
            AtulizaFiltro();
        }
        else{
                    
            $("#DivMostraDados").removeClass("d-none");
            //$("#DivMsgAlert").removeClass("d-none");
            $("#DivMsgAlert").addClass("d-block");
            var strpMsg = "Nenhum Pedido de "+TipoMov+"foi encontrado no mês/ano: "+MesAno+ " para a unidade logada:"+DescUni;
                    
            $("#pMsgAlerta").html(strpMsg);
            $("#DivLoading").removeClass("d-block");
            $("#DivLoading").addClass("d-none");
        }
                
    }).fail( function(){
        console.log("ALGO DEU ERRADO");
    }).always( function(){
            
    });
    
}
function CancelarNovoPed(){
    
    
    MostraTelaPrincipal();
    $('#NavMenucontent').fadeIn(1000);
    $('#NavMenucontent').addClass('d-block').fadeIn(1000);

    $('#sidebar').toggleClass('active');
    
}
function ConfirmarPedido(){
    //aPedido["idplanopagto"] =  1;
    //console.log(aPedido);
    console.log($('#valTotalItens').val());
    
    $.ajax({

        type:"POST",
        url:"../insert/setpedido.php",
        data: {Pedido:aPedido},
        cache: false,
        processData:true,
        beforeSend: function(){
            $('#btnConfirmarPedido').html(sSppiner);
            var strpload="Buscando CFOP referente a pesquisa";
        },
        afterSend: function(){
        }
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
            console.log(arrayRetorno);
            console.log(arrayRetorno["gravou"]);
            if (arrayRetorno["gravou"]==true){
                
                $('#divMsgAlerta').removeClass('d-none');
                $('#divMsgAlerta').addClass('d-block');
                $('#divMsgAlerta').removeClass('alert-danger');
                $('#divMsgAlerta').addClass('alert-primary');
                $('#divMsgAlerta').html("<p> O Pedido:"+arrayRetorno["numeropedido"]+" foi Inserido com Sucesso!</p>"+
                                   "<p>"+sSppiner+" Redirecionando Grid de Pedidos!</p>");
        
                setTimeout(
                    function()
                    {
                        $('#divMsgAlerta').addClass('d-none');
                        $('#divMsgAlerta').removeClass('d-block');
                        $('#divMsgAlerta').addClass('alert-danger');
                        $('#divMsgAlerta').removeClass('alert-primary');
                        BuscarPedidos(varCodUsuario,varCodUnidade,varDataInicial, varDataFinal,varTipoMovimento,varMesano,varDescUnidade);
                                
                    },2000);
                
                
                
    
    
    
     
                //<input id="edtDiaInicial" type="hidden" value="<?php echo $diaini; ?>"/>
                //<input id="edtDiaFinal" type="hidden" value="<?php echo $diafim;?>"/>
                //<input id="edtUsuarioLogado" type="hidden" value="<?php echo $codusuario; ?>"/>
                //<input id="edtUnidadeLogada" type="hidden" value="<?php echo $codunidade; ?>"/>
                //<input id="edtTipoMovimento" type="hidden" value=""/>
            }
            else{
                $('#DivModalInfoMsg').html('Erro ao gravar o pedido!');
                $('#DivModalInfo').modal('show');    
            }
            
        }).fail( function(){
            console.log("ALGO DEU ERRADO");
        }).always( function(){
            $('#btnConfirmarPedido').html('<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Confirmar');

        });
}

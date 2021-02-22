function ClicaCheckVeiculo(){
    console.log(document.getElementById('chkHabVeiculo').checked);
    if (document.getElementById('chkHabVeiculo').checked)
    {
        $('#divedtveiculo').removeClass('d-none');
        $('#divedtplacaveiculo').removeClass('d-none');
        $('#divedtufveiculo').removeClass('d-none');
        $('#lblveiculo').html("Desabilitar Veículo");
        
    }
    else{
        $('#divedtveiculo').addClass('d-none');
        $('#divedtplacaveiculo').addClass('d-none');
        $('#divedtufveiculo').addClass('d-none');
        $('#lblveiculo').html("Habilitar Veículo");
    }
        
}

function PesquisarPreco(CodProduto){
    aPesqProd = {
        idplanopagto : aPedido["idplanopagto"],
        idunidade : aPedido["idunidade"],
        identidade : aPedido["identidade"],
        entidade : aPedido["entidade"],
        idvendedor : aPedido["idvendedor"],
        idlocalentrega : aPedido["idlocalentrega"],
        idmicroconta : aPedido["idmicroconta"],
        idproduto: CodProduto 
    }
    RetornaPrecoProduto(aPesqProd,'#edtValUntItem');
}
function BuscaCFOP(arrayDados,EdtCFOP,CodCFOP ){
    status = "N";
    if(($('#CodEntidade').val().length>0) &&
        ($('#CodTransFiscal').val().length>0))
    {
        $.ajax({
            type:"POST",
            url:"../Consultas/gettipocfop.php",
            data: {adados:arrayDados},
            cache: false,
            processData:true,
            async:true,
            success: function(data) {
                aretorno = $.parseJSON(data);
                
                status = "S";
                //varTipoCFOP = aretorno["retorno"];
               
                $(EdtCFOP).val(aretorno["retorno"]["descCFOP"]);
                $(CodCFOP).val(aretorno["retorno"]["idCFOP"]);
               

            },
            fail:function(data){
                status = "N";
                varTipoCFOP = "";
            }

        })
    }

}

// Botao VOlta Tela Cobrança
function btnCobranca_VoltarClick(){
    
                                   
    $('#col_Pagto').collapse('dispose');
    $('#colDadosGerais').collapse('show');
}
// Botao Proximo Tela Cobranca
function btnCobranca_ProximoClick(){
    btn = document.getElementById('btnCobranca_Proximo');
    if (!btn.disable){
        
        aPedido["idtransportador"] = (($('#CodTransportador').val().length==0)?'NULL' : $('#CodTransportador').val());
        aPedido["idveiculo"]       = (($('#CodVeiculo').val().length==0)?'NULL':$('#CodVeiculo').val());
        aPedido["idlocalentrega"]  = (($('#CodLocalEntrega').val().length==0)?'NULL':$('#CodLocalEntrega').val());
        aPedido["idplanopagto"]    = (($('#CodPlanoPagto').val().length==0)?'NULL':$('#CodPlanoPagto').val());
        aPedido["idcarteira"]      = (($('#CodCarteira').val().length==0)?'NULL':$('#CodCarteira').val());
        aPedido["idportador"]      = (($('#CodPortador').val().length==0)?'NULL':$('#CodPortador').val());
        aPedido["placaveiculo"]    = (($('#edtPlacaVeic').val().length==0)?'':$('#edtPlacaVeic').val());
        aPedido["ufveiculo"]       = (($('#edtUFVeic').val().length==0)?'':$('#edtUFVeic').val());
        
        $('#divCarrinho').removeClass('d-none');
        $('#col_Pagto').collapse('dispose');
        $('#colItens').collapse('show');

        document.getElementById('edtProduto').focus();
    }
}
// Botao VOlta Tela Item
function btnItem_VoltarClick(){
    $('#divCarrinho').addClass('d-none');
    $('#colItens').collapse('dispose');
    $('#col_Pagto').collapse('show');
}
// Botao Proximo Tela Item
function btnItem_ProximoClick(){
    btn = document.getElementById('btnItem_Proximo');
    if (!btn.disable){
        if ($('#valTotalItens').val() == 0 ){
            $('#DivModalInfoMsg').html('Nenhum Item inserido, Favor inserir acima de 1 item ');
            $('#DivModalInfo').modal('show');
        }
        else{
            $('#divCarrinho').addClass('d-none');
            $('#colItens').collapse('dispose');
            $('#col_HistPagto').collapse('show');
        }
    }
}
// Botão Proximo Tela Dados Gerais
function btnDadosGerais_ProximoClick(){
    btn = document.getElementById('btnDadosGerais_Proximo');
    if (!btn.disable){
        
        dtemissao = RetornaFormataDataToFB('#edtdatapedido');
        dtmov     = RetornaFormataDataToFB('#edtdatamovimento');
        console.log(dtmov);
        
        aPedido = 
        {
            idmicroconta: $('#CodTransFiscal').val(),
            idunidade: $('#CodUnidade').val(),
            identidade: $('#CodEntidade').val(),
            codpessoa: $('#CodPessoa').val(),
            entidade: $('#CbEntidade').children("option:selected").val(),
            idvendedor:  (($('#CodVendedor').val().length==0)?'NULL':$('#CodVendedor').val()),
            idcfop:   (($('#CodCFOPPed').val().length==0)?'NULL':$('#CodCFOPPed').val()),
            dtemissao: dtemissao,
            dtmovimento : dtmov,
            idusuario: $('#CodUsuarioLogado').val() 
            
        }
        
        $('#colDadosGerais').collapse('dispose');
        $('#col_Pagto').collapse('show');

    }
}
function btnHistoricoMsg_VoltarClick(){
    $('#divCarrinho').removeClass('d-none');
    $('#col_HistPagto').collapse('dispose');
    $('#colItens').collapse('Show');
}
function MontaModalItens(acarrinho){
    if (acarrinho != null){
    contitem = acarrinho["contitem"];
    $('#valTotalItens').val(contitem);
    }
    else{  contitem = 0;}

    divmodal = "";
    divmodal+=      '<div class="modal-dialog modal-lg">';
    divmodal+=          '<div class="modal-content">';
    divmodal+=              '<div class="card">';
    divmodal+=                  '<div class="card-header bg-padrao">';
    divmodal+=                      '<h4 class=" text-white text-center" ><span class="glyphicon glyphicon-shopping-cart"></span> Meu Carrinho</h4>';
    divmodal+=                  '</div>';
    divmodal+=                  '<div  class="card-body">';
    
    divmodal+=                              '<div id="divalertcarrinho" class="alert alert-danger text-center justify-content-center '+((contitem==0)?"d-block":"d-none")+' " role="alert">Nenhum Item adicionado no carrinho</div>'; 
    
    divmodal+=                      '<table id="tabitenscar" class="table table-sm">'; 
    divmodal+=                              '<thead id="thtitulos"  class="thead-primary">';
    divmodal+=                                  '<tr class="text-center">';
    divmodal+=                                      '<th scope="col">Item</th>';
    divmodal+=                                      '<th scope="col">Quantidade </th>';
    divmodal+=                                      '<th scope="col">Peso </th>';
    divmodal+=                                      '<th scope="col">Pç.Unt</th>';
    divmodal+=                                      '<th scope="col">Val.Líquido</th>';
    divmodal+=                                  '</tr>';
    divmodal+=                              '</thead>';
    divmodal+=                              '<tbody>';
    for(i=0;i<=contitem-1;i++) 
    {
        divmodal+=                              '<tr id="trItem_'+i+'" class="text-center">';
        //descrproduto
        divmodal+=                                  '<td><div class="row"><p>';
        divmodal+= acarrinho["carrinho"][i]["idproduto"]+' - '+ acarrinho["carrinho"][i]["descprod"];
        divmodal+= '</p></div><div class="row d-flex justify-content-center"><button type="button" class="btn bg-padrao text-white" id="BtnExcluirItem" onclick="ExcluirItemCarrinho('+i+');"><span class="glyphicon glyphicon-trash"></span><small>Remover</small></button></div>'
        divmodal+=                                  '</td>';
        //quantidade
        divmodal+=                                  '<td class="align-center text-center">';
        divmodal+=                                      acarrinho["carrinho"][i]["qtditem"];
        divmodal+=                                  '</td>';
        //Peso
        divmodal+=                                  '<td class="align-center text-center">';
        divmodal+=                                      acarrinho["carrinho"][i]["pesoitem"];
        divmodal+=                                  '</td>';
        //preço unitário
        divmodal+=                                  '<td>';  
        divmodal+=                                      acarrinho["carrinho"][i]["valuntitem"];
        divmodal+=                                  '</td>';
        //valor unitario
        divmodal+=                                  '<td>';  
        divmodal+=                                      acarrinho["carrinho"][i]["valliquido"];
        divmodal+=                                  '</td>';
        divmodal+=                              '</tr>';
    } 
    
    divmodal+=                                    '</tbody>';
    divmodal+=                              '</table>';
    divmodal+=                  '</div>';
    divmodal+=              '</div>';
    if (contitem > 0) 
    {       
        divmodal+=          '<div id="divtotaiscarrinho" class="row py-3">';
        divmodal+=              '<div class="col-md-4 text-right">';
        divmodal+=                  '<h5 id="HtotBrutoItem" class=" text-primary mr-2">Vl.Bruto : R$ ';
        divmodal+=                      acarrinho["totais"]["valortotalbruto"];
        divmodal+=                  '</h5>'; 
        divmodal+=              '</div>';
        divmodal+=              '<div class="col-md-4 text-right">';
        divmodal+=                  '<h5 id="HtotDescItem" class=" text-primary mr-2">Desconto : R$ ';
        divmodal+=                      acarrinho["totais"]["valortotaldesconto"];
        divmodal+=                  '</h5>';
        divmodal+=              '</div>';
        divmodal+=              '<div class="col-md-4 text-right">';
        divmodal+=                  '<h5 id="HtotLiqItem" class=" text-primary mr-2">Vl.Líquido : R$ ';
        divmodal+=                      acarrinho["totais"]["valortotalliquido"];
        divmodal+=                  '</h5>';
        divmodal+=              '</div>';
        divmodal+=          '</div>';
        /*divmodal+=          '<div class="row">';
        divmodal+=              '<div class="col-md-12">';
        divmodal+=                  '<button class="btn btn-primary btn-lg my-2" id="btnfechapedido" style="float:right;margin-right:10px;margin-left:10px;" >Fechar Pedido</button>';
        divmodal+=              '</div>';
        divmodal+=          '</div>';
        divmodal+=          '<div class="row">';
        divmodal+=              '<div class="col-md-12">';
        divmodal+=                  '<button class="btn btn-primary btn-sm my-2" id="btnesvaziacar" style="float:right;margin-right:10px;"  >Esvaziar Carrinho</button>';
                                    
        divmodal+=                  '<button class="btn btn-primary btn-sm my-2" id="btncontinar" style="float:right;margin-right:10px;" onclick="continuacompra();" >Continuar Comprando</button>';
        divmodal+=              '</div>';
        divmodal+=          '</div>';*/

    } 
    divmodal+=          '</div>';
    divmodal+=      '</div>';
                
    return divmodal;
    
}
function LimpaCampos(){
    $('#CodProduto').val("");
    $('#CodCFOPItem').val("");
    $('#edtQtdItem').val("");
    $('#edtVolumeItem').val("");
    $('#edtPesoItem').val("");
    $('#edtValUntItem').val("");
    $('#DescricaoProd').val("");
    $('#UndMedida').val("");
    $('#edtValbrutoitem').val("");
    $('#edtValDescItem').val(""); 
    $('#edtValLiqItem').val("");
    
    $('#edtProduto').val("");
    $('#edtCFOPItem').val("");
    
}


function InserirnoCarrinho(){
    CodProduto = $('#CodProduto').val();
    CodCFOP    = $('#CodCFOPItem').val();
    QtdItem    = $('#edtQtdItem').val();
    VolumeItem = $('#edtVolumeItem').val();
    PesoItem   = $('#edtPesoItem').val();
    ValUntItem = $('#edtValUntItem').val();
    DescProdut = $('#DescricaoProd').val();
    UndMed     = $('#UndMedida').val();
    ValBruto   = $('#edtValbrutoitem').val();
    ValDesc    = $('#edtValDescItem').val(); 
    ValLiq     = $('#edtValLiqItem').val(); 
    
      

    if (CodProduto.trim().length>=1){
        if (CodCFOP.trim().length>=1){
            if(QtdItem.trim().length>=1){
                if(VolumeItem.trim().length>=1){
                    if(PesoItem.trim().length>=1){
                        if(ValUntItem.trim().length>=1){
                            
                            aitem = new Array();
                            aitem = {  idproduto: CodProduto,
                                       descprod: DescProdut,
                                       undmedida: UndMed,
                                       idcfop: ((CodCFOP.length==0)?'NULL':CodCFOP),
                                       volitem: VolumeItem.replace(',','.'),
                                       pesoitem: PesoItem.replace(',','.'),
                                       qtditem: QtdItem.replace(',','.'),
                                       valuntitem:ValUntItem.replace(',','.'),
                                       valbruto:ValBruto.replace(',','.'),
                                       valdesc: ValDesc.replace(',','.'),   
                                       valliquido:ValLiq.replace(',','.') 
                                    }
                            
                            $.ajax({

                                type:"POST",
                                url:"../insert/setcarrinho.php",
                                data: {Item:aitem},
                                cache: false,
                                processData:true,
                               beforeSend: function(){
                                    
                                    var strpload="Buscando CFOP referente a pesquisa";
                                },
                                afterSend: function(){
                                }
                                }).done( function(data){
                                    arrayRetorno = $.parseJSON(data);
                                    
                                    arraycarrinho = new Array();
                                    arraycarrinho["carrinho"] = arrayRetorno["carrinho"];
                                    arraytotais = arrayRetorno["totais"];
                                    
                                    contitens = arrayRetorno["contadoritens"];
                                   
                                    $('#btnCarrinho').html('<span class="glyphicon glyphicon-shopping-cart"></span>'+contitens);
                                    LimpaCampos();
                                    validateItemPedido();
                                    arraycarrinho["totais"] = arraytotais;
                                    arraycarrinho["contitem"] = contitens;
                                    
                                    divmodal = MontaModalItens(arraycarrinho);
                                    //console.log(divmodal);
                                    $('#modalcarrinho').html(divmodal);
                                    $('#MsgAddCarrinho').removeClass('d-none');
                                    setTimeout(function(){
                                        $('#MsgAddCarrinho').addClass('d-none');
                                        document.getElementById('edtProduto').focus();
                                    },1000);
                            
                                }).fail( function(){
                                console.log("ALGO DEU ERRADO");
                                }).always( function(){
                                    return null;

                                });
                        }
                        else{
                            //console.log("valorunt");
                            $('#MsgValUntItemVazio').removeClass('d-none');
                            $('#MsgValUntItemVazio').delay(1000).fadeIn(2000);
                            setTimeout(function(){
                                $('#MsgValUntItemVazio').addClass('d-none');
                                $('#MsgValUntItemVazio').delay(1000).fadeOut(2000);
                            }, 2000);
                        }
                    }
                    else{
                        $('#MsgPesoItemVazio').removeClass('d-none');
                        $('#MsgPesoItemVazio').delay(1000).fadeIn(2000);
                        setTimeout(function(){
                            $('#MsgPesoItemVazio').addClass('d-none');
                            $('#MsgPesoItemVazio').delay(1000).fadeOut(2000);
                        }, 2000);
                        
                    }
                }
                else{
                    $('#MsgVolumeItemVazio').removeClass('d-none');
                    $('#MsgVolumeItemVazio').delay(1000).fadeIn(2000);
                    setTimeout(function(){
                        $('#MsgVolumeItemVazio').addClass('d-none');
                        $('#MsgVolumeItemVazio').delay(1000).fadeOut(2000);
                    }, 2000);
                }
            }
            else{
                $('#MsgQTDItemVazio').removeClass('d-none');
                $('#MsgQTDItemVazio').delay(1000).fadeIn(2000);
                setTimeout(function(){
                    $('#MsgQTDItemVazio').addClass('d-none');
                    $('#MsgQTDItemVazio').delay(1000).fadeOut(2000);
                }, 2000);
            }
        }
        else{
            $('#MsgCFOPVazio').removeClass('d-none');
            $('#MsgCFOPVazio').delay(1000).fadeIn(2000);
            setTimeout(function(){
                $('#MsgCFOPVazio').addClass('d-none');
                $('#MsgCFOPVazio').delay(1000).fadeOut(2000);
            }, 2000);
            
        }
        
    }
    
    else
    {
        $('#MsgProdVazio').removeClass('d-none');
        $('#MsgProdVazio').delay(1000).fadeIn(2000);
        setTimeout(function(){
            $('#MsgProdVazio').addClass('d-none');
            $('#MsgProdVazio').delay(1000).fadeOut(2000);
        }, 2000);
    }
    
}
function ExcluirItemCarrinho(index){
    
    $.get( "../delete/delitemcarrinho.php", { indice: index })
    .done(function( data ) {
        
        arrayRetorno = $.parseJSON(data);
        console.log(arrayRetorno);
        arraycarrinho = new Array();
        
        arraycarrinho = arrayRetorno["carrinho"];
        arraytotais = arrayRetorno["totais"];
                                        
        contitens = arrayRetorno["contadoritens"];
        $('#valTotalItens').val(contitens);

        
        $('#btnCarrinho').html('<span class="glyphicon glyphicon-shopping-cart"></span>'+contitens);
         
        $('#HtotLiqItem').html(arraytotais["valortotalliquido"]); 
        $('#HtotDescItem').html(arraytotais["valortotaldesconto"]) 
        $('#HtotBrutoItem').html(arraytotais["valortotalbruto"]);
        document.getElementById('trItem_'+index).remove();
        
        if (contitens==0){
            $('#divalertcarrinho').removeClass('d-none');
            $('#tabitenscar').addClass('d-none');
            //$('#divtotaiscarrinho').addClass('d-none');
            //$('#thtitulos').addClass('d-none');
            
             
        }
        //LimpaCampos();
        //validateItemPedido();
        //arraycarrinho["totais"] = arraytotais;
        //arraycarrinho["contitem"] = contitens;
        //console.log(arraycarrinho);
        //divmodal = MontaModalItens(arraycarrinho);
        //console.log(divmodal);
        //$('#modalcarrinho').html(divmodal);
    })
    .fail(function(){ console.log("Deu erro") });
    
    
}

function validateCamposDadosGerais(){

    if ($('#edtUnidade').val().trim().length==0){
        $('#CodUnidade').val("");
    }
    if ($('#edtTransFiscal').val().trim().length ==0){
        $('#CodTransFiscal').val("");
    }
    if ($('#edtVendedor').val().trim().length ==0){
        $('#CodVendedor').val("");
    }
    if ($('#edtCFOPPed').val().trim().length ==0){
        $('#CodCFOPPed').val("");
    }
    if ($('#edtEntidade').val().trim().length ==0){
        $('#CodEntidade').val("");
        $('#CodPessoa').val("");
        
    }
    
    //if ($('#edtCFOPPed').val().trim().length ==0){
    //    $('#CodCFOPPed').val("");
    //}
    console.log("Unidade:"+$('#CodUnidade').val().length+"  Trans:"+$('#CodTransFiscal').val().length+" Vendedor:"+$('#CodVendedor').val().length+" CFOP:"+$('#CodCFOPPed').val().length+" Entidade:"+$('#CodEntidade').val().length);
    if ($('#CodUnidade').val().length > 0 &&
        $('#CodTransFiscal').val().length > 0 &&
        $('#CodVendedor').val().length > 0 &&
        $('#CodCFOPPed').val().length > 0 &&
        $('#CodEntidade').val().length > 0) {

        $("#btnDadosGerais_Proximo").prop("disabled", false);
    }
    else {
        
        $("#btnDadosGerais_Proximo").prop("disabled", true);
    }
}
function validateCamposCobranca(){

    if ($('#edtLocalEntrega').val().trim().length==0){
        $('#CodLocalEntrega').val("");
    }
    if ($('#edtPlanoPagto').val().trim().length ==0){
        $('#CodPlanoPagto').val("");
    }
    if ($('#edtTransportador').val().trim().length ==0){
        $('#CodTransportador').val("");
    }
    if ($('#edtPortador').val().trim().length ==0){
        $('#CodPortador').val("");
    }
    if ($('#edtCarteira').val().trim().length ==0){
        $('#CodCarteira').val("");
    }
    
    if ($('#CodLocalEntrega').val().length > 0 &&
        $('#CodPlanoPagto').val().length > 0 &&
        $('#CodPortador').val().length > 0 &&
        $('#CodCarteira').val().length > 0 &&
        $('#CodTransportador').val().length > 0) {
        
        $("#btnCobranca_Proximo").prop("disabled", false);
    }
    else {
        
        $("#btnCobranca_Proximo").prop("disabled", true);
    }
}
function validateItemPedido(){
    
    CodProduto = $('#CodProduto').val();
    CodCFOP    = $('#CodCFOPItem').val();
    QtdItem    = $('#edtQtdItem').val();
    VolumeItem = $('#edtVolumeItem').val();
    PesoItem   = $('#edtPesoItem').val();
    ValUntItem = $('#edtValUntItem').val();
    
    if ($('#CodProduto').val().length > 0 &&
        $('#CodCFOPItem').val().length > 0 &&
        $('#edtQtdItem').val().length > 0 &&
        $('#edtVolumeItem').val().length > 0 &&
        $('#edtPesoItem').val().length > 0 &&
        $('#edtValUntItem').val().length > 0) {
        
        $("#btnAddCarrinho").prop("disabled", false);
        CalcularItem();
    }
    else {
        $("#btnAddCarrinho").prop("disabled", true);
        
    }
}
function CalcularItem(){
    
    CodProduto = $('#CodProduto').val();
    CodCFOP    = $('#CodCFOPItem').val();
    QtdItem    = $('#edtQtdItem').val().replace(',','.');
    VolumeItem = $('#edtVolumeItem').val().replace(',','.');
    PesoItem   = $('#edtPesoItem').val().replace(',','.');
    ValUntItem = $('#edtValUntItem').val().replace(',','.');
    strUnMed   = $('#UndMedida').val();
    ValDesc    = (($('#edtValDescItem').val().length==0)?0:$('#edtValDescItem').val().replace(',','.'));
    
    ValorLiquido = 0;
    ValorBruto   = 0;
    
    if (strUnMed != 'KG')
    {
        ValorBruto =  QtdItem * ValUntItem;
    }
    else{
        ValorBruto = PesoItem * ValUntItem;
    }
    
    
    
    console.log("Desconto:"+ValDesc);
    console.log("Bruto:"+ValorBruto);
    
    if (ValDesc > 0)
    {
        ValorLiquido = ValorBruto - ValDesc;
    }
    else{ValorLiquido = ValorBruto; }
    
    console.log("Liquido:"+ValorLiquido);
    
    
    $('#edtValLiqItem').val(ValorLiquido.toFixed(2));
    
    if ((ValDesc.length==0) || (ValDesc=="")){
        $('#edtValDescItem').val("0.00");    
    }
    else{
        $('#edtValDescItem').val(ValDesc);
    }
    $('#edtValbrutoitem').val(ValorBruto.toFixed(2));
    
    
    
    
}


function SelectUni(idunidade){
    $('#edtUnidade').val($('#selidUni_'+idunidade).text()); 
    $('#resultUni').removeClass("d-block");
    $('#resultUni').addClass("d-none");
    $('#CodUnidade').val(idunidade);
    $('#MsgUnidadeVazio').addClass('d-none');
    $('#MsgUnidadeVazio').removeClass('d-block');
    validateCamposDadosGerais();
    //document.getElementById('edtTransFiscal').focus();
}
function SelectTransFiscal(idtransfiscal,index){

    arrayMicroConta =  arrayMicroConta[index]["MicroConta"];
    
    $('#edtTransFiscal').val($('#selidTransFiscal_'+idtransfiscal).text()); 
    $('#resultMicroconta').removeClass("d-block");
    $('#resultMicroconta').addClass("d-none");
    $('#CodTransFiscal').val(idtransfiscal);
    
    $('#MsgMicroContaVazio').addClass('d-none');
    $('#MsgMicroContaVazio').removeClass('d-block');
    
    validateCamposDadosGerais();
    
    aDados = {
        idunidade : varCodUnidade,
        identidade: $('#CodEntidade').val(),
        idmicroconta: $('#CodTransFiscal').val(),
        tipomov: varTipoMovimento,
        entidade : $('#CbEntidade').children("option:selected").val() ,
        produto : "",
        istransf :  ((arrayMicroConta["tipooperacao"]==3)? true : false),
        istransfent: ((varTipoMovimento=="E")? true : false),
        isentrada: ((varTipoMovimento=="E")? true : false),
        idpropriedade:$('#CodPropriedade').val(),
        tipoproduto:arrayMicroConta["tipoproduto"]
    }
    BuscaCFOP(aDados,'#edtCFOPPed','#CodCFOPPed');
    
    //document.getElementById('edtVendedor').focus();
}
function SelectVendedor(idvendedor){
    
    $('#edtVendedor').val($('#selidvend_'+idvendedor).text()); 
    $('#resultVendedor').removeClass("d-block");
    $('#resultVendedor').addClass("d-none");
    $('#CodVendedor').val(idvendedor);
    validateCamposDadosGerais();
    //document.getElementById('edtVendedor').focus();
}
function SelectProduto(idproduto,Unidademedida,DescricaoProduto){
    
    $('#edtProduto').val($('#selidprod_'+idproduto).text()); 
    $('#resultProduto').removeClass("d-block");
    $('#resultProduto').addClass("d-none");
    $('#CodProduto').val(idproduto);
    $('#UndMedida').val(Unidademedida);
    $('#lblundmedida').html(Unidademedida);
    $('#DescricaoProd').val(DescricaoProduto);
    aDados["produto"] = idproduto;
    BuscaCFOP(aDados,'#edtCFOPItem','#CodCFOPItem');
    PesquisarPreco(idproduto);
    //document.getElementById('edtVendedor').focus();
}
function SelectCFOPItem(idCFOP){
    
    $('#edtCFOPItem').val($('#selidCFOPItem_'+idCFOP).text()); 
    $('#resultCFOP').removeClass("d-block");
    $('#resultCFOP').addClass("d-none");
    $('#CodCFOPItem').val(idCFOP);
    //document.getElementById('edtVendedor').focus();
}
function SelectCFOPPed(idCFOP){
    
    $('#edtCFOPPed').val($('#selidCFOPPed_'+idCFOP).text()); 
    $('#resultCFOPPed').removeClass("d-block");
    $('#resultCFOPPed').addClass("d-none");
    $('#CodCFOPPed').val(idCFOP);
    validateCamposDadosGerais();
    //document.getElementById('edtVendedor').focus();
}
function SelectVeiculo(idveiculo,placaveiculo,ufveiculo){
    $('#edtVeiculo').val($('#selidveic_'+idveiculo).text()); 
    $('#resultVeiculo').removeClass("d-block");
    $('#resultVeiculo').addClass("d-none");
    $('#CodVeiculo').val(idveiculo);
    $('#edtPlacaVeic').val(placaveiculo);
    $('#edtUFVeic').val(ufveiculo);
    //$('#MsgMicroContaVazio').addClass('d-none');
    //$('#MsgMicroContaVazio').removeClass('d-block');
}
function SelectTransportador(idtransportador){
    $('#edtTransportador').val($('#selidtransp_'+idtransportador).text()); 
    $('#resultTransportador').removeClass("d-block");
    $('#resultTransportador').addClass("d-none");
    $('#CodTransportador').val(idtransportador);
    //$('#MsgMicroContaVazio').addClass('d-none');
    //$('#MsgMicroContaVazio').removeClass('d-block');
    validateCamposCobranca();
}
function SelectEntidade(identidade,idpessoa,idpropriedade,nomepropriedade,nomeentidade){
    
    if (idpropriedade=="0" || idpropriedade==0){
        console.log("não é produtor");
        $('#edtEntidade').val($('#selidentidade_'+identidade).text()); 
        $('#DivDescPropriedade').addClass("d-none");
        $('#DivDescPropriedade p').removeClass("d-block");
        
    } else{

        $('#edtEntidade').val(identidade+' - '+nomeentidade);
        $('#CodPropriedade').val(idpropriedade);
        $('#DivDescPropriedade p').html("Propriedade:"+idpropriedade+" - "+nomepropriedade);
        $('#DivDescPropriedade').removeClass("d-none");
        $('#DivDescPropriedade p').addClass("d-block");
    }
    
    
    $('#CodPessoa').val(idpessoa);
    
    
 
    
    $('#CodEntidade').val(identidade);
    
    $('#MsgEntidadeVazio').addClass('d-none');
    $('#MsgEntidadeVazio').removeClass('d-block');
    $('#resultEntidade').removeClass("d-block");
    $('#resultEntidade').addClass("d-none");
    
    validateCamposDadosGerais();
    
    if (arrayMicroConta != null){
        aDados = {
            idunidade : varCodUnidade,
            identidade: $('#CodEntidade').val(),
            idmicroconta: $('#CodTransFiscal').val(),
            tipomov: varTipoMovimento,
            entidade : $('#CbEntidade').children("option:selected").val() ,
            produto : "",
            istransf :  ((arrayMicroConta["tipooperacao"]==3)? true : false),
            istransfent: ((varTipoMovimento=="E")? true : false),
            isentrada: ((varTipoMovimento=="E")? true : false),
            idpropriedade:$('#CodPropriedade').val(),
            tipoproduto:arrayMicroConta["tipoproduto"]
        }
    
        BuscaCFOP(aDados,'#edtCFOPPed','#CodCFOPPed');
    }
    

    
    
}
function SelectEndereco(idendereco){
    $('#edtLocalEntrega').val($('#selidende_'+idendereco).text()); 
    $('#resultLocalEntrega').removeClass("d-block");
    $('#resultLocalEntrega').addClass("d-none");
    $('#CodLocalEntrega').val(idendereco);
    validateCamposCobranca();
    
}
function SelectPortador(idportador){
    
    $('#edtPortador').val($('#selidportador_'+idportador).text()); 
    $('#resultPortador').removeClass("d-block");
    $('#resultPortador').addClass("d-none");
    $('#CodPortador').val(idportador);
    validateCamposCobranca();
}
function SelectPlanoPagto(idplanopagto){

    $('#edtPlanoPagto').val($('#selidplanopagto_'+idplanopagto).text()); 
    $('#resultPlanoPagto').removeClass("d-block");
    $('#resultPlanoPagto').addClass("d-none");
    $('#CodPlanoPagto').val(idplanopagto);
    validateCamposCobranca();
    
}
function SelectCarteira(idcarteira,nomecarteira,carteira,nomebanco,nomeagencia,numeroagencia){

    $('#edtCarteira').val(carteira+' - '+nomecarteira ); 
    $('#resultCarteira').removeClass("d-block");
    $('#resultCarteira').addClass("d-none");
    $('#CodCarteira').val(idcarteira);
    $('#divlblBancoAgencia').removeClass('d-none');
    $('#lblBancoAgencia').html('Banco: '+nomebanco+'. NºAgência: '+ numeroagencia);
    validateCamposCobranca();
    
    
}


function PesqMicroConta(TpMov){
    edttransfiscal = $('#edtTransFiscal').val();
    if (edttransfiscal.trim().length > 0)
    {
        $('#divMsgAlerta').removeClass('d-block');
        $('#divMsgAlerta').addClass('d-none');
    
        dadosrec = new Array();
        dadosrec = RetornaDadosMicroConta(TpMov,edttransfiscal,"#btnPesqTransFiscal");
        li_mc = "";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayMicroConta = dadosrec[1];
            cont = 0;  
            desctransfiscal2 ="";

            $.each(arrayMicroConta, function(chave,valor){

                idtransfiscal   = arrayMicroConta[chave]["MicroConta"]["idtransfiscal"];
                desctransfiscal = arrayMicroConta[chave]["MicroConta"]["desctransfiscal"];
                //und_opt += '<option value="'+descuni+'">';
                li_mc +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidTransFiscal_'+idtransfiscal+'" onclick="SelectTransFiscal('+idtransfiscal+','+chave+');">'+idtransfiscal+' - '+desctransfiscal+'</a>'; 
                cont = cont+1;

            });

        }
        else
        {

            cont = 0;
            li_mc=""; 
        }

        if (cont > 0){
            if (cont >1){
                 
                $('#resultMicroconta').removeClass("d-none"); 
                $('#resultMicroconta').addClass("d-block");
                $('#resultMicroconta').html(li_mc);
                $('#divMsgAlerta').addClass('d-none');
                $('#divMsgAlerta').removeClass('d-block');
            }
            else{
                $('#edtTransFiscal').val(idtransfiscal+' - '+desctransfiscal); 
                //document.getElementById('edtVendedor').focus();
                $('#CodTransFiscal').val(idtransfiscal);
                
                $('#MsgMicroContaVazio').addClass('d-none');
                $('#MsgMicroContaVazio').removeClass('d-block');
                $('#divMsgAlerta').addClass('d-none');
                $('#divMsgAlerta').removeClass('d-block');
                
                arrayMicroConta =  arrayMicroConta[0]["MicroConta"];
                
                if (arrayMicroConta != null){                        
                    aDados = {
                        idunidade : varCodUnidade,
                        identidade: $('#CodEntidade').val(),
                        idmicroconta: $('#CodTransFiscal').val(),
                        tipomov: varTipoMovimento,
                        entidade : $('#CbEntidade').children("option:selected").val() ,
                        produto : "",
                        istransf :  ((arrayMicroConta["tipooperacao"]==3)? true : false),
                        istransfent: ((varTipoMovimento=="E")? true : false),
                        isentrada: ((varTipoMovimento=="E")? true : false),
                        idpropriedade:$('#CodPropriedade').val(),
                        tipoproduto:arrayMicroConta["tipoproduto"]
                    }

                    BuscaCFOP(aDados,'#edtCFOPPed','#CodCFOPPed');
                }                
    

            }
        }
        else{
            $('#edtTransFiscal').val("");
            $('#CodTransFiscal').val("");

            $('#resultMicroconta').removeClass("d-block");
            $('#resultMicroconta').addClass("d-none");
            $('#MsgMicroContaVazio').removeClass('d-none');
            $('#MsgMicroContaVazio').addClass('d-block');
            $('#divMsgAlerta').removeClass('d-none');
            $('#divMsgAlerta').addClass('d-block');
    
        }
    }
    else{
        $('#divMsgAlerta').removeClass('d-none');
        $('#divMsgAlerta').addClass('d-block');
        $('#divMsgAlerta').html("Campo Micro Conta obrigatório vazio.");
        $('#MsgMicroContaVazio').removeClass('d-none');
        $('#MsgMicroContaVazio').addClass('d-block');
    }
    validateCamposDadosGerais();
    
}
function PesqDeposito(CodUnidade){
    edtuni = $('#edtUnidade').val();
    if (edtuni.trim().length>0)
    {
        $('#divMsgAlerta').addClass('d-none');
        $('#divMsgAlerta').removeClass('d-block');
        
        
        
        dadosrec = new Array();
        dadosrec = RetornaDadosDeposito(CodUnidade,edtuni,"#btnPesqUnidade");
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayDeposito = dadosrec[1];
            cont = 0;        
            $.each(arrayDeposito, function(chave,valor){
                idunidade = arrayDeposito[chave]["Unidade"]["idunidade"];
                descuni = arrayDeposito[chave]["Unidade"]["descdeposito"];
                //und_opt += '<option value="'+descuni+'">';
                li_uni +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidUni_'+idunidade+'" onclick="SelectUni('+idunidade+');">'+idunidade+' - '+descuni+'</a>'; 
                cont = cont+1;
            });
        }
        else
        {
            cont = 0;
            li_uni=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultUni').removeClass("d-none"); 
                $('#resultUni').addClass("d-block");
                $('#resultUni').html(li_uni);
                $('#divMsgAlerta').addClass('d-none');
                $('#divMsgAlerta').removeClass('d-block');
            }
            else{
                $('#edtUnidade').val(idunidade+' - '+descuni); 
                $('#CodUnidade').val(idunidade);
                //document.getElementById('edtTransFiscal').focus();
                $('#MsgUnidadeVazio').addClass('d-none');
                $('#MsgUnidadeVazio').removeClass('d-block');
                $('#divMsgAlerta').addClass('d-none');
                $('#divMsgAlerta').removeClass('d-block');
            }
        }
        else{
            $('#edtUnidade').val("");
            $('#CodUnidade').val("");
            $('#resultUni').removeClass("d-block");
            $('#resultUni').addClass("d-none");
            $('#MsgUnidadeVazio').addClass('d-block');
            $('#MsgUnidadeVazio').removeClass('d-none');
            $('#divMsgAlerta').removeClass('d-none');
            $('#divMsgAlerta').addClass('d-block');
        }
    }
    else{
        $('#divMsgAlerta').removeClass('d-none');
        $('#divMsgAlerta').addClass('d-block');
        $('#divMsgAlerta').html("Campo Depósito obrigatório vazio.");
        $('#MsgUnidadeVazio').addClass('d-block');
        $('#MsgUnidadeVazio').removeClass('d-none');
        $('#divMsgAlerta').removeClass('d-none');
        $('#divMsgAlerta').addClass('d-block');
    }
    validateCamposDadosGerais();
}
function PesqVendedor(){
    edtVend = $('#edtVendedor').val();
    if (edtVend.trim().length > 0 )
    { 
        dadosrec = new Array();
        dadosrec = RetornaDadosVendedor(edtVend,"#btnPesqVendedor");
        li_vend="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayVendedor = dadosrec[1];
            cont = 0;        
            $.each(arrayVendedor, function(chave,valor){
                idvendedor = arrayVendedor[chave]["Vendedor"]["idvendedor"];
                nomevendedor = arrayVendedor[chave]["Vendedor"]["nomevendedor"];
                //und_opt += '<option value="'+descuni+'">';
                li_vend +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidvend_'+idvendedor+'" onclick="SelectVendedor('+idvendedor+');">'+idvendedor+' - '+nomevendedor+'</a>'; 
                cont = cont+1;
            });
        }
        else
        {
            cont = 0;
            li_vend=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultVendedor').removeClass("d-none"); 
                $('#resultVendedor').addClass("d-block");
                $('#resultVendedor').html(li_vend);
            }
            else{
                $('#edtVendedor').val(idvendedor+' - '+nomevendedor); 
                $('#CodVendedor').val(idvendedor);
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtVendedor').val("");
            $('#CodVendedor').val("");
            $('#resultVendedor').removeClass("d-block");
            $('#resultVendedor').addClass("d-none");

        }
    }
    validateCamposDadosGerais();
}
function PesqProduto(){
    edtProduto = $('#edtProduto').val();
    if (edtProduto.trim().length > 0 )
    {
        dadosrec = new Array();
        dadosrec = RetornaDadosProduto(edtProduto,"#btnPesqProduto");
        //console.log(dadosrec[1]);
        li_prod="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayProduto = dadosrec[1];
            cont = 0;        
            $.each(arrayProduto, function(chave,valor){
                idproduto = arrayProduto[chave]["Produto"]["idproduto"];
                descproduto = arrayProduto[chave]["Produto"]["descproduto"];
                unidademed  = arrayProduto[chave]["Produto"]["unidademedida"];
                //und_opt += '<option value="'+descuni+'">';
                li_prod +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidprod_'+idproduto+'" onclick="SelectProduto('+idproduto+','+"'"+unidademed+"'"+','+"'"+descproduto+"'"+');">'+idproduto+' - '+descproduto+'</a>'; 
 
                cont = cont+1;
            });
        }
        else
        {
            cont = 0;
            li_prod=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultProduto').removeClass("d-none"); 
                $('#resultProduto').addClass("d-block");
                $('#resultProduto').html(li_prod);
            }
            else{
                $('#edtProduto').val(idproduto+' - '+descproduto); 
                $('#DescricaoProd').val(descproduto);
                $('#CodProduto').val(idproduto);
                $('#UndMedida').val(unidademed);
                $('#lblundmedida').html(unidademed);
                aDados["produto"] = idproduto;
                console.log(aDados);
                BuscaCFOP(aDados,'#edtCFOPItem','#CodCFOPItem');
                PesquisarPreco(idproduto);
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtProduto').val("");
            $('#CodProduto').val("");
            $('#UndMedida').val("");
            $('#DescricaoProd').val("");
            $('#resultProduto').removeClass("d-block");
            $('#resultProduto').addClass("d-none");

        }
    }
    
}
function PesqCFOP(tipo){
    switch (tipo)
    {
        case "I":
            edtCFOP = $('#edtCFOPItem').val();
            btn = "#btnPesqCFOPItem";
            break;
        case "P":
            btn = "#btnPesqCFOPPed";
            edtCFOP = $('#edtCFOPPed').val();
            break;
    }
    
    if (edtCFOP.trim().length > 0 )
    { 
        dadosrec = new Array();
        
        dadosrec = RetornaDadosCFOP(edtCFOP,btn);
  
        li_CFOP="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayCFOP = dadosrec[1];
            cont = 0;        
            $.each(arrayCFOP, function(chave,valor){
                idCFOP = arrayCFOP[chave]["CFOP"]["idCFOP"];
                CFOP = arrayCFOP[chave]["CFOP"]["CFOP"];
                descCFOP = arrayCFOP[chave]["CFOP"]["descCFOP"];
                //und_opt += '<option value="'+descuni+'">';
                switch (tipo){
                    case "I":
                        li_CFOP +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidCFOPItem_'+idCFOP+'" onclick="SelectCFOPItem('+idCFOP+');">'+CFOP+' - '+descCFOP+'</a>'; 
                        break;
                    case "P":
                        li_CFOP +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidCFOPPed_'+idCFOP+'" onclick="SelectCFOPPed('+idCFOP+');">'+CFOP+' - '+descCFOP+'</a>'; 
                        break;
                        
                }
                
 
                cont = cont+1;
            });
        }
        else
        {
            cont = 0;
            li_CFOP=""; }

        if (cont > 0){
            if (cont >1){
                switch (tipo){
                    case "I":
                        $('#resultCFOP').removeClass("d-none"); 
                        $('#resultCFOP').addClass("d-block");
                        $('#resultCFOP').html(li_CFOP);        
                        break;
                    case "P":
                        $('#resultCFOPPed').removeClass("d-none"); 
                        $('#resultCFOPPed').addClass("d-block");
                        $('#resultCFOPPed').html(li_CFOP);        
                        break;
                }
                
            }
            else{
                switch (tipo){
                    case "I":
                        $('#edtCFOPItem').val(CFOP+' - '+descCFOP); 
                        $('#CodCFOPItem').val(idCFOP);
                        break;
                    case "P":
                        $('#edtCFOPPed').val(CFOP+' - '+descCFOP); 
                        $('#CodCFOPPed').val(idCFOP);
                        break;
                }
                        
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            switch (tipo){
                    case "I":
                        $('#edtCFOPitem').val("");
                        $('#CodCFOPItem').val("");
                        $('#resultCFOP').removeClass("d-block");
                        $('#resultCFOP').addClass("d-none");
                        break;
                    case "P":
                        $('#edtCFOPPed').val("");
                        $('#CodCFOPPed').val("");
                        $('#resultCFOPPed').removeClass("d-block");
                        $('#resultCFOPPed').addClass("d-none");
                        break;
            }
                    

        }
    }
    
    switch (tipo){
        case "I":
            break;
        case "P":
            validateCamposDadosGerais();
            break;
    }
    
}
function PesqEntidade(){
    cbIndexEntidade = $('#CbEntidade').children("option:selected").val();
    edtEntidade     = $('#edtEntidade').val();
    if (edtEntidade.trim().length > 0 )
    { 
        dadosrec = new Array();
        dadosrec = RetornaDadosEntidade(edtEntidade,cbIndexEntidade);
        li_entidade="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayentidade = dadosrec[1];
            cont = 0;        
            $.each(arrayentidade, function(chave,valor){
                
                identidade = arrayentidade[chave]["Entidade"]["identidade"];
                nomeentidade = arrayentidade[chave]["Entidade"]["nomepessoa"];
                idpessoa     = arrayentidade[chave]["Entidade"]["idpessoa"];
                
                if (cbIndexEntidade==2){
                    
                    idpropriedade = arrayentidade[chave]["Entidade"]["idpropriedade"];
                    nomepropriedade = arrayentidade[chave]["Entidade"]["nomepropriedade"];
                    nomelinha = arrayentidade[chave]["Entidade"]["nomelinha"];
                    idlinha = arrayentidade[chave]["Entidade"]["idlinha"];
                    linha = idlinha +' - '+nomelinha;
                    
                    varnomeprop = "'"+nomepropriedade+"'";
                    varnomeentidade =  "'"+nomeentidade+"'";
                    li_entidade +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary"   id="selidentidade_'+idpropriedade+'" onclick="SelectEntidade('+identidade+','+idpessoa+','+idpropriedade+','+varnomeprop+','+varnomeentidade+');">'+idpropriedade+' - '+nomepropriedade+', Produtor: '+identidade+' - '+nomeentidade+', Linha: '+linha+'</a>'; 
                    
                    
                
                }
                else{
                    
                    //und_opt += '<option value="'+descuni+'">';
                    li_entidade +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary"   id="selidentidade_'+identidade+'" onclick="SelectEntidade('+identidade+','+idpessoa+',0,0,0);">'+identidade+' - '+nomeentidade+'</a>'; 
                
                }
                
                cont = cont+1;
            });
        }
        else
        {
            cont = 0;
            li_entidade=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultEntidade').removeClass("d-none"); 
                $('#resultEntidade').addClass("d-block");
                $('#resultEntidade').html(li_entidade);
                $('#divMsgAlerta').addClass('d-none');
                $('#divMsgAlerta').removeClass('d-block');
        
            }
            else{
                $('#MsgEntidadeVazio').addClass('d-none');
                $('#MsgEntidadeVazio').removeClass('d-block');
                $('#edtEntidade').val(identidade+' - '+nomeentidade); 
                $('#CodEntidade').val(identidade);
                $('#CodPessoa').val(idpessoa);
                if (cbIndexEntidade==2){
                    $('#CodPropriedade').val(idpropriedade);
                    $('#DivDescPropriedade p').html("Propriedade:"+idpropriedade+" - "+nomepropriedade);
                    $('#DivDescPropriedade').removeClass('d-none');
                    $('#DivDescPropriedade').addClass('d-block');
                    
                    
                }
                
                if (arrayMicroConta != null){
                    aDados = {
                        idunidade : varCodUnidade,
                        identidade: $('#CodEntidade').val(),
                        idmicroconta: $('#CodTransFiscal').val(),
                        tipomov: varTipoMovimento,
                        entidade : $('#CbEntidade').children("option:selected").val() ,
                        produto : "",
                        istransf :  ((arrayMicroConta["tipooperacao"]==3)? true : false),
                        istransfent: ((varTipoMovimento=="E")? true : false),
                        isentrada: ((varTipoMovimento=="E")? true : false),
                        idpropriedade:$('#CodPropriedade').val(),
                        tipoproduto:arrayMicroConta["tipoproduto"]
                    }

                    BuscaCFOP(aDados,'#edtCFOPPed','#CodCFOPPed');
                }

                $('#divMsgAlerta').addClass('d-none');
                $('#divMsgAlerta').removeClass('d-block');
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtEntidade').val("");
            $('#CodEntidade').val("");
            $('#CodPessoa').val("");
            $('#resultEntidade').removeClass("d-block");
            $('#resultEntidade').addClass("d-none");
            $('#MsgEntidadeVazio').addClass('d-block');
            $('#MsgEntidadeVazio').removeClass('d-none');
            $('#divMsgAlerta').removeClass('d-none');
            $('#divMsgAlerta').addClass('d-block');
            $('#DivDescPropriedade').addClass('d-none');
            $('#DivDescPropriedade').removeClass('d-block');
                    

        }
    }
    else{
        $('#divMsgAlerta').removeClass('d-none');
        $('#divMsgAlerta').addClass('d-block');
        $('#divMsgAlerta').html("Campo Pessoa obrigatório.");
        $('#MsgEntidadeVazio').addClass('d-block');
        $('#MsgEntidadeVazio').removeClass('d-none');
        $('#DivDescPropriedade').addClass('d-none');
        $('#DivDescPropriedade').removeClass('d-block');
    }
    validateCamposDadosGerais();

}
function PesqTransportador(){
    edtTransportador = $('#edtTransportador').val();
    if (edtTransportador.trim().length > 0 )
    { 
        dadosrec = new Array();
        dadosrec = RetornaDadosTransportador(edtTransportador,"#btnPesqTransportador");
        li_transp="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayTransportador = dadosrec[1];
            cont = 0;        
            $.each(arrayTransportador, function(chave,valor){
                idtransportador   = arrayTransportador[chave]["transportador"]["idtransportador"];
                nometransportador = arrayTransportador[chave]["transportador"]["nometransportador"];
                
                //und_opt += '<option value="'+descuni+'">';
                li_transp +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidtransp_'+idtransportador+'" ';
                
                temsel = "SelectTransportador("+idtransportador+");";
                
                li_transp +='onclick="'+temsel+'">'+idtransportador+' - '+nometransportador+'</a>'; 
                cont = cont+1;
                
            });
        }
        else
        {
            cont = 0;
            li_transp=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultTransportador').removeClass("d-none"); 
                $('#resultTransportador').addClass("d-block");
                $('#resultTransportador').html(li_transp);
            }
            else{
                $('#edtTransportador').val(idtransportador+' - '+nometransportador); 
                $('#CodTransportador').val(idtransportador);

                
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtTransportador').val("");
            $('#CodTransportador').val("");
            $('#resultTransportador').removeClass("d-block");
            $('#resultTransportador').addClass("d-none");

        }
    }
    validateCamposCobranca();
}
function PesqVeiculo(){
    edtVeiculo = $('#edtVeiculo').val();
    if (edtVeiculo.trim().length > 0 )
    { 
        dadosrec = new Array();
        dadosrec = RetornaDadosVeiculo(edtVeiculo,"#btnPesqVeiculo");
        li_veic="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayVeiculo = dadosrec[1];
            cont = 0;        
            $.each(arrayVeiculo, function(chave,valor){
                idveiculo = arrayVeiculo[chave]["veiculo"]["idveiculo"];
                nomeveiculo = arrayVeiculo[chave]["veiculo"]["nomeveiculo"];
                placaveiculo = arrayVeiculo[chave]["veiculo"]["placaveiculo"];
                ufveiculo = arrayVeiculo[chave]["veiculo"]["ufplaca"];
                //und_opt += '<option value="'+descuni+'">';
                li_veic +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidveic_'+idveiculo+'" ';
                
                temsel = "SelectVeiculo("+idveiculo+","+"'"+placaveiculo+"'"+','+"'"+ufveiculo+"'"+");";
              
                li_veic +='onclick="'+temsel+'">'+idveiculo+' - '+nomeveiculo+'</a>'; 
                cont = cont+1;
                
            });
        }
        else
        {
            cont = 0;
            li_veic=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultVeiculo').removeClass("d-none"); 
                $('#resultVeiculo').addClass("d-block");
                $('#resultVeiculo').html(li_veic);
            }
            else{
                $('#edtVeiculo').val(idveiculo+' - '+nomeveiculo); 
                $('#CodVeiculo').val(idveiculo);
                $('#edtPlacaVeic').val(placaveiculo);
                $('#edtUFVeic').val(ufveiculo);
                
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtVeiculo').val("");
            $('#CodVeiculo').val("");
            $('#edtPlacaVeic').val("");
            $('#edtUFVeic').val("");
            $('#resultVeiculo').removeClass("d-block");
            $('#resultVeiculo').addClass("d-none");

        }
    }
    validateCamposCobranca();
}
function PesqLocalEntrega(){
    edtEndereco = $('#edtLocalEntrega').val();
    idpessoa    = $('#CodPessoa').val();
    if (edtEndereco.trim().length >= 0 )
    { 
        dadosrec = new Array();
        dadosrec = RetornaDadosEndereco(edtEndereco,idpessoa,"#btnPesqLocalEntrega");
        li_endereco="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayEndereco = dadosrec[1];
            cont = 0;        
            $.each(arrayEndereco, function(chave,valor){
                idendereco   = arrayEndereco[chave]["endereco"]["idendereco"];
                nomeendereco = arrayEndereco[chave]["endereco"]["nomeendereco"];
                tipoendereco = arrayEndereco[chave]["endereco"]["tipoendereco"];
                //und_opt += '<option value="'+descuni+'">';
                li_endereco +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidende_'+idendereco+'" ';
                
                temsel = "SelectEndereco("+idendereco+");";
                
                li_endereco +='onclick="'+temsel+'">'+idendereco+' - '+tipoendereco+': '+nomeendereco+'</a>'; 
                cont = cont+1;
                
            });
        }
        else
        {
            cont = 0;
            li_endereco=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultLocalEntrega').removeClass("d-none"); 
                $('#resultLocalEntrega').addClass("d-block");
                $('#resultLocalEntrega').html(li_endereco);
            }
            else{
                $('#edtLocalEntrega').val(idendereco+' - '+nomeendereco); 
                $('#CodLocalEntrega').val(idendereco);
                $('#divlblTipoEndereco').removeClass('d-none');
                $('#lblTipoEndereco').html('Tipo: '+tipoendereco);
                
                
                
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtLocalEntrega').val("");
            $('#CodLocalEntrega').val("");
            $('#resultLocalEntrega').removeClass("d-block");
            $('#resultLocalEntrega').addClass("d-none");
            $('#divlblTipoEndereco').addClass('d-none');
            $('#lblTipoEndereco').html('');
                

        }
    }
    validateCamposCobranca();
    
}
function PesqPortador(){
    edtPortador = $('#edtPortador').val();
    if (edtPortador.trim().length >= 0 )
    { 
        dadosrec = new Array();
        dadosrec = RetornaDadosPortador(edtPortador,"#btnPesqPortador");
        li_portador="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayPortador = dadosrec[1];
            cont = 0;        
            $.each(arrayPortador, function(chave,valor){
                idportador = arrayPortador[chave]["portador"]["idportador"];
                nomeportador = arrayPortador[chave]["portador"]["nomeportador"];

                //und_opt += '<option value="'+descuni+'">';
                li_portador +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidportador_'+idportador+'" ';
                
                temsel = "SelectPortador("+idportador+");";
                
                li_portador +='onclick="'+temsel+'">'+idportador+' - '+nomeportador+'</a>'; 
                cont = cont+1;
                
            });
        }
        else
        {
            cont = 0;
            li_portador=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultPortador').removeClass("d-none"); 
                $('#resultPortador').addClass("d-block");
                $('#resultPortador').html(li_portador);
            }
            else{
                $('#edtPortador').val(idportador+' - '+nomeportador); 
                $('#CodPortador').val(idportador);
                
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtPortador').val("");
            $('#CodPortador').val("");
            $('#resultPortador').removeClass("d-block");
            $('#resultPortador').addClass("d-none");

        }
    }
    validateCamposCobranca();
}
function PesqPlanoPagto(){
    edtPlanoPagto = $('#edtPlanoPagto').val();
    if (edtPlanoPagto.trim().length >= 0 )
    { 
        dadosrec = new Array();
        dadosrec = RetornaDadosPlanoPagto(edtPlanoPagto,"#btnPesqPlanoPagto");
        li_planopagto="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayPlanoPagto = dadosrec[1];
            cont = 0;        
            $.each(arrayPlanoPagto, function(chave,valor){
                idplanopagto   = arrayPlanoPagto[chave]["planopagto"]["idplanopagto"];
                nomeplanopagto = arrayPlanoPagto[chave]["planopagto"]["nomeplanopagto"];

                //und_opt += '<option value="'+descuni+'">';
                li_planopagto +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidplanopagto_'+idplanopagto+'" ';
                
                temsel = "SelectPlanoPagto("+idplanopagto+");";
                
                li_planopagto +='onclick="'+temsel+'">'+idplanopagto+' - '+nomeplanopagto+'</a>'; 
                cont = cont+1;
                
            });
        }
        else
        {
            cont = 0;
            li_planopagto=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultPlanoPagto').removeClass("d-none"); 
                $('#resultPlanoPagto').addClass("d-block");
                $('#resultPlanoPagto').html(li_planopagto);
            }
            else{
                $('#edtPlanoPagto').val(idplanopagto+' - '+nomeplanopagto); 
                $('#CodPlanoPagto').val(idplanopagto);
                
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtPlanoPagto').val("");
            $('#CodPlanoPagto').val("");
            $('#resultPlanoPagto').removeClass("d-block");
            $('#resultPlanoPagto').addClass("d-none");

        }
    }
    validateCamposCobranca();
}
function PesqCarteira(){
    edtCarteira = $('#edtCarteira').val();
    if (edtCarteira.trim().length >= 0 )
    { 
        dadosrec = new Array();
        dadosrec = RetornaDadosCarteira(edtCarteira,"#btnPesqCarteira");
        li_carteira="";
        var achou = dadosrec[0]["pesquisa"];
        if (achou)
        {

            arrayCarteira = dadosrec[1];
            cont = 0;        
            $.each(arrayCarteira, function(chave,valor){
                idcarteira   = arrayCarteira[chave]["carteira"]["idcarteira"];
                carteira     = arrayCarteira[chave]["carteira"]["carteira"];
                nomecarteira = arrayCarteira[chave]["carteira"]["nomecarteira"];
                nomebanco    = arrayCarteira[chave]["carteira"]["nomebanco"];
                nomeagencia  = arrayCarteira[chave]["carteira"]["nomeagencia"];
                numeroagencia= arrayCarteira[chave]["carteira"]["numagencia"];
                desccarteira = arrayCarteira[chave]["carteira"]["desccarteira"];

                //und_opt += '<option value="'+descuni+'">';
                li_carteira +='<a href="#" class="list-group-item list-group-item-action list-group-item-primary" id="selidcarteira_'+idcarteira+'" ';
                
            temsel = "SelectCarteira("+idcarteira+",'"+nomecarteira+"','"+carteira+"','"+nomebanco+"','"+nomeagencia+"','"+numeroagencia+"');";
               
                li_carteira +='onclick="'+temsel+'"><p>'+carteira+' - '+nomecarteira+'</p>';
                li_carteira +='<p><small>Descricao:'+desccarteira+'</small></p> </a>'; 
                cont = cont+1;
                
            });
        }
        else
        {
            cont = 0;
            li_carteira=""; }

        if (cont > 0){
            if (cont >1){
                $('#resultCarteira').removeClass("d-none"); 
                $('#resultCarteira').addClass("d-block");
                $('#resultCarteira').html(li_carteira);
            }
            else{
                $('#edtCarteira').val(carteira+' - '+nomecarteira); 
                $('#CodCarteira').val(idcarteira);
                $('#divlblBancoAgencia').removeClass('d-none');
                $('#lblBancoAgencia').html('Banco: '+nomebanco+'. Agência: '+ nomeagencia);
                
                
               // document.getElementById('edtTransFiscal').focus();
            }
        }
        else{
            $('#edtCarteira').val("");
            $('#CodCarteira').val("");
            $('#divlblBancoAgencia').addClass('d-none');
            $('#lblBancoAgencia').html('');
                
            $('#resultCarteira').removeClass("d-block");
            $('#resultCarteira').addClass("d-none");

        }
    }
    validateCamposCobranca();
}

function LimparCarrinho(){
    $.ajax({
    url: "../../unsetcarrinho.php",
    method: "POST",
    data: { id : 1 }, ///{[nome_do_parametro_post]: [valor_do_parametro]}
    success: function(data) {
        // Transforma json em string pra renderizar no html
        console.log(data);
    }
});
}
function FormDadosItens(){
    strDiv = "";
    
    strDiv += '<div class="form-row">';
    strDiv +=   '<div class="form-group col-sm-6">';
    strDiv +=       '<label for="edtProduto">Produto</label>';
    strDiv  +=      '<div class="input-group">';   
    strDiv +=           '<input  required autocomplete="off" type="text" class="form-control form-control-sm" id="edtProduto" aria-describedby="ProdutoCarrinho" value="">'; 
    strDiv +=           '<div class="input-group-append">';
    strDiv +=               '<button type="button" id="btnPesqProduto" class="btn bg-padrao text-white" onclick="PesqProduto();"><span class="glyphicon glyphicon-search"></span></button>';
    strDiv +=               '<label id="lblundmedida" class ="ml-2" ></label>';
    strDiv +=           '</div>';
    strDiv +=       '</div>';
    strDiv +=       '<input type="hidden" id="CodProduto" value="">';
    strDiv +=       '<input type="hidden" id="UndMedida" value="">';
    strDiv +=       '<input type="hidden" id="DescricaoProd" value="">';
    
    strDiv +=       '<div id="MsgProdVazio" class="d-none"><p class="text-danger">Forneça o Produto!</div>';
    strDiv +=       '<div id="resultProduto" class="d-none list-group bg-padrao">';      
    strDiv +=       '</div>';
    strDiv +=   '</div>';
    //CFOP

    strDiv +=   '<div class="form-group col-sm-6">';
    strDiv +=       '<label for="edtCFOPItem">CFOP</label>';
    strDiv  +=      '<div class="input-group">';   
    strDiv +=           '<input  required autocomplete="off" type="text" class="form-control form-control-sm" id="edtCFOPItem" aria-describedby="CFOPCarrinho" value="">'; 
    strDiv +=           '<div class="input-group-append">';
    strDiv +=               '<button type="button" id="btnPesqCFOPItem" class="btn bg-padrao text-white" onclick="PesqCFOP('+"'"+'I'+"'"+');"><span class="glyphicon glyphicon-search"></span></button>'; 
    strDiv +=           '</div>';
    strDiv +=       '</div>';
    strDiv +=       '<input type="hidden" id="CodCFOPItem" value="">';
    strDiv +=       '<div id="MsgCFOPVazio" class="d-none"><p class="text-danger">Forneça a CFOP!</div>';
    strDiv +=       '<div id="resultCFOP" class="d-none list-group bg-padrao">';      
    strDiv +=       '</div>';
    strDiv +=   '</div>';
    strDiv += '</div>';
    

    strDiv +='<div class="form-group row">';
    //Volume
    strDiv +=  '<div class="form-group col-6 col-sm-6 ">';
    strDiv +=    '<label for="edtVolumeItem" class ="d-none d-lg-block d-xl-block">Volume</label>';
    strDiv +=    '<label for="edtVolumeItem" class ="d-block d-lg-none d-xl-none">Volume</label>';
    strDiv +=    '<input type="text" class="form-control form-control-sm" id="edtVolumeItem" aria-';     
    strDiv +=    'describedby="EDTVolumeItem" value="">';
    strDiv +=    '<div id="MsgVolumeItemVazio" class="d-none"><p class="text-danger">O Volume dever ser maior que zero</div>';
    strDiv  +=' </div>';
    //QUantidade
    strDiv +=  '<div class="form-group col-6 col-sm-6">';
    strDiv +=    '<label for="edtQtdItem" class ="d-none d-lg-block d-xl-block">Qtd</label>';
    strDiv +=    '<label for="edtQtdItem" class ="d-block d-lg-none d-xl-none">Quantidade</label>';
    strDiv +=    '<input type="number" class="form-control form-control-sm" id="edtQtdItem" aria-'; 
    
    strDiv +=    'describedby="EDTQtdItem" value="">';
    strDiv +=    '<div id="MsgQTDItemVazio" class="d-none"><p class="text-danger">A Quantidade dever ser maior que zero</div>';
    strDiv  +=' </div>';
    
    
    //Peso
    strDiv +=  '<div class="form-group col-6 col-sm-6">';
    strDiv +=    '<label for="edtPesoItem" class ="d-none d-lg-block d-xl-block">Peso</label>';
    strDiv +=    '<label for="edtPesoItem" class ="d-block d-lg-none d-xl-none">Peso</label>';
    strDiv +=    '<input type="number" class="form-control form-control-sm" id="edtPesoItem" aria-';     
    strDiv +=    'describedby="EDTPesoItem" value="">';
    strDiv +=    '<div id="MsgPesoItemVazio" class="d-none"><p class="text-danger">O Peso dever ser maior que zero</div>';
    strDiv  +=' </div>';
    //Valor Unitario
    strDiv +=  '<div class="form-group col-6 col-sm-6">';
    strDiv +=    '<label for="edtValUntItem" class ="d-none d-lg-block d-xl-block">Val.Unt</label>';
    strDiv +=    '<label for="edtValUntItem" class ="d-block d-lg-none d-xl-none">Valor Unitário</label>';
    strDiv +=    '<input type="number" class="form-control form-control-sm" id="edtValUntItem" aria-';     
    strDiv +=    'describedby="EDTValUnt" value="">';
    strDiv +=    '<div id="MsgValUntItemVazio" class="d-none"><p class="text-danger">O Valor Unitário dever ser maior que zero</div>';
    strDiv  +=' </div>';
    
    strDiv  +=' </div>';
    
    strDiv +='<div class="form-group row bg-secundary">';
    //Valor Bruto
    strDiv +=  '<div class="form-group col-6 col-sm-6">';
    strDiv +=    '<label for="edtValbrutoitem" class ="d-none d-lg-block d-xl-block">Valor Bruto</label>';
    strDiv +=    '<label for="edtValbrutoitem" class ="d-block d-lg-none d-xl-none">Val.Bruto</label>';
    strDiv +=    '<input readonly type="number" class="form-control form-control-sm" id="edtValbrutoitem" aria-';     
    strDiv +=    'describedby="EDTValBrutoItem" value="">';
    strDiv  +=' </div>';
    //Valor Desconto
    strDiv +=  '<div class="form-group col-6 col-sm-6">';
    strDiv +=    '<label for="edtValDescItem" class ="d-none d-lg-block d-xl-block">Valor Desconto</label>';
    strDiv +=    '<label for="edtValDescItem" class ="d-block d-lg-none d-xl-none">Desconto</label>';
    strDiv +=    '<input  type="number" class="form-control form-control-sm" id="edtValDescItem" aria-';     
    strDiv +=    'describedby="EDTValDescItem" value="">';
    strDiv  +=' </div>';
    strDiv  +=' </div>';
    
    strDiv +='<div class="form-group row bg-secundary">'; 
    //Valor Liquido
    strDiv +=  '<div class="form-group col-6 col-sm-4 ">';
    strDiv +=    '<label for="edtValLiqItem" class ="d-none d-lg-block d-xl-block">Valor Líquido</label>';
    strDiv +=    '<label for="edtValLiqItem" class ="d-block d-lg-none d-xl-none">Val.Líquido</label>';
    strDiv +=    '<input readonly type="number" class="form-control form-control-sm" id="edtValLiqItem" aria-';     
    strDiv +=    'describedby="EDTValLiqItem" value="">';
    strDiv  +=' </div>';

    strDiv +=  '<div class="form-group col-6 col-sm-8  d-flex justify-content-center">';
    strDiv += '     <button id="btnAddCarrinho" onclick="InserirnoCarrinho();" class="btn btn-primary btn-sm mx-auto my-2" type="button" >';
    strDiv += '        <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>Adicionar';
    strDiv += '     </button>';
    strDiv  +='</div>';
    strDiv +='<div id="MsgAddCarrinho" class="d-none"><p class="text-primary">Item adicionado com Sucesso!</div>';
    strDiv  +=' </div>';
    strDiv +=      '<input type="hidden" id="valTotalItens" value="">';

    
    return strDiv;
}
function FormDadosCobrancasPagto(){
    // Plano Pagamento
    Divstr ="";
    
    
    // transportador e Local de Entrega
    Divstr  +='<div class="form-row">';
    
    Divstr +=  '<div class="form-group col-sm-6">';
    Divstr +=    '<label for="edtTransportador">Transportador</label>';
    Divstr  +=   '<div class="input-group">';   
    Divstr +=       '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtTransportador" aria-describedby="TransportadorPedido" value="">';
    Divstr +=       '<div class="input-group-append">';
    Divstr +=           '<button type="button" id="btnPesqTransportador" class="btn bg-padrao text-white" onclick="PesqTransportador();"><span class="glyphicon glyphicon-search"></span> </button>';
    Divstr +=       '</div>';
    Divstr +=    '</div>';
    Divstr +=    '<input type="hidden" id="CodTransportador" name="CodTransportador" value="">';
    Divstr +=           '<div id="resultTransportador" class="d-none list-group bg-padrao">';      
    Divstr +=           '</div>';
    Divstr  +=' </div>';
    //Local Entrega
    Divstr +=  '<div class="form-group col-sm-6">';
    Divstr +=    '<label for="edtLocalEntrega">Local de Entrega</label>';
    Divstr  +=   '<div class="input-group">';   
    Divstr +=       '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtLocalEntrega" aria-describedby="LocalEntregaPedido" value="">';
    Divstr +=       '<div class="input-group-append">';
    Divstr +=           '<button id="btnPesqLocalEntrega" type="button" class="btn bg-padrao text-white" onclick="PesqLocalEntrega();"><span class="glyphicon glyphicon-search"></span> </button>';
    Divstr +=       '</div>';
    Divstr +=    '</div>';
    Divstr +=    '<div id="divlblTipoEndereco" class="d-none"><label class="text-danger" id="lblTipoEndereco"></label></div>';
    
    Divstr +=    '<input type="hidden" id="CodLocalEntrega" name="CodLocalEntrega" value="">';
    Divstr +=           '<div id="resultLocalEntrega" class="d-none list-group bg-padrao">';      
    Divstr +=           '</div>';
    Divstr  +=' </div>';
    
    Divstr  +=' </div>';
    
    Divstr  +='<div class="col-xs-12"><hr></div>'; 
    
    Divstr  +='<div class="form-row">';
    
    Divstr +=  '<div class="form-group col-sm-8">';
    Divstr += '<input  type="checkbox" value="S" for id="chkHabVeiculo" onchange="ClicaCheckVeiculo();" for="edtVeiculo">';
    Divstr +=  '<label class="ml-2" id="lblveiculo" for="edtVeiculo">Habilitar Veículo</label>';
    
    //Divstr += '<label class="form-check-label" for="edtVeiculo">Habilitar Veiculo</label>';

    Divstr  +=   '<div class="input-group d-none" id="divedtveiculo">';   
    Divstr +=       '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtVeiculo" aria-describedby="VeiculoPedido" value="">';
    Divstr +=       '<div class="input-group-append">'; 
    Divstr +=           '<button type="button" id="btnPesqVeiculo" class="btn bg-padrao text-white" onclick="PesqVeiculo();"><span class="glyphicon glyphicon-search"></span> </button>';
    
    Divstr +=       '</div>';
    Divstr +=       '<input type="hidden" id="CodVeiculo" name="CodVeiculo" value="">';
    Divstr +=    '</div>';
    Divstr +=       '<div id="resultVeiculo" class="d-none list-group bg-padrao">';      
    Divstr +=       '</div>';
    
    Divstr += '</div>';
    Divstr += '<div class="form-group col-sm-2 d-none" id="divedtplacaveiculo">';
    Divstr +=    '<label for="edtPlacaVeic">Placa</label>';
    Divstr +=    '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtPlacaVeic" aria-describedby="PlacaVeiculo" value="">';
    Divstr += '</div>';
    Divstr += '<div class="form-group col-sm-2 d-none" id="divedtufveiculo">';
    Divstr +=    '<label for="edtUFVeic">UF</label>';
    Divstr +=    '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtUFVeic" aria-describedby="UFPlacaVeiculo" value="">';
    Divstr += '</div>';
    Divstr += '</div>';

    
    Divstr  +='<div class="col-xs-12"><hr></div>';
    
    Divstr +='<div class="form-row">';
    Divstr +=  '<div class="form-group col-sm-6">';
    Divstr +=    '<label for="edtPlanoPagto">Plano de Pagamento</label>';
    Divstr +=   '<div class="input-group">';   
    Divstr +=       '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtPlanoPagto" aria-describedby="PlanoPagtoPedido" value="">';
    Divstr +=       '<div class="input-group-append">';
    Divstr +=           '<button type="button" id="btnPesqPlanoPagto" class="btn bg-padrao text-white" onclick="PesqPlanoPagto();"><span class="glyphicon glyphicon-search"></span> </button>';
    Divstr +=       '</div>';
    Divstr +=    '</div>';
    Divstr +=    '<input type="hidden" id="CodPlanoPagto" name="CodPlanoPagto" value="">';
    Divstr +=           '<div id="resultPlanoPagto" class="d-none list-group bg-padrao">';      
    Divstr +=           '</div>';
    Divstr +='  </div>';
    Divstr +=  '<div class="form-group col-sm-6">';
    Divstr +=    '<label for="edtPortador">Portador</label>';
    Divstr +=   '<div class="input-group">';   
    Divstr +=       '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtPortador" aria-describedby="PortadorPedido" value="">';
    Divstr +=       '<div class="input-group-append">';
    Divstr +=           '<button type="button" id="btnPesqPortador" class="btn bg-padrao text-white" onclick="PesqPortador();"><span class="glyphicon glyphicon-search"></span> </button>';
    Divstr +=       '</div>';
    Divstr +=    '</div>';
    Divstr +=    '<input type="hidden" id="CodPortador" name="CodPortador" value="">';
    Divstr +=           '<div id="resultPortador" class="d-none list-group bg-padrao">';      
    Divstr +=           '</div>';
    Divstr +=' </div>';

    Divstr +=' </div>';
    
    Divstr +='<div class="form-row">';
    Divstr +=  '<div class="form-group col-sm-6">';
    Divstr +=    '<label for="edtCarteira">Carteira</label>';
    Divstr +=   '<div class="input-group">';   
    Divstr +=       '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtCarteira" aria-describedby="CarteiraPedido" value="">';
    Divstr +=       '<div class="input-group-append">';
    Divstr +=           '<button type="button" id="btnPesqCarteira" class="btn bg-padrao text-white" onclick="PesqCarteira();"><span class="glyphicon glyphicon-search"></span> </button>';
    Divstr +=       '</div>';
    Divstr +=    '</div>';
    Divstr +=    '<div id="divlblBancoAgencia" class="d-none"><label class="text-danger" id="lblBancoAgencia"></label></div>';
    
    Divstr +=    '<input type="hidden" id="CodCarteira" name="CodCarteira" value="">';
    Divstr +=           '<div id="resultCarteira" class="d-none list-group bg-padrao">';      
    Divstr +=           '</div>';
    Divstr +=' </div>';
    Divstr +=' </div>';
    return Divstr;
}
function FormDadosGerais(TpMov,CodUnidade,CodUsuario){
    console.log("Aqui:"+TpMov+CodUnidade+CodUsuario);
    
    varTipoMovimento = TpMov;
    
    Divdadosgerais ="";
    
    var now = new Date();

    dia = ("0" + now.getDate()).slice(-2);
    mes = ("0" + (now.getMonth() + 1)).slice(-2);
    ano = now.getFullYear()

    var Datahoje = ano+"-"+(mes)+"-"+(dia) ;

    //Data pedido
    Divdadosgerais  +='<div class="form-row">';
    Divdadosgerais +=  '<div class="form-group col-sm-4">';
    Divdadosgerais +=    '<label for="edtdatapedido">Data Pedido</label>';
    Divdadosgerais +=    '<input  type="date"  class="form-control  form-control-sm" id="edtdatapedido" aria-';     Divdadosgerais +=    'describedby="DataPedido" value="'+Datahoje+'">';
    Divdadosgerais  +=' </div>';
    Divdadosgerais +=  '<div class="form-group col-sm-4">';
    Divdadosgerais +=    '<label for="edtdatamovimento">Data Movimento</label>';
    Divdadosgerais +=    '<input  type="date"  class="form-control  form-control-sm" id="edtdatamovimento" aria-';     Divdadosgerais +=    'describedby="DataMovimento" value="'+Datahoje+'">';
    Divdadosgerais  +=' </div>';
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais  +='<div class="form-row">';
    // ---------------------------------Micro Conta-----------------------------
    Divdadosgerais +=  '<div class="form-group col-sm-6">';
    Divdadosgerais +=    '<label for="edtTransFiscal">Micro Conta</label>';
    Divdadosgerais  +=   '<div class="input-group">';   
    Divdadosgerais +=       '<input required type="text" autocomplete="off" class="form-control form-control-sm" id="edtTransFiscal" aria-describedby="MContaPedido" value="">';
    Divdadosgerais +=       '<div class="input-group-append">';
    Divdadosgerais +=           '<button id="btnPesqTransFiscal" type="button" class="btn bg-padrao text-white" onclick="PesqMicroConta('+"'"+TpMov+"'"+');"><span class="glyphicon glyphicon-search"></span> </button>';
    Divdadosgerais +=       '</div>';
    Divdadosgerais +=    '</div>';
    Divdadosgerais +='<div id="MsgMicroContaVazio" class="d-none"><p class="text-danger">Campo Micro Conta vazio ou inválido !</div>';
    Divdadosgerais +=    '<input type="hidden" id="CodTransFiscal" name="CodTransFiscal" value="">';
    Divdadosgerais +=    '<input type="hidden" id="CodUsuarioLogado" name="CodTransFiscal" value="'+CodUsuario+'">';
    Divdadosgerais +=    '<div class="invalid-feedback font-weight-bold">Forneça a Micro conta</div>';
    Divdadosgerais +=           '<div id="resultMicroconta" class="d-none list-group bg-padrao">';      
    Divdadosgerais +=           '</div>';
    Divdadosgerais  +=' </div>';
    //---------------------------------Unidade--------------------------------
    Divdadosgerais  +=      '<div class=" col-sm-6">';
    Divdadosgerais  +=          '<label for="edtUnidade">Depósito</label>';
    Divdadosgerais  +=          '<div class="input-group">';   
    Divdadosgerais +=               '<input  required autocomplete="off" type="text" class="form-control form-control-sm" id="edtUnidade" aria-describedby="UnidadePedido" value="">'; 
    Divdadosgerais +=                 '<div class="input-group-append">';
    Divdadosgerais +=                   '<button id="btnPesqUnidade" type="button" class="btn bg-padrao text-white" onclick="PesqDeposito('+CodUnidade+');"><span class="glyphicon glyphicon-search"></span> </button>';
    Divdadosgerais +=                 '</div>';
    Divdadosgerais +=           '</div>';
    Divdadosgerais +='<div id="MsgUnidadeVazio" class="d-none"><p class="text-danger">Campo Depósito vazio ou inválido!</div>';
    Divdadosgerais +='          <input type="hidden" id="CodUnidade" name="CodUnidade" value="">';
    Divdadosgerais +=           '<div id="resultUni" class="d-none list-group bg-padrao">';      
    Divdadosgerais +=           '</div>';
    Divdadosgerais  +=      '</div>';
    
    Divdadosgerais  +=' </div>'; 
    
    Divdadosgerais  +='<div class="col-xs-12"><hr></div>';
    
    Divdadosgerais  +='<div class="form-row">';
    
    console.log(((TpMov==="E")?"selected":" "));
    Divdadosgerais +=  '<div class="form-group col-sm-4">';
    Divdadosgerais +=       '<label for="CbEntidade">Entidade</label>';
    Divdadosgerais +=       '<select  class="form-control  form-control-sm" id="CbEntidade">';
    Divdadosgerais +=           '<option value=0 '+((TpMov==="S")?"selected":" ")+'> CLIENTE </option>';
    Divdadosgerais +=           '<option value=1 '+((TpMov==="E")?"selected":" ")+'> FORNECEDOR</option>';
    Divdadosgerais +=           '<option value=2> PRODUTOR</option>';
    Divdadosgerais +=           '<option value=3> VENDEDOR</option>';
    Divdadosgerais +=           '<option value=4> FUNCIONÁRIO</option>';
    Divdadosgerais +=           '<option value=5> REPRESENTANTE</option>';
    Divdadosgerais +=           '<option value=6> CARRETEIRO</option>';
    Divdadosgerais +=           '<option value=7> PROMOTOR</option>';
    Divdadosgerais +=           '<option value=8> TRANSPORTADOR</option>';
    Divdadosgerais +=           '<option value=9> DEPARTAMENTO</option>';
    Divdadosgerais +=           '<option value=10> UNIDADE</option>';
    Divdadosgerais +=      '</select>'; 
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais  +=      '<div class=" col-sm-8">';
    Divdadosgerais  +=          '<label for="edtEntidade">Nome</label>';
    Divdadosgerais  +=          '<div class="input-group">';   
    Divdadosgerais +=               '<input  required autocomplete="off" type="text" class="form-control form-control-sm" id="edtEntidade" aria-describedby="PessoaPedido" value="">'; 
    Divdadosgerais +=                 '<div class="input-group-append">';
    Divdadosgerais +=                   '<button type="button" class="btn bg-padrao text-white" onclick="PesqEntidade();"><span class="glyphicon glyphicon-search"></span> </button>';
    Divdadosgerais +=                 '</div>';
    Divdadosgerais +=           '</div>';
    Divdadosgerais +='<div id="MsgEntidadeVazio" class="d-none"><p class="text-danger">Campo Pessoa vazio ou inválido!</div>';
    Divdadosgerais +='<div id="DivDescPropriedade" class="d-none"><p class="text-danger"></p></div>';
    Divdadosgerais +='          <input type="hidden" id="CodEntidade"  name="CodEntidade" value="">';
    Divdadosgerais +='          <input type="hidden" id="CodPessoa" name="CodPessoa" value="">';
    Divdadosgerais +='          <input type="hidden" id="CodPropriedade" name="CodPropriedade" value="">';
    Divdadosgerais +=           '<div id="resultEntidade" class="d-none list-group bg-padrao">';      
    Divdadosgerais +=           '</div>';
    Divdadosgerais  +=      '</div>';
    
    Divdadosgerais  +=      '</div>';
    
    Divdadosgerais  +='<div class="col-xs-12"><hr></div>';
    
    //CFOP
    Divdadosgerais  +='<div class="form-row">';
    
    Divdadosgerais +=  '<div class="form-group col-sm-6">';
    Divdadosgerais +=    '<label for="edtCFOPPed">CFOP</label>';
    Divdadosgerais  +=   '<div class="input-group">';   
    Divdadosgerais +=       '<input type="text"  autocomplete="off" class="form-control form-control-sm" id="edtCFOPPed" aria-describedby="CFOPPedido" value="">';
    Divdadosgerais +=       '<div class="input-group-append">';
    Divdadosgerais +=           '<button type="button" id="btnPesqCFOPPed" class="btn bg-padrao text-white" onclick="PesqCFOP('+"'"+'P'+"'"+');"><span class="glyphicon glyphicon-search"></span> </button>';
    Divdadosgerais +=       '</div>';
    Divdadosgerais +=    '</div>';
    Divdadosgerais +=    '<input type="hidden" id="CodCFOPPed" name="CodCFOPPed" value="">';
    Divdadosgerais +=           '<div id="resultCFOPPed" class="d-none list-group bg-padrao">';      
    Divdadosgerais +=           '</div>';
    Divdadosgerais  +=' </div>';
    
    //vendedor e Usuario
    
    Divdadosgerais +=  '<div class="form-group col-sm-6">';
    Divdadosgerais +=    '<label for="edtVendedor">Vendedor</label>';
    Divdadosgerais  +=   '<div class="input-group">';   
    Divdadosgerais +=       '<input type="text" autocomplete="off" class="form-control form-control-sm" id="edtVendedor" aria-describedby="VendedorPedido" value="">';
    Divdadosgerais +=       '<div class="input-group-append">';
    Divdadosgerais +=           '<button id="btnPesqVendedor" type="button" class="btn bg-padrao text-white" onclick="PesqVendedor();"><span class="glyphicon glyphicon-search"></span> </button>';
    Divdadosgerais +=       '</div>';
    Divdadosgerais +=    '</div>';
    Divdadosgerais +=    '<input type="hidden" id="CodVendedor" name="CodVendedor" value="">';
    Divdadosgerais +=           '<div id="resultVendedor" class="d-none list-group bg-padrao">';      
    Divdadosgerais +=           '</div>';
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais  +=' </div>';
    
    
    
    return Divdadosgerais;
}
function RetornaTelaNovoPedido(TpMov,CodUnidade,CodUsuario){
    
    LimparCarrinho();
    
    if (TpMov == 'S'){strtpmov = "Novo Pedido de Saída"; }
    else{strtpmov = "Novo Pedido de Entrada";}
    
    strDiv =  '<div class="row bg-padrao p-0">';
    strDiv += '<div class="col-10">';
    strDiv +=    '<p class="text-white h5 text-alig-center" id="lbltoNovoPed">'+strtpmov+'</p>';
    strDiv += '</div>';
    strDiv += '<div class="col-2">';
    strDiv += '<div id="divCarrinho" class="d-none">';
    strDiv +=       '<button id="btnCarrinho" type="button" class="btn btn-primary text-white border-2 rounded-2" data-toggle="modal" data-target=".modalcarrinho"><span class="glyphicon glyphicon-shopping-cart">0</span></button>';
    strDiv +=   '</div>';
    strDiv += '</div>';
    strDiv += '</div>';

    strDiv += '<div class="mt-2" id="accordionPedido">';
    
    strDiv += '        <div class="mt-2 mb-2 d-none" id="heading">';
    strDiv += '                <button id="btnDadosGerais" class="btn btn-outline-success mt-1 mb-1" data-toggle="collapse" data-target="#colDadosGerais" aria-expanded="true" aria-controls="colDadosGerais">';
    strDiv +=                       'Dados Gerais';
    strDiv += '                </button>';
    //Itens
    strDiv += '                <button class="btn btn-outline-success mt-1 mb-1" data-toggle="collapse" data-target="#colItens" aria-expanded="true" aria-controls="colItens">';
    strDiv +=                       'Itens';
    strDiv += '                </button>';
    //cobranca
    strDiv += '                <button class="btn btn-outline-success mt-1 mb-1" data-toggle="collapse" data-target="#col_Pagto" aria-expanded="true" aria-controls="col_Pagto">';
    strDiv += '                    Cobrança e Valores';
    strDiv += '                </button>';
    //Historico e Mensagem
    strDiv += '                <button class="btn btn-outline-success mt-1" data-toggle="collapse" data-target="#col_HistPagto" aria-expanded="true" aria-controls="col_HistPagto">';
    strDiv +=                       'Msg.Fiscal/Historico';
    strDiv += '                </button>';
    
    
    strDiv += '        </div>';
    //Form-----
    //strDiv += '<form id="FormNovoPedido" method="post"  class="was-validated mx-4">';
    // -------------------------- Card Dados Gerais ----------------------------------------------------
    strDiv += '    <div class="card bgcard-padrao p-10">';

    strDiv += '        <div id="colDadosGerais" class="collapse" aria-labelledby="heading" data-parent="#accordionPedido">';
    strDiv += '            <div class="card-body">';
    strDiv += '<div class="row">';
    strDiv += '<div class="col-3"></div>'; 
    strDiv += '<div class="col-6">';
    strDiv += '<div class=" border border-white bg-padrao" style="border-radius: 10px;"><p class="text-white my-auto text-center justify-content-center">Dados Gerias</p></div>';
    strDiv += '</div><div class="col-3"></div></div>';
    
    strDiv += FormDadosGerais(TpMov,CodUnidade,CodUsuario);
    // div botao proximo
    strDiv += '<div id="rodapepedidoQ" class="d-flex flex-row-reverse bg-padrao  p-10" >';
    strDiv += '<div class="my-1 ml-2 mr-2" >'; 
    strDiv += '    <button id="btnDadosGerais_Proximo" onclick="btnDadosGerais_ProximoClick()";  class="btn btn-primary btn-sm"   type="button" mr-2" >';
    strDiv += '        <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Próximo';
    strDiv += '    </button>';
    strDiv += '    <button class="btn btn-danger btn-sm" type="button" ml-2 mr-2" onclick="CancelarNovoPed();">';
    strDiv += '        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar';
    strDiv += '    </button>';
    strDiv += '</div>';                        
    strDiv += '</div>';
    
    strDiv += '            </div>';
    strDiv += '        </div>';
    strDiv += '    </div>';
    
    // -------------------------- Card Itens ----------------------------------------------------
    var aItensCarrinho = new Array();
    var contItensCarrinho = 0;
    
    strDiv += '    <div class="card bgcard-padrao ">';
    strDiv += '        <div id="colItens" class="collapse" aria-labelledby="heading" data-parent="#accordionPedido">';
    strDiv += '            <div class="card-body">';
                                    
    strDiv += FormDadosItens();
    
    // div botao proximo
    strDiv += '<div id="rodapepedido" class="d-flex flex-row-reverse bg-padrao  p-10" >';
    strDiv += '<div class="my-1 ml-2 mr-2" >';
    strDiv += '    <button id="btnItem_Voltar" onclick="btnItem_VoltarClick()";  class="btn btn-primary btn-sm  type="button" mr-1" >';
    strDiv += '        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar';
    strDiv += '    </button>';
    strDiv += '    <button id="btnItem_Proximo" onclick="btnItem_ProximoClick()";  class="btn btn-primary btn-sm  type="button" mr-1" >';
    strDiv += '        <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Próximo';
    strDiv += '    </button>';
    strDiv += '    <button class="btn btn-danger btn-sm" type="button" ml-1 mr-1" onclick="CancelarNovoPed();">';
    strDiv += '        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar';
    strDiv += '    </button>';
    strDiv += '</div>';                        
    strDiv += '</div>';
    
    
                                      
    strDiv += '            </div>';
    strDiv += '        </div>';
    strDiv += '    </div>';
    
    // -------------------------- Card Cobrança e Valores ----------------------------------------------------
    strDiv += '    <div class="card bgcard-padrao">';

    strDiv += '        <div id="col_Pagto" class="collapse" aria-labelledby="heading" data-parent="#accordionPedido">';
    strDiv += '            <div class="card-body">';
                                      
    //strDiv += '<p>Cobranças e Plano de Pagamento</p>';
    strDiv += FormDadosCobrancasPagto();//aqui Form Cobrança                                  
    
    
    strDiv += '<div id="rodapepedido" class="d-flex flex-row-reverse bg-padrao  p-10" >';
    strDiv += '<div class="my-1 ml-2 mr-2" >';
    strDiv += '    <button id="btnCobranca_Voltar" onclick="btnCobranca_VoltarClick();";  class="btn btn-primary btn-sm  type="button" mr-1" >';
    strDiv += '        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar';
    strDiv += '    </button>';
    strDiv += '    <button id="btnCobranca_Proximo" onclick="btnCobranca_ProximoClick();";  class="btn btn-primary btn-sm  type="button" mr-1" >';
    strDiv += '        <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Próximo';
    strDiv += '    </button>';
    strDiv += '    <button class="btn btn-danger btn-sm" type="button" ml-1 mr-1" onclick="CancelarNovoPed();">';
    strDiv += '        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar';
    strDiv += '    </button>';
    strDiv += '</div>';                        
    strDiv += '</div>';
    
    
    
    strDiv += '            </div>';
    strDiv += '        </div>';
    strDiv += '    </div>';
    
    // -------------------------- Historico e Msg Fiscal ----------------------------------------------------
    strDiv += '    <div class="card bgcard-padrao">';

    strDiv += '        <div id="col_HistPagto" class="collapse" aria-labelledby="heading" data-parent="#accordionPedido">';
    strDiv += '            <div class="card-body">';
    strDiv += '<p>Historico e Mensagel</p>';                                  
             
    
    strDiv += '<div id="rodapepedido" class="d-flex flex-row-reverse bg-padrao  p-10" >';
    strDiv += '<div class="my-1 ml-2 mr-2" >';
    strDiv += '    <button id="btnHistoricoMsg_Voltar" onclick="btnHistoricoMsg_VoltarClick()";  class="btn btn-primary btn-sm  type="button" mr-1" >';
    strDiv += '        <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar';
    strDiv += '    </button>';
    strDiv += '    <button id="btnConfirmarPedido" onclick="ConfirmarPedido()";  class="btn btn-primary btn-sm  type="button" mr-1" >';
    strDiv += '<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span> Confirmar';
    strDiv += '    </button>';
    strDiv += '    <button class="btn btn-danger btn-sm" type="button" ml-1 mr-1" onclick="CancelarNovoPed();">';
    strDiv += '        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar';
    strDiv += '    </button>';
    strDiv += '</div>';                        
    strDiv += '</div>';
    
    
    strDiv += '            </div>';
    strDiv += '        </div>';
    strDiv += '    </div>';
    strDiv += '<div id="divMsgAlerta" class="alert alert-danger alert-dismissible fade show d-none" role="alert">';
    strDiv += 'Olha esse alerta animado, como é chique!';
    strDiv +='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
    strDiv +='<span aria-hidden="true">&times;</span>';
    strDiv +='</button></div>';

    
    strDiv +='<div  class="modal fade modalcarrinho" id="modalcarrinho" tabindex="-1" role="dialog"   aria-labelledby="myLargeModalLabel" aria-hidden="true"></div>';
    
    
    strDiv +='<div class="modal fade" id="DivModalInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
    strDiv +='<div class="modal-dialog" role="document">';
    strDiv +='<div class="modal-content">';
    strDiv +='  <div class="modal-header">';
    strDiv +='<h5 class="modal-title" id="TltModalInfo">Informação</h5>';
    strDiv +='<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    strDiv +='<span aria-hidden="true">&times;</span>';
    strDiv +='</button></div>';
    strDiv +='<div class="modal-body" id="DivModalInfoMsg"></div>';
    strDiv +='<div class="modal-footer">';
    strDiv +='<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>';
    strDiv +='</div></div></div></div>';
    

    //strDiv += '</form>';
    

    
    return strDiv;
}

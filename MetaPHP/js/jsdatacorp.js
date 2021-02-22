
function AtulizaFiltro(){
    indexfiltro =  $('#selectgrupo option:selected').val();
    console.log(indexfiltro);
    $('#edt_Pesq').removeAttr("placeholder");
    //$('#edt_Pesq').attr("placeholder","Filtrar por: "+ $('#selectgrupo option:selected').text());
    $('#edt_Pesq').attr("placeholder","Digite Aqui");
    $('#pselgrupo').html("Filtrar por: "+ $('#selectgrupo option:selected').text());
        
        
}

function PovoaDivDadosPedido(dadosped,TpMov){
    var TipoMov= (TpMov == 'S')?"Saída":"Entrada";
    
    $("#DivMostraDados").removeClass("d-none");
    $("#DivMostraDados").addClass("d-block");
                    
    $("#DivMostraDados").html("");
                    
    var StrDiv='<div class="row d-flex align-items-center flex-column mx-0 mb-2 bg-padrao" >';
    StrDiv +='<p class="text-white h5" id="lblTituloMenu">Pedidos de '+ TipoMov+'</p></div>';
        
    //aqui criar nav
    StrDiv +='<nav class="navbar navbar-expand-lg navbar-light bg-padrao justify-content-between"">';
    //botão inserir
    
    console.log("botao inserir novo:"+varTipoMovimento);
    
    btnnovopedclick  = "InserirNovoPedido("+"'"+TpMov+"',"+varCodUnidade+","+varCodUsuario+",'"+varDataInicial+"','";
    btnnovopedclick += varDataInicial+"','"+varMesano+"','"+varDescUnidade+"');";
    
    StrDiv +='<div class="row d-flex align-items-center flex-column mx-0 mb-2 mt-2" >';
    StrDiv +='<button class="btn btn-padrao"  id="btnInsert" onclick="'+btnnovopedclick+'" ><span class="glyphicon glyphicon-plus"></span> Inserir Pedido</button></div>';
    //botão menu
        
    StrDiv +='<button class="d-lg-none d-xl-none  text-white btn btn-success" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2" aria-expanded="false" aria-label="Toggle navigation">';
    StrDiv +='<span style="cursor:pointer" >&#9776;</span> Filtrar</button>';
    StrDiv +='<div class="collapse navbar-collapse" id="navbarSupportedContent2">';
       
    StrDiv +='<div class="input-group ml-lg-2" type="search">';
    StrDiv +='<input type="text" class="form-control border-white border-2 rounded-2" placeholder="Digite aqui" id="edt_Pesq" aria-label="Digite aqui" aria-describedby="button-addon2">';
                        
    StrDiv +='<div class="input-group-append">';
    StrDiv +='<select id="selectgrupo" onchange="AtulizaFiltro();" class="custom-select" style="width:0px;">';
    StrDiv +='<option value=0 selected>Nº Pedido</option>';
    StrDiv +='<option value=1>Data do Pedido</option>';
    StrDiv +='<option value=2>Micro Conta</option>';
    StrDiv +='<option value=3>Pessoa</option>';
    StrDiv +='<option value=4>Plano de Pagamento</option>';
    StrDiv +='<option value=5>Status</option>';
    StrDiv +='<option value=6>Status Faturamento</option>';
    StrDiv +='<option value=7>Status Entidade</option>';
    StrDiv +=' </select>';
    StrDiv +='<button class="btn btn-padrao" type="button" onchange="edtpesqchange();" onclick="FiltrarPedidos('+"'"+TpMov+"'"+');" id="btn_Pesq"><span class="glyphicon glyphicon-search"></span> </button>';
    StrDiv +='</div>';
        
        StrDiv +='<p class="text-danger d-none" id="pmsgcampo" >Campo Pesquisa Vazio</p>';
        StrDiv +='<p class="text-white d-none d-lg-block d-xl-block ml-2 "  for="#selectgrupo" id="pselgrupo" >Grupo: Todos</p>';
        
        StrDiv +='</div>';
        
        //StrDiv +='</li></ul>';
        StrDiv +='</div>';
        
        StrDiv +='</nav>';
                    
                   
        $.each(dadosped, function(chave,valor){
        //aqui cria 
            var status = dadosped[chave]["Pedido"]["status"];
            var statusfat = (dadosped[chave]["Pedido"]["statusfaturamento"]=='S')?"Sim":"Não";
            var numnf = dadosped[chave]["Pedido"]["numnf"];
            var pIdpedido = "'"+dadosped[chave]["Pedido"]["idpedido"]+"'";
            var strcodent = dadosped[chave]["Pedido"]["entidade"];
            var entidade = RetornaNomeEntidade(strcodent);
            var cortexto = "";
            
            var DisabledEditDel = (statusfat=="Sim")?"Disabled":(status=="C")?"Disabled":"";  
                        
            switch (status){
                case "A":
                    status = "Aberto";
                    cortexto = "text-dark";
                    break;
                case "C":
                    status = "Cancelado";
                    cortexto = "text-danger";
                    break;
                default:
                    status = "";
            }
            if((statusfat=='Não') && status=="Aberto"){
                cortexto = "text-dark";    
            }
            else{
                if(status=="Cancelado"){
                    cortexto = "text-danger";    
                }else{
                    cortexto = "text-primary"; }

            }
            
            //voltaaa
            idped = dadosped[chave]["Pedido"]["idpedido"];
            StrDiv += '<div name="cardheaderitem" id="CardHeardItem_'+idped+'" class="card-header mx-2 mt-2  bg-ligth border border-bottom-0 border-primary">';
            StrDiv += '<p id="p'+idped+'" class="card-text ' +cortexto+'  font-weight-bold">';
            // Header;
            StrDiv += 'Nº Pedido: '+dadosped[chave]["Pedido"]["idpedido"]+', Data do Pedido:   '+dadosped[chave]["Pedido"]["data"]+', Valor Líquido: R$'+dadosped[chave]["Pedido"]["valorliquido"];
            StrDiv += '</p>';
                        
            StrDiv += '<p class="card-text '+cortexto+' font-weight-bold">';
            // Header;
            StrDiv += '<label id="statusped">Status: '+status+'</label>, Faturado: '+statusfat;
            StrDiv += (statusfat=="Sim")?', Nº da NF: '+numnf : "";        
            StrDiv += '</p>';
                        
            //body
            StrDiv +='</div>';
            StrDiv +='<div id="CardBodyItem_'+dadosped[chave]["Pedido"]["idpedido"]+'" class="card-body bg-ligth border border-top-0 border-primary mx-2">';
            StrDiv +='<p class="card-text '+cortexto+' ">';
            StrDiv +='Depósito: '+dadosped[chave]["Pedido"]["idunidade"]+' - '+dadosped[chave]["Pedido"]["descunidade"]; 
            StrDiv +='</p>';
            StrDiv +='<p class="card-text '+cortexto+' ">';
            StrDiv +='Entidade: '+entidade+', Pessoa: '+dadosped[chave]["Pedido"]["nomedaentidade"]; 
            StrDiv +='</p>';
            StrDiv +='<p class="card-text '+cortexto+' ">';
            StrDiv +='Transação Fiscal: '+dadosped[chave]["Pedido"]["idtransfiscal"]+' - '+dadosped[chave]["Pedido"]["desctransfiscal"]; 
            StrDiv +='</p>';
            StrDiv +='<p class="card-text '+cortexto+' ">';
            StrDiv +='Plano Pagto: '+dadosped[chave]["Pedido"]["idplanopagto"]+' - '+dadosped[chave]["Pedido"]["descplanopagto"]; 
            StrDiv +='</p>';
            // BOTÔES ITENS DETALHES, EDITAR, EXCLUIR, CANCELAR

            StrDiv +='<button onclick="BtnVerDetalhes('+chave+','+pIdpedido+');" class="btn btn-success btn-sm mx-1"><span class="glyphicon glyphicon-plus"></span> Detalhes</button>';
            StrDiv +='<button href="#" onclick="BtnEditarPedido('+pIdpedido+');" class=" btn btn-sm btn-warning '+DisabledEditDel+' mx-1 my-1"><span class="glyphicon glyphicon-pencil"></span> Editar</button>';
            
            
            
            var DisableDel = (DisabledEditDel=="")? true: false;
            var DbloqnoneBtn= (DisabledEditDel=="")? "": "d-none";
            
            var st = "'"+status+"'";
            var stfat = "'"+statusfat+"'";
            var strexc = "Excluido";
            strexc = "'"+strexc+"'";
            
            // ---------------------- BOTAO EXCLUIR ------------------------------------
            StrDiv +='<button  type="button" data-toggle="modal" data-target="#ModalExcluir_'+pIdpedido+'" onclick="ChamaModalExcluir('+pIdpedido+','+DisableDel+','+st+','+stfat+','+strexc+');"href="#" class=" btn btn-danger btn-sm '+DisabledEditDel+' mx-1 my-1"><span class="glyphicon glyphicon-trash"> </span> Excluir</button>';
            //Modal Excluir
            // ---------------------- BOTAO CANCELAR ------------------------------------
            strexc = "Cancelado";
            strexc = "'"+strexc+"'";
            StrDiv +='<button id="btncancelaped" type="button" data-toggle="modal" data-target="#ModalCancelss" onclick="ChamaModalCancelar('+pIdpedido+','+DisableDel+','+st+','+stfat+','+strexc+');" class="btn btn-danger btn-sm '+DbloqnoneBtn+' mx-1 my-1" ><span class="glyphicon glyphicon-remove"></span> Cancelar</button>';
            // ---------------------- BOTAO REABRIR ------------------------------------
            strexc = "Reabrir";
            strexc = "'"+strexc+"'";
            if (statusfat =="Sim"){
                DbloqnoneBtn = "d-none";     
            }
            else if((status=="Cancelado") && (statusfat="Não")){
                DbloqnoneBtn = ""; 
            }
            else{
                DbloqnoneBtn = "d-none";}
            
            StrDiv +='<button id="btnreabreped" type="button" data-toggle="modal" data-target="#Modalreabress" onclick="ChamaModalReabrir('+pIdpedido+','+DisableDel+','+st+','+stfat+','+strexc+');" class="btn btn-primary btn-sm '+DbloqnoneBtn+' mx-1 my-1" ><span class="glyphicon glyphicon-remove"></span> Reabrir</button>';
            
            // ---------------------- Modal Excluir ------------------------------------
            StrDiv += Retorna_DivModalExcluir(idped);
            StrDiv += Retorna_DivModalCancelar(idped);
            StrDiv += Retorna_DivModalReAbrir(idped);
            StrDiv +='</div>';
            
        });
        
        $("#DivMostraDados").html(StrDiv);
        $("#DivLoading").removeClass("d-block");
        $("#DivLoading").addClass("d-none");
        
}
function FiltrarPedidos(TpMov){
        edtcampopesq =  $('#edt_Pesq').val(); 
        if (edtcampopesq.trim().length==0){
            $('#pmsgcampo').removeClass('d-none');
            $('#pmsgcampo').addClass('d-block');
            PovoaDivDadosPedido(dadospedido,TpMov);
            AtulizaFiltro();
        }
        else{
            $('#pmsgcampo').removeClass('d-block');
            $('#pmsgcampo').addClass('d-none');
            //console.log(edtcampopesq);
            var CampoPesq="";
                        
            var dadospedfiltrado = new Array();
            var cont =0;
            $.each(dadospedido, function(chave,valor){
                
               switch (indexfiltro){
                    case "0":
                        CampoPesq = dadospedido[chave]["Pedido"]["idpedido"];
                        break;
                    case "1":
                        CampoPesq = dadospedido[chave]["Pedido"]["data"];
                        break;
                    case "2":
                        CampoPesq = dadospedido[chave]["Pedido"]["desctransfiscal"];
                        break;
                    case "3":
                        CampoPesq = dadospedido[chave]["Pedido"]["nomedaentidade"];
                        break;
                    case "4":
                        CampoPesq = dadospedido[chave]["Pedido"]["descplanopagto"];
                        break;
                    case "5":
                        CampoPesq = (dadospedido[chave]["Pedido"]["status"]=='A')?"Aberto":"Cancelado";
                        break;
                    case "6":
                        CampoPesq = (dadospedido[chave]["Pedido"]["statusfaturamento"]=='S')?"Sim":"Não";
                        break;
                    case "7":
                        CampoPesq = (dadospedido[chave]["Pedido"]["tipoentidade"]);
                        break;
                    default:
                        CampoPesq = "";
                }
                var contem = false;
                if (indexfiltro != 0){
                    contem =  CampoPesq.toUpperCase().includes(edtcampopesq.toUpperCase());
                    if (!contem){
                        contem =  CampoPesq.toLowerCase().includes(edtcampopesq.toLowerCase());
                    }
                                                 
                }
                else{contem = (CampoPesq == edtcampopesq)?true:false;}
                console.log(contem);
                if (contem){
                    console.log("entrei");
                    dadospedfiltrado[cont] = dadospedido[chave];
                    cont = cont+1;
                }
                
                
            });
            if(!IsVazio(dadospedfiltrado)){
                
                PovoaDivDadosPedido(dadospedfiltrado,TpMov);
                AtulizaFiltro();
            }
            else
            {
                alert("Nenhum Registro foi encontrado");
            }
        }
        
}
function Voltargridped(){
    $('#DivacaoDetalhes').removeClass('d-block');
    $('#DivacaoDetalhes').addClass('d-none');
    $('#DivacaoDetalhes').fadeOut(1000);
    $('#Divacaogrid').removeClass('d-none');
    $('#Divacaogrid').addClass('d-block');
    $('#navbottom').addClass('d-block');
    //$('#navbottom').addClass('fixed-bottom');
    $('#navbottom').fadeIn(1000);
    
}
function BtnVerDetalhes(vindex,Idpedido){
    $('#DivacaoDetalhes').removeClass('d-none');
    $('#DivacaoDetalhes').addClass('d-block');
    $('#DivacaoDetalhes').fadeIn(1000);
    $('#Divacaogrid').removeClass('d-block');
    $('#Divacaogrid').addClass('d-none');
    $('#lblNumPedido').html("Nº do Pedido: "+ Idpedido);
    $('#navbottom').removeClass('d-block');
    //$('#navbottom').removeClass('fixed-bottom');
    $('#navbottom').fadeOut(1000);
    apedidoindex = dadospedido[vindex];
    console.log(apedidoindex);
    $('#tabItemdadosgerais').html(PreencheDadosGerais(apedidoindex));
    $('#tabItemDestinatario').html(PreencheDadosDestinatario(apedidoindex));
    BuscaDadosItemPedido(Idpedido);
    $('#tabItemCobranca').html(PreencheDadosCobranca(apedidoindex));
    $('#tabItemValores').html(PreencheDadosValores(apedidoindex));
    $('#tabItemObservacao').html(PreencheDadosHistoricoMsg(apedidoindex));
}
function BuscaDadosItemPedido(Idpedido){
    $.ajax({
        type:"GET",
        url:"../Consultas/getitempedido.php?idpedido="+Idpedido,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
                       
                },
                afterSend: function(){
                   
                }
        }).done( function(data){
            dadosrec = $.parseJSON(data);
        
            var DivItens = '<h3 id="headeritens">Itens</h3><div id="accordion">';
            var Cont = 0;
        
            $.each(dadosrec, function(chave,valor){
                //dadosrec[chave]["itens"]["descproduto"]);
                
                Cont+=1;
                IdItem =valor["itens"]["iditempedido"];
                IdProduto= valor["itens"]["idproduto"];
                DescProduto = valor["itens"]["descproduto"];
                PesoProd = valor["itens"]["pesoproduto"];
                QtdProd = valor["itens"]["qtdproduto"];
                ValUnt = valor["itens"]["valorunt"];
                ValorLiq = valor["itens"]["valorliquido"];
                Valorbruto = valor["itens"]["valorbruto"];
                ValorDesc = valor["itens"]["valdesconto"];
                CFOP = valor["itens"]["idnatoperacao"];
                NatOP = valor["itens"]["decnatoperacao"];
                //console.log(valor["itens"]["descproduto"]);
                DivItens += MontaTabItensDetail(IdItem,IdProduto,DescProduto,PesoProd,QtdProd,ValUnt,ValorLiq,Valorbruto,ValorDesc,CFOP,NatOP,Cont);
            });
            DivItens +='</div>';
            $('#tabItemitens').html(DivItens);
            $('#headeritens').html("Itens do Pedido("+Cont+")");
            //PovoaDivDadosPedido(dadospedido,TpMov);
            //AtulizaFiltro();
        }).fail( function(){
            console.log("ALGO DEU ERRADO");
        }).always( function(){
        });
}
// --------------- Dados do Item  ---------------------- 
function PreencheDadosGerais(arrayped,readonly){
    console.log(arrayped);
    Divdadosgerais ="";
    Divdadosgerais  +='<div class="form-row">';
    //NumPedido
    Divdadosgerais +=  '<div class="form-group col-4 col-sm-4">';
    Divdadosgerais +=    '<label for="edtnumpedido">Nº.Pedido</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtnumpedido" aria-';     
    Divdadosgerais +=    'describedby="NumPedido" value="'+arrayped["Pedido"]["idpedido"]+'">';
    Divdadosgerais +=' </div>';
    //Data pedido
    Divdadosgerais +=  '<div class="form-group col-4 col-sm-4">';
    Divdadosgerais +=    '<label for="edtdatapedido">Data Pedido</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtdatapedido" aria-';     Divdadosgerais +=    'describedby="DataPedido" value="'+arrayped["Pedido"]["data"]+'">';
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais +=  '<div class="form-group col-4 col-sm-4">';
    Divdadosgerais +=    '<label for="edtValorTotalPed">Valor Total</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValorTotalPed" aria-'; Divdadosgerais +=    'describedby="ValorTotalPedido" value="'+arrayped["Pedido"]["valorliquido"]+'">';
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais  +=' </div>';

    Divdadosgerais  +='<div class="form-row">';
    status    = (arrayped["Pedido"]["status"]=="A")?"Aberto":"Cancelado";
    statusfat = (arrayped["Pedido"]["statusfat"]=="S")?"Sim":"Não";
    // 
    Divdadosgerais +=  '<div class="form-group col-4 col-sm-4">';
    Divdadosgerais +=    '<label for="edtStatus">Status</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtStatus" aria-';     Divdadosgerais +=    'describedby="StatusPedido" value="'+status+'">';
    Divdadosgerais +=' </div>';
    
    Divdadosgerais +=  '<div class="form-group col-6 col-sm-4">';
    Divdadosgerais +=    '<label for="edtFaturado">Faturado?</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtFaturado" aria-';     Divdadosgerais +=    'describedby="stFaturadoPedido" value="'+statusfat+'">';
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais  +='</div>';
    
    Divdadosgerais  +='<div class="form-row">';
    
    //Unidade
    descunidadepai = arrayped["Pedido"]["unidadepai"];
    
    Divdadosgerais +=  '<div class="form-group col-sm-6">';
    Divdadosgerais +=    '<label for="edtUnidade">Unidade</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtUnidade" aria-';     
    Divdadosgerais +=    'describedby="UnidadePedido" value="'+descunidadepai+'">';
    Divdadosgerais  +=' </div>';
    //deposito
    descunidade = arrayped["Pedido"]["idunidade"]+" - "+arrayped["Pedido"]["descunidade"];
    Divdadosgerais +=  '<div class="form-group col-sm-6">';
    Divdadosgerais +=    '<label for="edtUnidade">Depósito</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtUnidade" aria-';     
    Divdadosgerais +=    'describedby="UnidadePedido" value="'+descunidade+'">';
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais  +=' </div>';
    
    //Micro Conta
    Divdadosgerais  +='<div class="form-row">';
    descmicroconta = arrayped["Pedido"]["idtransfiscal"]+" - "+arrayped["Pedido"]["desctransfiscal"];
    Divdadosgerais +=  '<div class="form-group col-sm-12">';
    Divdadosgerais +=    '<label for="edtTransFiscal">Micro Conta</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtTransFiscal" aria-';   Divdadosgerais +=    'describedby="MContaPedido" value="'+descmicroconta+'">';
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais  +=' </div>';
    //vendedor e Usuario
    Divdadosgerais  +='<div class="form-row">';
    descPessoa = arrayped["Pedido"]["idvendedor"]+" - "+arrayped["Pedido"]["nomevendedor"];
    Divdadosgerais +=  '<div class="form-group col-12 col-sm-6">';
    Divdadosgerais +=    '<label for="edtVendedor">Vendedor</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtVendedor" aria-';   Divdadosgerais +=    'describedby="VendedorPedido" value="'+descPessoa+'">';
    Divdadosgerais  +=' </div>';
    descPessoa = arrayped["Pedido"]["idusario"]+" - "+arrayped["Pedido"]["nomeusuario"];
    Divdadosgerais +=  '<div class="form-group col-12 col-sm-6">';
    Divdadosgerais +=    '<label for="edtUsuario">Usuário</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtUsuario" aria-';   Divdadosgerais +=    'describedby="UsuarioPedido" value="'+descPessoa+'">';
    Divdadosgerais  +=' </div>';
    
    Divdadosgerais  +=' </div>';
    // Data e Hora Sistema
    Divdadosgerais  +='<div class="form-row">';
 
    Divdadosgerais +=  '<div class="form-group col-4">';
    Divdadosgerais +=    '<label for="edtDataSistema">Data Sistema</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtDataSistema" aria-';   Divdadosgerais +=    'describedby="DataSistemaPedido" value="'+arrayped["Pedido"]["datasistema"]+'">';
    Divdadosgerais  +=' </div>';
    Divdadosgerais +=  '<div class="form-group col-4">';
    Divdadosgerais +=    '<label for="edtHotaSistema">Hora Sistema</label>';
    Divdadosgerais +=    '<input readonly type="text" class="form-control form-control-sm" id="edtHotaSistema" aria-';   Divdadosgerais +=    'describedby="HoraSistemaPedido" value="'+arrayped["Pedido"]["horasistema"]+'">';
    Divdadosgerais  +=' </div>';
    Divdadosgerais  +=' </div>';
    
    return Divdadosgerais;
    //$('#tabItemdadosgerais').html(Divdadosgerais); 
    // 
    
}
function PreencheDadosCobranca(arrayped){
    
    
    strDiv = "";
    //Plano Pagamento
    strDiv  +='<div class="form-row">';
    strDiv +=  '<div class="form-group col">';
    strDiv +=    '<label for="edtPlanoPagto">Plano de Pagamento</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtPlanoPagto" aria-';     
    strDiv +=    'describedby="PlanoPagtoPedido" value="'+arrayped["Pedido"]["idplanopagto"]+' - '+arrayped["Pedido"]["descplanopagto"]+'">';
    strDiv +=' </div>';
    strDiv  +=' </div>';
    //Carteira
    strDiv  +='<div class="form-row">';
    strDiv +=  '<div class="form-group col">';
    strDiv +=    '<label for="edtCarteira">Carteira</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtCarteira" aria-';     
    strDiv +=    'describedby="CarteiraPedido" value="'+arrayped["Pedido"]["carteira"]+' - '+arrayped["Pedido"]["desccarteira"]+'">';
    strDiv +=' </div>';
    strDiv +=' </div>';

    //Banco
    strDiv  +='<div class="form-row">';
    strDiv +=  '<div class="form-group col">';
    strDiv +=    '<label for="edtBanco">Banco</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtBanco" aria-';     
    strDiv +=    'describedby="BancoPedido" value="'+arrayped["Pedido"]["idbanco"]+' - '+arrayped["Pedido"]["nomebanco"]+'">';
    strDiv +=' </div>';
    strDiv  +=' </div>';
    
    
    strDiv +='<div class="form-group row">';
    //Valor Documento FInanceiro
    strDiv +=  '<div class="form-group col-4 col-sm-4">';
    strDiv +=    '<label for="edtValDescFinanc" >Desconto Financeiro</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValDescFinanc" aria-';     
    strDiv +=    'describedby="EDTValDescFinanc" value="'+arrayped["Pedido"]["valdescfinanc"]+'">';
    strDiv  +=' </div>';
    
    strDiv +=  '<div class="form-group col-4 col-sm-4">';
    strDiv +=    '<label for="edtValFinanc" >Valor Doc.Financeiro</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValFinanc" aria-';     
    strDiv +=    'describedby="EDTValFinanc" value="'+arrayped["Pedido"]["valordocfinanc"]+'">';
    strDiv  +=' </div>';
    strDiv  +=' </div>';
    
    return strDiv;
    //$('#tabItemCobranca').html(strDiv); 
    
}
function PreencheDadosDestinatario(arrayped){
    
    strDiv = "";
    strDiv  +='<div class="form-row">';
    strDiv +=  '<div class="form-group col-3 col-lg-3 col-md-3">';
    strDiv +=    '<label for="edtEntidade">Entidade</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtEntidade" aria-';     
    strDiv +=    'describedby="EntidadePedido" value="'+arrayped["Pedido"]["descentidade"]+'">';
    strDiv +=' </div>';
    strDiv +=  '<div class="form-group col-12 col-lg-9 col-md-9">';
    strDiv +=    '<label for="edtIdentidade">Pessoa</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtIdentidade" aria-';     
    strDiv +=    'describedby="IdentidadePedido" value="'+arrayped["Pedido"]["identidade"]+' - '+arrayped["Pedido"]["nomedaentidade"]+'">';
    strDiv +=' </div>';
    strDiv  +=' </div>';
    
    return strDiv;
    //$('#tabItemCobranca').html(strDiv); 
    
}
function PreencheDadosValores(arrayped){
    strDiv = "";
    strDiv +='<div class="form-group row">';
    //Valor Bruto
    strDiv +=  '<div class="form-group col-4 col-sm-4">';
    strDiv +=    '<label for="edtValbruto" class ="d-none d-lg-block d-xl-block">Valor Bruto</label>';
    strDiv +=    '<label for="edtValbruto" class ="d-block d-lg-none d-xl-none">Val.Bruto</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValbruto" aria-';     
    strDiv +=    'describedby="EDTValBruto" value="'+arrayped["Pedido"]["valorbruto"]+'">';
    strDiv  +=' </div>';
    //Valor Desconto
    strDiv +=  '<div class="form-group col-4 col-sm-4">';
    strDiv +=    '<label for="edtValDesc" class ="d-none d-lg-block d-xl-block">Valor Desconto</label>';
    strDiv +=    '<label for="edtValDesc" class ="d-block d-lg-none d-xl-none">Desconto</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValDesc" aria-';     
    strDiv +=    'describedby="EDTValDesc" value="'+arrayped["Pedido"]["valordesconto"]+'">';
    strDiv  +=' </div>';
    
    
    //Valor Liquido
    strDiv +=  '<div class="form-group col-4 col-sm-4">';
    strDiv +=    '<label for="edtValLiq" class ="d-none d-lg-block d-xl-block">Valor Líquido</label>';
    strDiv +=    '<label for="edtValLiq" class ="d-block d-lg-none d-xl-none">Val.Líquido</label>';
    strDiv +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValLiq" aria-';     
    strDiv +=    'describedby="EDTValLiq" value="'+arrayped["Pedido"]["valorliquido"]+'">';
    strDiv  +=' </div>';
    strDiv  +=' </div>';
    return strDiv;
    
}
function PreencheDadosHistoricoMsg(arrayped){
    strDiv = " ";
    if ((arrayped["Pedido"]["observacaoped"] !=" ") && (arrayped["Pedido"]["observacaoped"].trim().length > 1) && (arrayped["Pedido"]["observacaoped"] != null)){
        strDiv +='<div class="form-group row p-2">';
        
        strDiv +=    '<label for="edtHistorico" class ="d-none d-lg-block d-xl-block">Histórico</label>';
        strDiv +=    '<label for="edtHistorico" class ="d-block d-lg-none d-xl-none">Histórico</label>';
        strDiv +=    '<textarea readonly class="form-control" id="edtHistorico">'+arrayped["Pedido"]["observacaoped"]+'</textarea>';
        strDiv  +=' </div>';

    }
    if ((arrayped["Pedido"]["msgfiscal"] !="") && (arrayped["Pedido"]["msgfiscal"].trim().length > 1) && (arrayped["Pedido"]["msgfiscal"] != null)){
        strDiv +='<div class="form-group row p-2">';
        MsgFiscal = (arrayped["Pedido"]["msgfiscal"]).replace('�',' ');
        
        strDiv +=    '<label for="edtMsgFiscal" class ="d-none d-lg-block d-xl-block">Msg.Fiscal</label>';
        strDiv +=    '<label for="edtMsgFiscal" class ="d-block d-lg-none d-xl-none">Msg.Fiscal</label>';
        strDiv +=    '<textarea readonly rows=5 class="form-control" id="edtMsgFiscal">'+MsgFiscal+'</textarea>';

        strDiv  +=' </div>';
    }
    
    
    return strDiv;
    
}

function MontaTabItensDetail(IdItem,IdProduto,DescProduto,PesoProd,QtdProd,ValUnt,ValorLiq,Valorbruto,ValorDesc,CFOP,NatOP,Cont){
    var Divstr = '';
    
    
    Divstr += '<div class="card border-primary border-top-0">';
    Divstr +='<div class="card-header border border-primary border-bottom-0 border-left-0 border-right-0 '+((Cont % 2 == 0 )?"bg-primary":"bg-light") +' bg-primary" id="heading'+IdItem+'">';
    Divstr +='<h6 class="mb-0">';
    Divstr +='<button id="btn'+IdItem+'" onclick="btnprod('+IdItem+');" class="btn btn-link '+((Cont % 2 == 0 )?"text-white":"text-primary") +' font-weight-normal" data-toggle="collapse" data-target="#targetitem'+IdItem+'" aria-expanded="true" aria-controls="targetitem'+IdItem+'">';
    Divstr +='<span class="glyphicon glyphicon-chevron-down"></span> Produto: '+IdProduto+' - '+DescProduto ;
    Divstr +='</button></h6></div>';
    Divstr +='<div id="targetitem'+IdItem+'" class="collapse" aria-labelledby="heading'+IdItem+'" data-parent="#accordion">';
    Divstr +='<div class="card-body">';
    //aqui
    //linha 1 Peso, Quantidade, Valor Unidade
    
    //CFOP    
    Divstr +='<div class="form-group row ">';
    Divstr +=  '<div class="form-group col-sm-12">';
    Divstr +=    '<label for="edtCFOP">CFOP</label>';
    Divstr +=    '<input readonly type="text" class="form-control form-control-sm" id="edtCFOP" aria-';     
    Divstr +=    'describedby="EDTCFOP" value="'+NatOP+'">';
    Divstr  +=' </div>';    
    Divstr  +=' </div>';    
    
    //peso
    Divstr +='<div class="form-group row">';
    //Peso
    Divstr +=  '<div class="form-group col-4 col-sm-4 ">';
    Divstr +=    '<label for="edtPeso">Peso</label>';
    Divstr +=    '<input readonly type="text" class="form-control form-control-sm" id="edtPeso" aria-'; 
    Divstr +=    'describedby="EDTPeso" value="'+PesoProd+'">';
    Divstr  +=' </div>';
    
    //quantidade
    Divstr +=  '<div class="form-group col-4 col-sm-4">';
    Divstr +=    '<label for="edtQuantidade" class ="d-none d-lg-block d-xl-block">Quantidade</label>';
    Divstr +=    '<label for="edtQuantidade" class ="d-block d-lg-none d-xl-none">Quant.</label>';
    
    Divstr +=    '<input readonly type="text" class="form-control form-control-sm" id="edtQuantidade" aria-'; 
    Divstr +=    'describedby="EDTQtd" value="'+QtdProd+'">';
    Divstr  +=' </div>';
    
    //Valor Unitario    
    Divstr +=  '<div class="form-group col-4 col-sm-4">';
    Divstr +=    '<label for="edtValUnt" class="d-none  d-lg-block d-xl-block">Valor Unitário</label>';
    Divstr +=    '<label for="edtValUnt" class="d-block d-lg-none d-xl-none"  >Val.Unt</label>';
    Divstr +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValUnt" aria-';     
    Divstr +=    'describedby="EDTValUnt" value="'+ValUnt+'">';
    Divstr  +=' </div>';
    Divstr  +=' </div>';
    
    Divstr +='<div class="form-group row">';
    //Valor Bruto
    Divstr +=  '<div class="form-group col-4 col-sm-4">';
    Divstr +=    '<label for="edtValbruto" class ="d-none d-lg-block d-xl-block">Valor Bruto</label>';
    Divstr +=    '<label for="edtValbruto" class ="d-block d-lg-none d-xl-none">Val.Bruto</label>';
    Divstr +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValbruto" aria-';     
    Divstr +=    'describedby="EDTValBruto" value="'+Valorbruto+'">';
    Divstr  +=' </div>';
    //Valor Desconto
    Divstr +=  '<div class="form-group col-4 col-sm-4">';
    Divstr +=    '<label for="edtValDesc" class ="d-none d-lg-block d-xl-block">Valor Desconto</label>';
    Divstr +=    '<label for="edtValDesc" class ="d-block d-lg-none d-xl-none">Desconto</label>';
    Divstr +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValDesc" aria-';     
    Divstr +=    'describedby="EDTValDesc" value="'+ValorDesc+'">';
    Divstr  +=' </div>';
    
    
    //Valor Liquido
    Divstr +=  '<div class="form-group col-4 col-sm-4">';
    Divstr +=    '<label for="edtValLiq" class ="d-none d-lg-block d-xl-block">Valor Líquido</label>';
    Divstr +=    '<label for="edtValLiq" class ="d-block d-lg-none d-xl-none">Val.Líquido</label>';
    Divstr +=    '<input readonly type="text" class="form-control form-control-sm" id="edtValLiq" aria-';     
    Divstr +=    'describedby="EDTValLiq" value="'+ValorLiq+'">';
    Divstr  +=' </div>';
    //Valor
    
    Divstr +='</div></div></div>';
    return Divstr; 
 
}
function btnprod(IdItem){
    
    if ($('#btn'+IdItem +' span').hasClass("glyphicon-chevron-down")) {
        $('#btn'+IdItem +' span').fadeOut(500);
        $('#btn'+IdItem +' span').removeClass("glyphicon-chevron-down"); 
        $('#btn'+IdItem +' span').addClass("glyphicon-chevron-up"); 
        $('#btn'+IdItem +' span').fadeIn(500);
    }
    else if ($('#btn'+IdItem +' span').hasClass("glyphicon-chevron-up")){
        $('#btn'+IdItem +' span').fadeOut(500);
        $('#btn'+IdItem +' span').removeClass("glyphicon-chevron-up"); 
        $('#btn'+IdItem +' span').addClass("glyphicon-chevron-down"); 
        $('#btn'+IdItem +' span').fadeIn(500);
    }
    
}

function MostraTelaPrincipal(){
    
    $('#DivNovoPedido').removeClass('d-block');
    $('#DivNovoPedido').addClass('d-none');
    
    $('#Divacaogrid').removeClass('d-block');
    $('#Divacaogrid').addClass('d-none');
    $('#DivacaoDetalhes').removeClass('d-block');
    $('#DivacaoDetalhes').addClass('d-none');
    
    $('#DivLogo').fadeIn(1000);
    $('#navbottom').removeClass('d-none');
    $('#navbottom').addClass('d-block');
    $('#navbottom').fadeIn(1000);
    
    
    
}
function ChamaModalExcluir(IdPedido,DisabledEditDel,Status,StatusFat,Acao){
    
    console.log("Aqui eu e trei"+IdPedido);
    if (DisabledEditDel){
        btn = '#ModalExcluir_'+IdPedido;
        $(btn).modal('show');
    }
    else{
        console.log("Idpedido: " +IdPedido +" Disabled: "+DisabledEditDel+ " Status"+ Status +" Status Fat: "+ StatusFat+" Acao: " +Acao);
        $('#pMSGModal').html("");
        str = "O pedido: "+IdPedido+" não pode ser "+Acao+". Encontra-se: ";
        str += (Status=="Cancelado")?"Cancelado":(StatusFat=="Sim")?"Faturado":" ";
        $('#pMSGModal').html(str);
        $('#ModalMSG').modal('show'); 
    }
}
function ChamaModalReabrir(IdPedido,Status,StatusFat,Acao){
    $('#ModalReabrir_'+IdPedido).modal('show');
}
function ChamaModalCancelar(IdPedido,DisabledEditDel,Status,StatusFat,Acao){
    //if (DisabledEditDel){
        $('#ModalCancelar_'+IdPedido).modal('show');
//    }
//    else{
    
//        $('#pMSGModal').html("");
  //      str = "O pedido: "+IdPedido+" não pode ser "+Acao+". Encontra-se: ";
    //    str += (Status=="Cancelado")?"Cancelado":(StatusFat=="Sim")?"Faturado":" ";
      //  $('#pMSGModal').html(str);
    //    $('#ModalMSG').modal('show'); 
//    }
}

function Retorna_DivModalExcluir(pIdpedido){
    idmodal = "ModalExcluir_"+pIdpedido; 
    //console.log(idmodal);
    StrDiv = "";
    StrDiv += '<div class="modal fade" id="'+idmodal+'" tabindex="-1" role="dialog" aria-labelledby="TitModalExclusao_'+pIdpedido+'" aria-hidden="true">';
    //Modal Exclusão
    StrDiv += '<div class="modal-dialog modal-dialog-centered" role="document">';
    StrDiv += '<div class="modal-content">';
    StrDiv += '<div class="modal-header">';
    StrDiv += '<h5 class="modal-title" id="TitModalExclusao_'+pIdpedido+'">Exclusão Pedido</h5>';
    StrDiv += '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
    StrDiv += '<span aria-hidden="true">&times;</span>';
    StrDiv += '</button></div>';
    StrDiv += '<div class="modal-body">Deseja Excluir o Pedido:'+pIdpedido+'</div>';
    StrDiv += '<div class="modal-footer">';
    StrDiv += '<button type="button" class="btn btn-secondary"  data-dismiss="modal">Não</button>';
    
    StrDiv += '<button onclick="BtnExcluirPedido('+pIdpedido+');" type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>';
    StrDiv += '</div></div></div></div>';
    //StrDiv +='</div>';
    return StrDiv;
}
function Retorna_DivModalCancelar(pIdpedido){
    StrDiv = "";
    StrDiv += '<div class="modal fade" id="ModalCancelar_'+pIdpedido+'" tabindex="-1" role="dialog" aria-labelledby="TitModalCancelamento" aria-hidden="true">';
    //Modal Exclusão
    StrDiv += '<div class="modal-dialog modal-dialog-centered" role="document">';
    StrDiv += '<div class="modal-content">';
    StrDiv += '<div class="modal-header">';
    StrDiv += '<h5 class="modal-title" id="TitModalCancelamento">Cancelamento do Pedido</h5>';
    StrDiv += '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
    StrDiv += '<span aria-hidden="true">&times;</span>';
    StrDiv += '</button></div>';
    StrDiv += '<div class="modal-body">Deseja Cancelar o Pedido: '+pIdpedido+'</div>';
    StrDiv += '<div class="modal-footer">';
    StrDiv += '<button type="button" class="btn btn-secondary"  data-dismiss="modal">Não</button>';
    
    StrDiv += '<button onclick="BtnCancelarPedido('+pIdpedido+');" type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>';
    StrDiv += '</div></div></div></div>';
    //StrDiv +='</div>';
    return StrDiv;
}
function Retorna_DivModalReAbrir(pIdpedido){
    StrDiv = "";
    StrDiv += '<div class="modal fade" id="ModalReabrir_'+pIdpedido+'" tabindex="-1" role="dialog" aria-labelledby="TitModalreabre" aria-hidden="true">';
    //Modal Exclusão
    StrDiv += '<div class="modal-dialog modal-dialog-centered" role="document">';
    StrDiv += '<div class="modal-content">';
    StrDiv += '<div class="modal-header">';
    StrDiv += '<h5 class="modal-title" id="TitModalreabre">Reabertura do Pedido</h5>';
    StrDiv += '<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">';
    StrDiv += '<span aria-hidden="true">&times;</span>';
    StrDiv += '</button></div>';
    StrDiv += '<div class="modal-body">Deseja Re-Abrir o Pedido: '+pIdpedido+'? </div>';
    StrDiv += '<div class="modal-footer">';
    StrDiv += '<button type="button" class="btn btn-secondary"  data-dismiss="modal">Não</button>';
    
    StrDiv += '<button onclick="BtnReAbrePedido('+pIdpedido+');" type="button" class="btn btn-primary" data-dismiss="modal">Sim</button>';
    StrDiv += '</div></div></div></div>';
    //StrDiv +='</div>';
    return StrDiv;
}

function BtnExcluirPedido(IdPedido){
    
    $.ajax({
        type:"GET",
        url:"../delete/delpedido.php?idpedido="+IdPedido,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            var strpload="Excluindo o Pedidos "+IdPedido;
            $("#pLoading").html(strpload);
                       
        },
        afterSend: function(){
            
        }
                    
    }).done( function(data){
        
                
        dadosrec = $.parseJSON(data);
        var gravou = dadosrec["gravou"];
        console.log("Excluir pedido entrei");
        $("#DivLoading").removeClass("d-block");
        $("#DivLoading").addClass("d-none");
        
        $('#pMSGModal').html("");        
        if (gravou){
            str = "O pedido: "+IdPedido+" foi Excluido com Sucesso";
            //aquiii
            CardBodyItem = "#CardBodyItem_"+IdPedido;
            $(CardBodyItem).hide();
            
            CardHeardItem ="#CardHeardItem_"+IdPedido;
            document.getElementById("CardHeardItem_"+IdPedido).remove();
            //$(CardHeardItem).remove();
        }
        else{
            str = "O pedido: "+IdPedido+" não pode ser Excluido. Aviso: "+dadosrec["msg"] ;
        }
        $('#pMSGModal').html(str);
        $('#ModalMSG').modal('show');     
                
    }).fail( function(){
        console.log("ALGO DEU ERRADO");
    }).always( function(){
        x =  document.getElementsByName("cardheaderitem").length;
        if (x==0){
            $("#DivMostraDados").addClass("d-none");
            //$("#DivMsgAlert").removeClass("d-none");
            $("#DivMsgAlert").addClass("d-block");
            var strpMsg = "Não existe mais pedidos lançados no mês logado";
                    
            $("#pMsgAlerta").html(strpMsg);
            $("#DivLoading").removeClass("d-block");
            $("#DivLoading").addClass("d-none");
        }

    });

}
function BtnReAbrePedido(IdPedido){
    $.ajax({
        type:"GET",
        url:"../edit/upstatuspedido.php?idpedido="+IdPedido+"&status=A",
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            var strpload="Reabrindo o Pedidos "+IdPedido;
            $("#pLoading").html(strpload);
                       
        },
        afterSend: function(){
            $("#DivLoading").removeClass("d-block");
            $("#DivLoading").addClass("d-none");
        
        }
                    
    }).done( function(data){
                
        dadosrec = $.parseJSON(data);
        var gravou = dadosrec["gravou"];
        $('#pMSGModal').html("");        
        if (gravou){
            str = "O pedido: "+IdPedido+" foi Re-Aberto com Sucesso";
            //aquiii
            CardBodyItem = "#CardBodyItem_"+IdPedido+" p.card-text";
            $(CardBodyItem).removeClass('text-danger');
            $(CardBodyItem).addClass('text-dark');
            CardHeardItem ="#CardHeardItem_"+IdPedido+" p.card-text" 
            $(CardHeardItem).removeClass('text-danger');
            $(CardHeardItem).addClass('text-dark');
            
            $(CardHeardItem+" label#statusped").html(" ");
            $(CardHeardItem+" label#statusped").html("Staus: Aberto");
            
            BtnCancelPed = "#CardBodyItem_"+IdPedido+" button#btncancelaped";
            BtnReAbrePed = "#CardBodyItem_"+IdPedido+" button#btnreabreped";
            console.log($(BtnReAbrePed).html() );
            $(BtnCancelPed).removeClass("d-none");
            $(BtnCancelPed).show();
            
            $(BtnReAbrePed).hide();
            $(BtnReAbrePed).addClass("d-none");
            
            //paragped = "#p"+IdPedido;
            //$(paragped).removeClass('text-dark');
            
            //$(paragped).addClass('text-danger');
            
        }
        else{
            str = "O pedido: "+IdPedido+" não pode ser ReAberto. Erro: "+dadosrec["msg"] ;
        }
        $('#pMSGModal').html(str);
        $('#ModalMSG').modal('show');     
                
    }).fail( function(){
        console.log("ALGO DEU ERRADO");
    }).always( function(){
            
    });

}
function BtnCancelarPedido(IdPedido){
    
    $.ajax({
        type:"GET",
        url:"../edit/upstatuspedido.php?idpedido="+IdPedido+"&status=C",
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            var strpload="Cancelando o Pedidos "+IdPedido;
            $("#pLoading").html(strpload);
                       
        },
        afterSend: function(){
            $("#DivLoading").removeClass("d-block");
            $("#DivLoading").addClass("d-none");
        
        }
                    
    }).done( function(data){
                
        dadosrec = $.parseJSON(data);
        var gravou = dadosrec["gravou"];
        $('#pMSGModal').html("");        
        if (gravou){
            str = "O pedido: "+IdPedido+" foi Cancelado com Sucessoooooo";
            //aquiii
            CardBodyItem = "#CardBodyItem_"+IdPedido+" p.card-text";
            $(CardBodyItem).removeClass('text-dark');
            $(CardBodyItem).addClass('text-danger');
            CardHeardItem ="#CardHeardItem_"+IdPedido+" p.card-text" 
            $(CardHeardItem).removeClass('text-dark');
            $(CardHeardItem).addClass('text-danger');
            
            $(CardHeardItem+" label#statusped").html(" ");
            $(CardHeardItem+" label#statusped").html("Status: Cancelado");
            
        
            BtnCancelPed = "#CardBodyItem_"+IdPedido+" button#btncancelaped";
            BtnReAbrePed = "#CardBodyItem_"+IdPedido+" button#btnreabreped";
            console.log($(BtnReAbrePed).html() );
            $(BtnCancelPed).hide();
            $(BtnCancelPed).removeClass("Disable");
            $(BtnReAbrePed).removeClass("d-none");
            $(BtnReAbrePed).show();
            //paragped = "#p"+IdPedido;
            //$(paragped).removeClass('text-dark');
            
            //$(paragped).addClass('text-danger');
            
        }
        else{
            str = "O pedido: "+IdPedido+" não pode ser cancelado. Erro: "+dadosrec["msg"] ;
        }
        $('#pMSGModal').html(str);
        $('#ModalMSG').modal('show');     
                
    }).fail( function(){
        console.log("ALGO DEU ERRADO");
    }).always( function(){
            
    });
    
}

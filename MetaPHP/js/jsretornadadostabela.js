function RetornaDadosDeposito(CodUnidade,edtuni,botao){
    
    arrayRetorno = new Array();
    li_uni = "";
    enumero = isNumeric(edtuni);
    setstr="idunidade="+CodUnidade+"&edtDescDep="+edtuni+"&isnumeric="+enumero;
    var dadosbtntempv=$(botao).html();
    $.ajax({
        type:"GET",
        url:"../Consultas/getdeposito.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            $(botao).html(sSppiner);
            //var strpload="Buscando Depósito referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html(dadosbtntempv);
    return arrayRetorno;
    
}
function RetornaDadosMicroConta(TpMov,edtTransFiscal,botao){
    arrayRetorno = new Array();
    li_transfiscal = "";
    enumero = isNumeric(edtTransFiscal);
    setstr="tipomov="+TpMov+"&desctransfiscal="+edtTransFiscal+"&isnumeric="+enumero;
    
    var dadosbtntempv=$(botao).html();
    
    $.ajax({
        type:"GET",
        url:"../Consultas/gettransfiscal.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            $(botao).html(sSppiner);
            //var strpload="Buscando Micro Conta Fiscal referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html(dadosbtntempv);
    return arrayRetorno;
    
}
function RetornaDadosVendedor(edtVend,botao){
    arrayRetorno = new Array();
    li_Vendedor = "";
    enumero = isNumeric(edtVend);
    var dadosbtntempv=$(botao).html();
    if (edtVend.trim().length > 0){
        setstr="campovendedor="+edtVend+"&isnumeric="+enumero;
        console.log(setstr);
        $.ajax({
        type:"GET",
        url:"../Consultas/getvendedor.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            $(botao).html(sSppiner);
            var strpload="Buscando Vendedor referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
        
    }
    $(botao).html(dadosbtntempv);
    return arrayRetorno;
    
}
function RetornaDadosProduto(edtProd,botao){
    arrayRetorno = new Array();
    li_Produto = "";
    enumero = isNumeric(edtProd);
    
    var dadosbtntempv=$(botao).html(); 
    
   setstr="campoproduto="+edtProd+"&isnumeric="+enumero;
   console.log(setstr);
    
   $.ajax({
        
        type:"GET",
        url:"../Consultas/getproduto.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            
            $(botao).html(sSppiner);
            //var strpload="Buscando Produto referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html('<span class="glyphicon glyphicon-search"></span>');
    return arrayRetorno;
    
}
function RetornaDadosCFOP(edtCFOP,botao){
    arrayRetorno = new Array();
    li_CFOP = "";
    enumero = isNumeric(edtCFOP);
   
   setstr="campoCFOP="+edtCFOP+"&isnumeric="+enumero;
   console.log(setstr);
    
   var dadosbtntempv=$(botao).html(); 
    
   $.ajax({
        
        type:"GET",
        url:"../Consultas/getcfop.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            var strpload="Buscando CFOP referente a pesquisa";
            $(botao).html(sSppiner);
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
            
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html(dadosbtntempv);
    return arrayRetorno;
    
}
function RetornaResultadoAddItem(arrayitem){
    arrayRetorno = new Array();
    $.ajax({
        
        type:"POST",
        url:"../insert/setcarrinho.php",
        data: {Item:arrayitem},
        cache: false,
        processData:true,
       beforeSend: function(){
            console.log("to aqui no ajax");
            var strpload="Buscando CFOP referente a pesquisa";
        },
        afterSend: function(){
        }
       
                    
        }).done( function(data){
            
            arrayRetorno = $.parseJSON(data);
            var arraycarrinho = arrayRetorno["carrinho"];
            arraytotais = arrayRetorno["totais"];
            contitens = arrayRetorno["contadoritens"];
            
            arraycarrinho["totais"] = arraytotais;
            arraycarrinho["contitens"] = contitens;
       
            return arraycarrinho;
       
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            return null;
            
        });
}
function RetornaDadosEntidade(edtEntidade,cbIndexEntidade){
    arrayRetorno = new Array();

    enumero = isNumeric(edtEntidade);
    if (edtEntidade.trim().length > 0){
        setstr="campoentidade="+edtEntidade+'&entidade='+cbIndexEntidade+"&isnumeric="+enumero;
        console.log(setstr);
        $.ajax({
        type:"GET",
        url:"../Consultas/getentidade.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            var strpload="Buscando Entidade referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
        
    }

    return arrayRetorno;
    
    
}
function RetornaDadosVeiculo(edtveiculo,botao){
    arrayRetorno = new Array();
    
    enumero = isNumeric(edtveiculo);
    
    var dadosbtntempv=$(botao).html(); 
    
    setstr="campoveiculo="+edtveiculo+"&isnumeric="+enumero;
    console.log(setstr);
    
    $.ajax({
        
        type:"GET",
        url:"../Consultas/getveiculo.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            
            $(botao).html(sSppiner);
            //var strpload="Buscando Produto referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html('<span class="glyphicon glyphicon-search"></span>');
    return arrayRetorno;

}
function RetornaDadosTransportador(edttransportador,botao){
    arrayRetorno = new Array();
    
    enumero = isNumeric(edttransportador);
    
    var dadosbtntempv=$(botao).html(); 
    
    setstr="campotransportador="+edttransportador+"&isnumeric="+enumero;
    console.log(setstr);
    
    $.ajax({
        
        type:"GET",
        url:"../Consultas/gettransportador.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            
            $(botao).html(sSppiner);
            //var strpload="Buscando Produto referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html('<span class="glyphicon glyphicon-search"></span>');
    return arrayRetorno;

}
function RetornaDadosEndereco(edtendereco,idpessoa,botao){
    arrayRetorno = new Array();
    
    enumero = isNumeric(edtendereco);
    
    var dadosbtntempv=$(botao).html(); 
    
    setstr="campoendereco="+edtendereco+"&idpessoa="+idpessoa+"&isnumeric="+enumero;
    console.log(setstr);
    
    $.ajax({
        
        type:"GET",
        url:"../Consultas/getendereco.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            
            $(botao).html(sSppiner);
            //var strpload="Buscando Produto referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html('<span class="glyphicon glyphicon-search"></span>');
    return arrayRetorno;

}
function RetornaDadosPortador(edtportador,botao){
    arrayRetorno = new Array();
    
    enumero = isNumeric(edtportador);
    
    var dadosbtntempv=$(botao).html(); 
    
    setstr="campoportador="+edtportador+"&isnumeric="+enumero;
    console.log(setstr);
    
    $.ajax({
        
        type:"GET",
        url:"../Consultas/getportador.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            
            $(botao).html(sSppiner);
            //var strpload="Buscando Produto referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html('<span class="glyphicon glyphicon-search"></span>');
    return arrayRetorno;

}
function RetornaDadosPlanoPagto(edtplanopagto,botao){
    arrayRetorno = new Array();
    
    enumero = isNumeric(edtplanopagto);
    
    var dadosbtntempv=$(botao).html(); 
    
    setstr="campoplanopagto="+edtplanopagto+"&isnumeric="+enumero;
    console.log(setstr);
    
    $.ajax({
        
        type:"GET",
        url:"../Consultas/getplanopagto.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            
            $(botao).html(sSppiner);
            //var strpload="Buscando Produto referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html('<span class="glyphicon glyphicon-search"></span>');
    return arrayRetorno;

}
function RetornaDadosCarteira(edtcarteira,botao){
    arrayRetorno = new Array();
    
    enumero = isNumeric(edtcarteira);
    
    var dadosbtntempv=$(botao).html(); 
    
    setstr="campocarteira="+edtcarteira.toUpperCase()+"&isnumeric="+enumero;
    console.log(setstr);
    
    $.ajax({
        
        type:"GET",
        url:"../Consultas/getcarteira.php?"+setstr,
        cache: false,
        contentType: false,
        processData: false,
        async:false,
        beforeSend: function(){
            
            $(botao).html(sSppiner);
            //var strpload="Buscando Produto referente a pesquisa";
        },
        afterSend: function(){
        }
                    
        }).done( function(data){
            arrayRetorno = $.parseJSON(data);
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
            
        });
    $(botao).html('<span class="glyphicon glyphicon-search"></span>');
    return arrayRetorno;

}
function RetornaPrecoProduto(aPesqProd,campoinput){
    console.log(aPesqProd);
    $.ajax({
        
        type:"POST",
        url:"../Consultas/getprecoproduto.php",
        data: {adados:aPesqProd},
        cache: false,
        processData:true,
       beforeSend: function(){
            
        },
        afterSend: function(){
        }
       
                    
        }).done( function(data){
            
            arrayRetorno = $.parseJSON(data);
            if (arrayRetorno["achou"]==true){
                $(campoinput).val(arrayRetorno["preco"]);
                console.log(arrayRetorno);
            }
            else{
                $(campoinput).val(0);
            }
       
        }).fail( function(){
        console.log("ALGO DEU ERRADO");
        }).always( function(){
        });
}




function RetornaFormataDataToFB(CampoDT){
    console.log($(CampoDT).val());
    dataped = new Date($(CampoDT).val());
    
    dataped.setDate((dataped.getDate()+1));

    
    dia = ("0" + (dataped.getDate())).slice(-2); 
    mes = ("0" + (dataped.getMonth()+1)).slice(-2);
    ano = dataped.getFullYear();
    retorno = (dia+'.'+mes+'.'+ano);         
    return retorno; 
            
}
function IsVazio(Obj){
    var isEmpty = true;
 
    for (var i in Obj) {
        if(Obj.hasOwnProperty(i)) {
            isEmpty = false;
            break;
        }
    }
    return isEmpty;
}

function isNumeric(str)
{
  var er = /^[0-9]+$/;
  return (er.test(str));
}


function RetornaNomeEntidade(identidade){
    var strentidade = "";
    
    switch(identidade)
    {
        case 0:
            strentidade = "Cliente";
            break;
        case 1:
            strentidade = "Fornecedor";
            break;
        case 2:
            strentidade = "Produtor Rural";
            break;
        case 3:
            strentidade = "Vendedor";
            break;
        case 4:
            strentidade = "Funcionário";
            break;
        case 5:
            strentidade = "Representante";
            break;
        case 6:
            strentidade = "Carreteiro";
            break;
        case 7:
            strentidade = "Promotor";
            break;
        case 8:
            strentidade = "Transportador";
            break;
        case 9:
            strentidade = "Departamento";
            break;
        case "10":
            strentidade = "Unidade";
            break;
        default: 
            strentidade = "Rony";
    }
    
    return strentidade;
}

function TamanhoTela(){
    var larguratela  = window.innerWidth;
    var alturatela   = window.innerHeight;
    
}

function SomenteNumero(e){
            var tecla=(window.event)?event.keyCode:e.which;   
            if((tecla>47 && tecla<58)) return true;
            else{
                if (tecla==8 || tecla==0) return true;
            else  return false;
            }
        }

function arredondarN(numero, casasDecimais) {
  casasDecimais = typeof casasDecimais !== 'undefined' ?  casasDecimais : 2;
  return +(Math.floor(numero + ('e+' + casasDecimais)) + ('e-' + casasDecimais));
}



function loadDatas(_ID) {
    // body...
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10){
        dd='0'+dd;
    } 
    if(mm<10){
        mm='0'+mm;
    } 

    today = yyyy+'-'+mm+'-'+dd;  
    document.getElementById(_ID).Valuess =today+"";
}

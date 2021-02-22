

$('#login-form').submit( function(e){
    e.preventDefault();
    fazerlogin();
});
$('#register-form').submit( function(e){
    e.preventDefault();
    registracliente();
});
        
$('#login-form-link').click(function(e) {
    e.preventDefault();
	$("#login-form").delay(100).fadeIn(100);
    $("#register-form").fadeOut(100);
    $('#register-form-link').removeClass('active');
    $(this).addClass('active');
            
});
$('#register-form-link').click(function(e) {
    e.preventDefault();
    $("#register-form").delay(100).fadeIn(100);
    $("#login-form").fadeOut(100);
    $('#login-form-link').removeClass('active');
    $(this).addClass('active');
});
    
function fazerlogin() {
    console.log("Entrei fazer");            
    if (($('#cbunidade').val() != "0") && 
        ($('#edtsenha').val() != "") && 
        ($('#cbusuario').val() != "0")) 
    {  
        var idunidade =  $('#cbunidade').val();
        var Descunidade = $('#cbunidade option:selected').text();
        var idusuario =  $('#cbusuario').val();
        var nomeusuario = $('#cbusuario option:selected').text();
        var senha = $('#edtsenha').val();
        console.log(idunidade +" - "+ Descunidade);
        console.log(idusuario +" - "+ nomeusuario);
        console.log("Senha: "+ senha);
        
                
        $.ajax({
            type:"GET",
            url:"Fontes/Consultas/loginuser.php?edtusuario="+nomeusuario+"&edtsenha="+senha+"&idunidade="+idunidade+"&descunidade="+Descunidade,
            cache: false,
            contentType: false,
            processData: false,
            async:false,
            beforeSend: function(){
            //var imgload = document.getElementById('imgcarregamento');
            //$("").text("Carregando...")
            $("#imgcarregamento").show();
                        
            }
                    
        }).done( function(data){
            var dadosrec = $.parseJSON(data);
            var $msgsucesso  = dadosrec["sucesso"];
            var $nomecliente = dadosrec["Usuario"]["nome"];
            var $codcliente  = dadosrec["Usuario"]["id"];
            console.log("Sucesso?: "+$msgsucesso);
            console.log("Usuario: "+$nomecliente);
            console.log(dadosrec);
            
            if (($msgsucesso == true)) {
                $('#divmsgsucesslogin').removeClass('d-none');
                var $shtm = ""; 
                $shtm = '<strong>Sucesso!!!</strong> Seja Bem-Vindo, '+$nomecliente+' !!!';
                $shtm +='<button type="button" class="close" data-dismiss="alert"  aria-label="Close">';
                $shtm +='<span aria-hidden="true">&times;</span></button>';
                $('#msgsucess-login').html($shtm);
                $('#divmsgsucesslogin').delay(1000).fadeOut(1000);
                
                            
                setTimeout(function(){
                    console.log("Entrou aqui");
                    $('#divmsgsucesslogin').addClass('d-none');
                    $('#divmsgsucesslogin').delay(1000).fadeIn(2000);
                    window.location.href ="http://siscontrolrm.dyndns.org/MetaPHP/Fontes/telas/telaprincipal.php";
                }, 2000);
            }
            else{
                $('#divmsgerrologin').removeClass('d-none');
                var $shtm = ""; 
                $shtm = '<strong>Erro!!!</strong> Usuário ou Senha Inválido';
                //$shtm +='<button type="button" class="close" data-dismiss="alert"  aria-label="Close">';
                //$shtm +='<span aria-hidden="true">&times;</span></button>';
                $('#msgerro-login').html($shtm);
                $('#divmsgerrologin').delay(500).fadeOut(1000);
                setTimeout(function(){
                    console.log("Entrou aqui");
                    $('#edtusuario').val(""); 
                    $('#edtsenha').val("");
                    $('#divmsgerrologin').addClass('d-none');
                    $('#divmsgerrologin').delay(500).fadeIn(1000);
                }, 1000);
                            
            }
                        
        }).fail( function(){
            console.log("ALGO DEU ERRADO");
        }).always( function(){
            var imgload = document.getElementById('imgcarregamento');
            imgload.style.display = 'none';
        });
    }
    else
    {
        
        if($('#cbunidade').val() == "0")
        {
            console.log("Entrei na unidade");
            $('#divmsgerrologin').removeClass('d-none');
            var $shtm = ""; 
            $shtm = '<strong>Erro!!!</strong> Forneça a Unidade';
            
            $('#msgerro-login').html($shtm);
            $('#divmsgerrologin').delay(1000).fadeOut(1000);
            
            setTimeout(function()
            {
                $('#divmsgerrologin').addClass('d-none');
                $('#divmsgerrologin').delay(1000).fadeIn(1500);
            }, 1000);
        }
        else 
        {
            
            if($('#cbusuario').val() == "0")
            {
                $('#divmsgerrologin').removeClass('d-none');
                var $shtm = ""; 
                $shtm = '<strong>Erro!!!</strong> Forneça o Usuário';
            
                $('#msgerro-login').html($shtm);
                $('#divmsgerrologin').delay(500).fadeIn(1500);
            
                setTimeout(function()
                {
                    $('#divmsgerrologin').addClass('d-none');
                    $('#divmsgerrologin').fadeOut(1500);
                }, 2000);
            }
            
        }
    }
}
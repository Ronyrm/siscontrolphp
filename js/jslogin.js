function fazerlogin() {
                
    if (($('#edtusuario').val() != "") && ($('#edtsenha').val() != "")) {  
        console.log(document.getElementById('btnlogin').disabled); 
        //$('#divmsgsucesslogin').removeClass('d-none');
        //$("#divmsgsucesslogin").fadeOut(1000);
                
        $.ajax({
            type:"POST",
            url:"logar.php",
            data: new FormData($('#login-form')[0]),
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
            var $msgsucesso  = dadosrec[1]["sucesso"];
            var $nomecliente = dadosrec[0]["nomecliente"];
            var $codcliente  = dadosrec[0]["codcliente"];
            console.log(dadosrec);
            
            if ($msgsucesso == true){
                $('#divmsgsucesslogin').removeClass('d-none');
                var $shtm = ""; 
                $shtm = '<strong>Sucesso!!!</strong> Seja Bem-Vindo, '+$nomecliente+' !!! Boas Compras!';
                $shtm +='<button type="button" class="close" data-dismiss="alert"  aria-label="Close">';
                $shtm +='<span aria-hidden="true">&times;</span></button>';
                $('#msgsucess-login').html($shtm);
                $('#divmsgsucesslogin').delay(1000).fadeOut(1000);
                console.log($nomecliente);
                            
                setTimeout(function(){
                    console.log("Entrou aqui");
                    $('#divmsgsucesslogin').addClass('d-none');
                    $('#divmsgsucesslogin').delay(1000).fadeIn(2000);
                    window.location.href ="../index.php";
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
}
function registracliente(){
    if (($('#edtclientereg').val() != "") && ($('#edtsenhareg').val() != "")&& 
        ($('#edtemailreg').val() != "") && ($('#edtconfirmasenhareg').val() != "")){ 
        
        $.ajax({
            type:"POST",
            url:"regcliente.php",
            data: new FormData($('#register-form')[0]),
            cache: false,
            contentType: false,
            processData: false,
            async:false,
            beforeSend: function(){
            //var imgload = document.getElementById('imgcarregamento');
            //$("").text("Carregando...")
            //$("#imgcarregamento").show();
            }
        }).done( function(data){
            var dadosrec = $.parseJSON(data);
            var $sucesso  = dadosrec["sucesso"];
            var $mensagem = dadosrec["mensagem"];
            if ($sucesso == true) {
                 
                $('#divmsgsucessreg').removeClass('d-none');
                var $shtm = ""; 
                $shtm = '<strong>Sucesso!!!</strong> '+$mensagem;
                $shtm +='<button type="button" class="close" data-dismiss="alert"  aria-label="Close">';
                $shtm +='<span aria-hidden="true">&times;</span></button>';
                $('#msgsucess-reg').html($shtm);
                $('#divmsgsucessreg').delay(1000).fadeOut(1000);
                            
                setTimeout(function(){
                    console.log("Entrou aquiOOO");
                    $('#divmsgsucessreg').addClass('d-none');
                    $('#divmsgsucessreg').delay(1000).fadeIn(2000);
                    window.location.href ="loginuser.php";
                }, 2000);
            }
            else{
                $('#divmsgerroreg').removeClass('d-none');
                var $shtm = ""; 
                $shtm = "<strong>"+$mensagem+"</strong>";
                //$shtm +='<button type="button" class="close" data-dismiss="alert"  aria-label="Close">';
                //$shtm +='<span aria-hidden="true">&times;</span></button>';
                $('#msgerro-reg').html($shtm);
                $('#divmsgerroreg').delay(1000).fadeOut(5000);
                setTimeout(function(){
                    console.log("Entrou aqui");
                    $('#edtusuario').val(""); 
                    $('#edtsenha').val("");
                    $('#divmsgerroreg').addClass('d-none');
                    $('#divmsgerroreg').delay(1000).fadeIn(1000);
                }, 3000);
                            
            }    
                        
        }).fail( function(){
                        
        }).always( function(){
            //var imgload = document.getElementById('imgcarregamento');
            //imgload.style.display = 'none';
        });
    }
}

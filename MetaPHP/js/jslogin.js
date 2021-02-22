function fazerlogin() {
    console.log("entrei aqui");  
    
    
    var nomeUser = $('#cbusuario option:selected').text();
    var iduser = $('#cbusuario option:selected').val();
    //unidade
    var nomeuni = $('#cbunidade option:selected').text();
    var iduni = $('#cbunidade option:selected').val();
    //senha
    var senha = $('#edtsenha').val();
    console.log(iduni);  
    console.log(iduser);  
    console.log(senha);  
    
    if (( iduser!= "0" ) && 
        ( iduni != "0") &&
        ( senha != "") ) 
         
    {  
        console.log(document.getElementById('btnlogin').disabled); 
        //$('#divmsgsucesslogin').removeClass('d-none');
        //$("#divmsgsucesslogin").fadeOut(1000);
        
        //usuario
        
        
        $.ajax({
            type:"GET",
            url:"Fontes/Consultas/loginuser.php?edtusuario="+nomeUser+"&edtsenha="+senha+"&idunidade="+iduni+"&descunidade="+nomeuni,
            cache: false,
            contentType: false,
            processData: true,
            async:false,
            beforeSend: function(){
                var imgload = document.getElementById('imgcarregamento');
                imgload.style.display = 'block';
                //var imgload = document.getElementById('imgcarregamento');
                //$("").text("Carregando...")
                $("#imgcarregamento").show();
                        
            }
                    
        }).done( function(data){
            var dadosrec = $.parseJSON(data);
            var msgsucesso  = dadosrec["sucesso"];
            var nomeuser = dadosrec["Usuario"]["nome"];
            var coduser  = dadosrec["Usuario"]["id"];
            console.log(dadosrec);
            
            if ((msgsucesso == true) ) {
                $('#divmsgsucesslogin').removeClass('d-none');
                var $shtm = ""; 
                $shtm = '<strong>Sucesso!!!</strong> Seja Bem-Vindo, '+nomeuser;
                $shtm +='<button type="button" class="close" data-dismiss="alert"  aria-label="Close">';
                $shtm +='<span aria-hidden="true">&times;</span></button>';
                $('#msgsucess-login').html($shtm);
                $('#divmsgsucesslogin').delay(1000).fadeOut(1000);
                console.log(nomeuser);
                            
                setTimeout(function(){
                    console.log("Entrou aqui");
                    $('#divmsgsucesslogin').addClass('d-none');
                    $('#divmsgsucesslogin').delay(1000).fadeIn(2000);
                    window.location.href ="Fontes/telas/telaprincipal.php";
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
    else{
        if(iduser=="0"){
            $('#divmsgerrologin').removeClass('d-none');
                var $shtm = ""; 
                $shtm = '<strong>Aviso!</strong> Forneça o Usuário ';
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
        else{
            if(iduni=="0"){
                $('#divmsgerrologin').removeClass('d-none');
                var $shtm = ""; 
                $shtm = '<strong>Aviso!!!</strong> Forneça a Unidade!';
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
        }
        
    }
        
}
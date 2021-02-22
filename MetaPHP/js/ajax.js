/**
  * Função para criar um objeto XMLHTTPRequest
  */

 function VerificaEmailCadastrado(){
     var strEmail   = document.getElementById("emailusuario").value;
     var result     = document.getElementById("msgdiv-email");
     var Emailscad   = document.getElementById("tempemail");
      
     $.ajax(
            {type:'GET',
             url:'../fontes/verificaemailcadastrado.php',
             data:"emailuser="+strEmail,
             async:false
            }).done(function(data){
                $qtdemailcad = $.parseJSON(data)["qtdemailcad"];
                $msgInfo     = $.parseJSON(data)["msgInfo"];
                Emailscad.value = $qtdemailcad;
                if ($qtdemailcad > 0){
                    
                    
                    result.innerHTML = "Email ja cadastrado no Sistema"; 
                }
                else{                
    
                    result.innerHTML = "";
                    
                }
                    
            }).fail(function(){
                    
            }).always(function(){
         
            })
        
     
 }

 function CriaRequest() {
     try{
         request = new XMLHttpRequest();        
     }catch (IEAtual){
          
         try{
             request = new ActiveXObject("Msxml2.XMLHTTP");       
         }catch(IEAntigo){
          
             try{
                 request = new ActiveXObject("Microsoft.XMLHTTP");          
             }catch(falha){
                 request = false;
             }
         }
     }
      
     if (!request) 
         alert("Seu Navegador não suporta Ajax!");
     else
         return request;
 }
  
 /**
  * Função para enviar os dados
  */
 function verificaemails() {
      
     // Declaração de Variáveis
     var nome   = document.getElementById("emailusuario").value;
     var result         = document.getElementById("msgdiv-email");
     var campoemailtemp = document.getElementById("tempemail"); 
     var xmlreq = CriaRequest();
      
     // Exibi a imagem de progresso
     //result.innerHTML = '<img src="Progresso1.gif"/>';
      
     // Iniciar uma requisição
     xmlreq.open("GET", "verificaemailcadastrado.php?emailuser=" + nome, true);
      
     // Atribui uma função para ser executada sempre que houver uma mudança de ado
     xmlreq.onreadystatechange = function(){
          
         // Verifica se foi concluído com sucesso e a conexão fechada (readyState=4)
         if (xmlreq.readyState == 4) {
              
             // Verifica se o arquivo foi encontrado com sucesso
             if (xmlreq.status == 200) {
                 result.innerHTML = xmlreq.responseText;
             }else{
                 result.innerHTML = "Erro: " + xmlreq.statusText;
             }
         }
     };
     xmlreq.send(null);
 }
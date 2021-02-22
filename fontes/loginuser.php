<?php   
    require_once("../conexao/conn.php");
    mysqli_close($conn);
    session_start();

    
?>


<html>
    
   <head>
        <?php include_once("head.php"); ?>
        <link href="/css/logincss.css" rel="stylesheet">
        <link href="/css/cabecalho.css" rel="stylesheet">
    
        <style>
            #navprincipal {
                width:75%;
                margin:10px auto;
                box-shadow:0 0 10px #999999;
                background-color:rgb(255,255,255);
                font-size:13px;
                
            }
        </style>
    </head>
<body>
<main>
    <nav id="MenuBar" class="navbar navbar-expand-lg navbar-dark bg-padrao" id="navprincipaddl">
        <div class="container-fluid">    
            <a class="navbar-brand " href="../Index.php">
                <img  src="/fontes/img/logo2.png" 
                style=" widht:30px; height:30px; margin-left:0px"     alt=""> SisControlRM-Stok
            </a>
        </div>    
    </nav>
    <div class="container" id="divLogin">
        <div class="row">
            <div class="col-md-3">
            
            </div>
            <div class="col-md-6 bg-negro" id="divprincipal">
                <div class="panel panel-login bg-padrao">
				    <div class="panel-heading">
                        <div class="row my-4">
                            <div class="col-md-6 ">
				                <a href="#" class="btn btn-outline-padrao btn-block active" id="login-form-link">Login</a>
						    </div>
                            <div class="col-md-6">
				                <a href="#" class="btn btn-outline-padrao btn-block btn-sm" id="register-form-link">Registrar</a>
						    </div>
                        
					    </div>
					   <div class="panel-body" style="border:1px;">
						<div class="row">
							<div class="container-fluid">
								<form id="login-form" class="was-validated mx-4" data-toggle="validator"  >
									<div class="form-group">
										<input type="text" name="edtusuario" id="edtusuario" tabindex="1" class="form-control" placeholder="Usuário" value="" required>
                                        <div class="invalid-feedback font-weight-bold">Forneça o Email</div>
									</div>
									<div class="form-group">
										<input type="password" name="edtsenha" id="edtsenha" tabindex="2" class="form-control" placeholder="Senha" required>
                                        <div class="invalid-feedback font-weight-bold">Forneça a Senha</div>
									</div>
									<div class="form-group text-center">
										<input type="checkbox" tabindex="3" class="" name="lembrarme" id="lembrame">
										<label class="text-white" for="remember"> Lembrar-me</label>
									</div>
									<div class="form-group">
										<div class="row">
                                            
											<div class="col-sm-12">
                                                
                                                <button type="submit" name="btnlogin" id="btnlogin" tabindex="4"  class="btn btn-primary disabled">
                                                <strong><img id="imgcarregamento" style="width: 20px;height: 20; display: none;"      src="img/33.gif"></strong>
                                                Entrar</button>
											</div>
										</div>
									</div>
            
									<div class="form-group">
										<div class="row">
											<div class="col-lg-12">
												<div class="text-center">
													<a href="https://phpoll.com/recover" tabindex="5" class="forgot-password">Esqueceu a Senha?</a>
												</div>
											</div>
                                            
                                            
                                            <div id="divmsgsucesslogin" class="col-lg-12 d-none">
                                                <div  class="alert alert-primary alert-dismissible fade show" role="alert" id="msgsucess-login">
                                                
                                                    
                                                </div>
                                            </div>
                                            
                                            <div id="divmsgerrologin" class="col-lg-12 d-none">
                                                <div  class="alert alert-danger alert-dismissible fade show" role="alert" id="msgerro-login">
                                                
                                                    
                                                </div>
                                            </div>
										</div>
									</div>
                                    <div class="form-group">
										<div class="row">
                                    
                                            <input type="hidden" id="panelidlogin" name="panelid" value="1">
                                        </div>
                                    </div>
								</form>
                                
                                <!-- Registrar  oninvalid="this.setCustomValidity('Campo em Branco -->
								<form id="register-form" class="was-validated mx-4" data-toggle="validator"  style="display: none;">
									<div class="form-group">
										<input type="text" name="edtclientereg" id="edtclientereg" tabindex="1" class="form-control" placeholder="Usuário" value="" required>
									</div>
									<div class="form-group">
										<input type="email" name="edtemailreg" id="edtemailreg" tabindex="2" class="form-control" placeholder="Email" type="email" data-error="Por favor, informe um e-mail correto." value="" required>
										<div class="help-block with-errors text-white"></div>
                                        
									</div>
									<div class="form-group">
										<input type="password" name="edtsenhareg" id="edtsenhareg" tabindex="3" class="form-control" placeholder="Senha" required>
									</div>
									<div class="form-group">
										<input type="password" name="edtconfirmasenhareg" id="edtconfirmasenhareg" tabindex="4" class="form-control" placeholder="Confirmar Senha" data-match="#edtsenhareg" data-match-error="Atenção! As senhas não estão iguais." required>	    
                                        <div class="help-block with-errors text-white"></div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-12">
												<input type="submit" name="btnregistra" id="btnregistra" tabindex="5" class=" btn btn-primary" value="Registar Agora">
											</div>
										</div>
									</div>
                                    
                                    <div class="form-group">
										<div class="row">
                                    
                                            <input type="hidden" id="panelidreg" name="panelid" value="2">
                                        </div>
                                        <div id="divmsgsucessreg" class="col-lg-12 d-none">
                                                <div  class="alert alert-primary alert-dismissible fade show" role="alert" id="msgsucess-reg">
                                                
                                                    
                                                </div>
                                        </div>
                                           
                                        <div id="divmsgerroreg" class="col-lg-12 d-none">
                                                <div  class="alert alert-danger alert-dismissible fade show" role="alert" id="msgerro-reg">
                                                
                                                    
                                                </div>
                                        </div>
                                    </div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="col-md-3">
            
            </div>    
		</div>
	</div>
</main>
    <script>
    <?php include "../js/jslogin.js";  ?>
    </script>
    <script>
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
    
    
    </script>
    
    <script src="../js/validator.js"></script>
    <script src="../js/validator.min.js"></script>
    
    
            
</body>
</html>



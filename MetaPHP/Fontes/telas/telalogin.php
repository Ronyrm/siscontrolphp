<?php
    include_once("./connDB.php");
    $SqlStr = "SELECT * FROM TBUSUARIO";
    $consulta   = fbird_query($dbh,$SqlStr);
    
    if ($consulta)
    {
        $option_user = ""; 
        $cont = 0;
        while ($linha = fbird_fetch_object($consulta))
        {
            $option_user .="<option value=".$linha->DFIDUSUARIO.">".$linha->DFLOGINUSUARIO."</option>";
        }
    }
    fbird_free_result($consulta);
    $SqlStr =  "SELECT UN.dfidunidade, UN.dfrazsocunidade,pe.dfnomefantasia";
    $SqlStr .= " FROM tbunidade UN left join tbpessoa pe on un.dfidpessoa = pe.dfidpessoa";
    $SqlStr .= " WHERE UN.dfidgrau3='000' AND UN.dfidgrau2<>'000' AND UN.dfidgrau1<>'000'";

    $consulta   = fbird_query($dbh,$SqlStr);
    if ($consulta)
    {
        $option_uni = ""; 
        $cont = 0;
        while ($linha = fbird_fetch_object($consulta))
        {
            $option_uni .="<option value=".$linha->DFIDUNIDADE.">".$linha->DFNOMEFANTASIA."</option>";
        }
    }
    fbird_free_result($consulta); 


    fbird_close($dbh);
?>
<div class="container" id="divLogin">
    <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6 bg-padrao" id="divprincipalLogin">
            <div class="panel panel-login">
                <div class="panel-heading">
                    <div class="row my-4">
                        <!-- Form Login -->
                        <div class="col-md-12 ">
                            <a href="#" class="btn btn-outline-padrao btn-block active" id="login-form-link">Login</a>
                        </div>
                        
                    </div>
					<div class="panel-body" style="border:1px;">
					   <div class="row">
				            <div class="container-fluid">
								
                                <form id="login-form" class="was-validated mx-4" data-toggle="validator"  >
                                    <div class="form-group">
                                        <div class="row">
                                            <input hidden name="idunidade_sel"  tabindex="1" for="cbunidade"/>
                                            <div class="col-md-12">
                                                <select class="form-control" name="cbunidade" id="cbunidade">
                                                    <option value="0">Selecione a Unidade</option>
                                                    <?php echo $option_uni ?>
                                                </select> 
                                            </div>
										
                                        </div>
									</div>
									<div class="form-group">
                                        <div class="row">
                                            <input hidden  name="iduser_sel"  tabindex="2" for="cbusuario"/>
                                            <div class="col-md-12">
                                                <select class="form-control" id="cbusuario" name="cbusuario">
                                                    <option value="0">Selecione o Usuário</option>
                                                    <?php echo $option_user ?>
                                                </select> 
                                            </div>
										
                                        </div>
									</div>
									<div class="form-group">
										<input type="password" name="edtsenha" id="edtsenha" tabindex="3" class="form-control" placeholder="Senha" required>
                                        <div class="invalid-feedback font-weight-bold">Forneça a Senha</div>
									</div>
									
									<div class="form-group">
										<div class="row">
                                			<div class="col-sm-12">
                                                <button type="submit" name="btnlogin" id="btnlogin" tabindex="4"  class="btn border border-white btn-primary disabled">
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
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="col-md-3">
            
            </div>    
		</div>
	</div>
<script>
    <?php include "js/jslogin.js";  ?>
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
<script src="scripts/validator.js"></script>
<script src="scripts/validator.min.js"></script>    
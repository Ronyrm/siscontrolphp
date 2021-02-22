<?php
    if (isset($_SESSION["nomeusuario"])){
        $userlogado = true;
        $nomeuser = $_SESSION["nomeusuario"];
    }
    else {
        $userlogado = false;
    }
?>

    
    <nav class="navbar navbar-expand-lg  bg-padrao">
        <a class="navbar-brand text-white"  href="#" id="btnindex" onclick="retornatelaindex();">
                        <img  src="../../img/logometa2.png" 
                        style=" widht:100px; height:40px; margin-left:0px" alt="">
        </a>
        <?php 
            if ($userlogado)
            {?>
                <ul class="navbar-nav mr-auto">
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo "Olá ".$nomeuser.", Seja Bem-Vindo!" ?>
                        </a>
                        <div class="justify-content-center dropdown-menu px-2 "  aria-labelledby="navbarDropdown">
                          <button type="button" class="btn btn-outline-primary dropdown-item" onclick="Logout();" href="#">Sair</button>
                        </div>
                    </li>
                </ul>
                
            <?php
            }
            ?>
        
    </nav>
<script>
    function Logout() {
        window.location.href ="../../logout.php";
    }
</script>
<?php   
   
    session_start();
    if (isset($_POST["id"]))
    {
        unset($_SESSION["carrinho"]);
        unset($_SESSION["totais"]);
        unset($_SESSION["contadoritens"]);
        echo "SIM";
    }
    else
    {
        echo "NÃO";
    }

?>
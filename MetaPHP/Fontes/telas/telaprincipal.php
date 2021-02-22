<?php

    include_once("../../connDB.php");
    include_once("../../capturadadoslogado.php");
    
    $SqlStr = "SELECT * FROM TBMODULO where  ((NOT DFCARACMODULO IS NULL OR DFMOSTRANAWEB='S' ) ) AND IIF(DFMOSTRANAWEB IS NULL,'S',DFMOSTRANAWEB)<>'N'";
    $consulta   = fbird_query($dbh,$SqlStr);
    
    if ($consulta)
    {
        
        $divmodulosPai = '<div class="row d-flex justify-content-center my-2">'; 
        $divmodulosFilho = "";
        $divmodulo =""; 
        
        $cont = 1;
        while ($linha = fbird_fetch_object($consulta))
        {
            $modulo = "'".utf8_encode($linha->DFNOMEMODULO)."'";
            $divmodulosFilho .= '<button  onclick="IrModulo('.$modulo.');" type="button" class="btnmodulo" data-toggle="tooltip" data-placement="top" title="'.utf8_encode($linha->DFCARACMODULO).'">'.$linha->DFNOMEMODULO.'</button>';
             
            if($cont == 3)
            {
                 
                $divmodulo .=$divmodulosPai.$divmodulosFilho."</div>";
                $divmodulosFilho = "";
                $cont=1;
            }
            else{$cont=$cont+1;}
        }
        $divmodulo .=$divmodulosPai.$divmodulosFilho."</div>";
        
    }
    fbird_free_result($consulta);
    
?>

<html>
<head>
    <?php include_once("../corpopag/head.html"); ?>
    <style>
        <?php include_once("../../css/cabecalho.css"); ?>
        <?php include_once("../../css/telaprincipal.css"); ?>
    </style>
    
</head>
<body>
<main id="mainprincipal mx-auto">
    <?php 
        include_once("../corpopag/cabecalho.php");           
    ?>
    <nav class="navbar fixed-bottom navbar-light bg-padrao align-items-center">
        <div class="d-flex align-items-center flex-column col-12">
            <p class="text-white h6 text-center"><?php echo "Unidade: ".$descunidade ?></p>
        </div>
        
    </nav>
    
    <div class=" d-flex justify-content-center  my-5 mx-auto">
        <div class="divdatamesano d-flex justify-content-center bg-padrao py-2 px-2">
            <label for="example-month-input" class="text-white col-form-label mr-2"> Mes/Ano:</label>
            <div >
                <input class='form-control' type='month' <?php echo $strmesano ?> id='dtmesano'>
                
            </div>
        </div>
    </div>
    <div class="container ">
        
        <?php echo $divmodulo; ?>
    </div>
</main>
    
    <script>
        function AtualizarDatas(Mod)
        {
            var anodig = $("#dtmesano").val().substr(0,4);
            var mesdig = $("#dtmesano").val().substr(5,2);
                    
            var date = new Date();
            var diaini = new Date(anodig, mesdig, 1).getDate();
            var diafim = new Date(anodig, mesdig, 0).getDate();
            var strdia = diaini.toString();
            if(diaini.toString().length==1){
                strdia = "0"+diaini.toString();
            }
            var diainicialmes= strdia+"."+mesdig+"."+anodig;
            var diafinalmes  = diafim+"."+mesdig+"."+anodig;
            var mesanodig = mesdig+"/"+anodig;

            
            $.ajax({
                type:"GET",
                url:"../../capturadadoslogado.php?diainicialmes="+diainicialmes+"&diafinalmes="+diafinalmes+"&mesanoatt="+mesanodig,
                cache: false,
                contentType: false,
                processData: false,
                async:false,
                beforeSend: function(){
                        
                }
                    
            }).done( function(data){
                //var dadosrec = $.parseJSON(data);
                //console.log(dadosrec);
                ExeModulo(Mod);
            }).fail( function(){
                console.log("ALGO DEU ERRADO");
            }).always( function(){
            
            });
        }
        function ExeModulo(Mod)
        {
            switch(Mod){
                case "DataCorp":
                    window.location.href ="datacorp.php";
                    break;
                case "DataProd":
                    console.log(Mod);
                    break;
                case "DataMilk":
                    console.log(Mod);
                    break;
                case "DataFlow":
                    console.log(Mod);
                    break;
                case "DataCont":
                    console.log(Mod);
                    break;
                case "DataFisc":
                    console.log(Mod);
                    break;
                case "DataSeller":
                    console.log(Mod);
                    break;
                case "DataProject":
                    break;
                default:
                    console.log("Nao existe pagina web para esse modulo");
            }
        }
        function IrModulo(Mod)
        {
            AtualizarDatas(Mod);
        }
    </script>
    
<script src="../../scripts/validator.js"></script>
<script src="../../scripts/validator.min.js"></script>    
</body>
</html>
<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    $cont = 0;
    if (isset($_GET["desctransfiscal"]))
    {

        $isnumero = $_GET["isnumeric"];
        $tipomovimento =$_GET["tipomov"];
        $transfiscal = isset($_GET["desctransfiscal"]) ? $_GET["desctransfiscal"] :"";
       
        

        $SqlStr = "SELECT TF.dfidtransfiscal, TF.dfdesctransfiscal,TF.dfprodutoproducao, tf.dfprodutorevenda,
                  tf.dfprodutoconsumo, tf.dfprodutoinsumo, tf.dfprodutoimobilizado, tf.dftipotravaestoque, tf.dfprodutoservico, tf.DFTIPOOPERACAO "; 
        $SqlStr.= "FROM tbtransfiscal TF";
        
        if($isnumero=="true"){
            
            $SqlStr .= " WHERE (TF.DFTIPOMOVIMENTO='".$tipomovimento."') AND (TF.dfidtransfiscal=".$transfiscal.")";
        }
        
        else{
            
            $SqlStr .= " WHERE (TF.DFTIPOMOVIMENTO='".$tipomovimento."') AND (TF.dfdesctransfiscal LIKE '%".$transfiscal."%')";
        }

        $capturatransfiscal   = fbird_query($dbh,$SqlStr);
        
        if($capturatransfiscal){
            
            while ($linha = fbird_fetch_object($capturatransfiscal)){
                $retorno[$cont]["MicroConta"]["idtransfiscal"] = $linha->DFIDTRANSFISCAL;
                $retorno[$cont]["MicroConta"]["desctransfiscal"] = utf8_encode($linha->DFDESCTRANSFISCAL);
                $retorno[$cont]["MicroConta"]["tipooperacao"] = $linha->DFTIPOOPERACAO;
                $retorno[$cont]["MicroConta"]["tipoproduto"]["produtoproducao"] = $linha->DFPRODUTOPRODUCAO;
                $retorno[$cont]["MicroConta"]["tipoproduto"]["produtorevenda"] = $linha->DFPRODUTOREVENDA;
                $retorno[$cont]["MicroConta"]["tipoproduto"]["produtoconsumo"] = $linha->DFPRODUTOCONSUMO;
                $retorno[$cont]["MicroConta"]["tipoproduto"]["produtoinsumo"] = $linha->DFPRODUTOINSUMO;
                $retorno[$cont]["MicroConta"]["tipoproduto"]["produtoimobilizado"] = $linha->DFPRODUTOIMOBILIZADO;
                $retorno[$cont]["MicroConta"]["tipoproduto"]["produtoservico"] = $linha->DFPRODUTOSERVICO;
                
                
                $cont = $cont + 1;
            }
                
        }
        fbird_free_result($capturatransfiscal);
    }
    
        
    
        
    $achou["pesquisa"]=(($cont==0)?false:true);
    fbird_close($dbh);
    echo json_encode(array($achou,$retorno));
        
?>
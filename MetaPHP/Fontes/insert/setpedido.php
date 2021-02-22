<?php
    include_once("../../connDB.php");
    session_start();
    $cont = 0;
    $contTotItens =0;
    $idPedido = 0;
    $retorno = array();
    $gravou = false;

    date_default_timezone_set('America/Sao_Paulo');
    
    if (isset($_REQUEST["Pedido"])){
        //captura codigo sequencial pedido 
        $strsql = "select gen_id(g_pedido,1) as MAIOR from rdb".'$'."database";
        $capturaIdPedido   = fbird_query($dbh,$strsql);
        if ($capturaIdPedido)
        {   $linha = fbird_fetch_object($capturaIdPedido);
            $idPedido = ($linha->MAIOR);
        }
        
        fbird_free_result($capturaIdPedido);
        
        $aPedido  = $_REQUEST["Pedido"]; 
        $retorno["Pedido"]= $aPedido; 
        
        $strsql = "INSERT INTO TBPEDIDO(";
        $strsql .= "DFIDPEDIDO, DFNUMEROPEDIDO, DFIDTRANSFISCAL, DFDATAPEDIDO, DFDATAMOVIMENTO, DFENTIDADE,"; 
        $strsql .= "DFIDENTIDADE,DFIDUNIDADE, DFIDVENDEDOR,DFIDUSUARIO,DFSTATUSFATURAMENTO,DFSTATUS,DFIDNUMNATOPERACAO,";
        $strsql .= "DFDATASISTEMA, DFHORASISTEMA,DFVALORLIQUIDOPEDIDO, DFVALORBRUTOPEDIDO, DFIDPESSOA,DFIDPLANOPAGAMENTO,DFIDPORTADOR,DFIDTRANSPORTADOR,DFIDLOCENTREGA,DFIDCARTEIRA,DFIDVEICULO,DFPLACAVEICULO,DFUFVEICULO)"; 
        $strsql .= " VALUES";
        
        $strsql .="(".$idPedido.",".$idPedido.",".$aPedido["idmicroconta"].",'".$aPedido["dtemissao"]."','";
        $strsql .=$aPedido["dtmovimento"]."',".$aPedido["entidade"].",".$aPedido["identidade"].",".$aPedido["idunidade"];
        $strsql .=",".(($aPedido["idvendedor"]=="")?"NULL":$aPedido["idvendedor"]).",";
        
        $strsql .=(($aPedido["idusuario"]=="")?"NULL":$aPedido["idusuario"]).",'"."N"."','"."A"."',";
        
        $strsql .= (($aPedido["idcfop"]=="")?"NULL":$aPedido["idcfop"]).",'";
        $strsql .= date('d.m.Y')."','".date('H:i:s')."',";
        $strsql .= $_SESSION["totais"]["valortotalliquido"].",".$_SESSION["totais"]["valortotalbruto"].",".$aPedido["codpessoa"];
        $strsql .= ",".$aPedido["idplanopagto"].",".$aPedido["idportador"].",".$aPedido["idtransportador"];
        $strsql .= ",".$aPedido["idlocalentrega"].",".$aPedido["idcarteira"].",".$aPedido["idveiculo"];
        $strsql .= ",'".$aPedido["placaveiculo"]."','".$aPedido["ufveiculo"]."'";
        $strsql .=");";
        
        $retorno["strsql"] = $strsql;
        
        // NOTAS FISCAL
        $qry = fbird_prepare($dbh,$strsql);
        try
        {
            
            $ret = ibase_execute($qry);
            $retorno["strsql"]= $strsql;
            fbird_commit($dbh);
                
            $gravou = true;
            $retorno["msg"] = "Inserido com Sucesso";
            $retorno["ret"] = $ret;
            
            
        }
        catch (Exception $e) 
        {
                
            $gravou = false;
            $retorno["msg"] = "Falha, ".$e->getMessage();
        }
        
        //  GRAVANDO ITENS
        if ($gravou)
        {
            $contTotItens = count($_SESSION["carrinho"]);
            $aitens = $_SESSION["carrinho"];
            $i=0;
            while ($i<=$contTotItens-1)
            {
                $sqlstritem  = "INSERT INTO TBITEMPEDIDO (DFIDPEDIDO,DFIDPRODUTO, DFVOLUME, DFQTDPRODUTO,";
                $sqlstritem .= "DFPESOPRODUTO, DFIDNUMNATOPERACAO, DFVALDESCONTO,  DFVALORUNT,"; 
                $sqlstritem .= "DFVALORBRUTOMERCADORIA,DFVALORLIQUIDOMERCADORIA) VALUES(";
                $sqlstritem .= $idPedido.",".$aitens[$i]["idproduto"].",".$aitens[$i]["volitem"].",".$aitens[$i]["qtditem"].",";
                $sqlstritem .= $aitens[$i]["pesoitem"].",".$aitens[$i]["idcfop"].",".$aitens[$i]["valdesc"].",";
                $sqlstritem .= $aitens[$i]["valuntitem"].",".$aitens[$i]["valbruto"].",".$aitens[$i]["valliquido"].");";
                
                $retorno["sqlitens"][$i]=$sqlstritem;
                
                $qryitem = fbird_prepare($dbh,$sqlstritem);
                try
                {

                    $ret = ibase_execute($qryitem);
                    fbird_commit($dbh);
                    
                    $gravou = true;
                    $retorno["msgitem"] = "Inserido com Sucesso";
                    $retorno["ret"] = $ret;


                }
                catch (Exception $e) 
                {

                    $gravou = false;
                    $retorno["msg"] = "Falha, ".$e->getMessage();
                }
                
                $i = $i + 1;
            }
            
            $retorno["itens"] = $aitens; 
        }
        
        //$_SESSION["carrinho"][$cont] = $aItem;
    }
    $retorno["totalitens"]   = $contTotItens;   
    $retorno["gravou"]       = $gravou;
    $retorno["numeropedido"] = $idPedido;
    fbird_close($dbh);
    //echo json_encode(array($total,$retorno));
    echo json_encode($retorno);
    
    
    
    
?>
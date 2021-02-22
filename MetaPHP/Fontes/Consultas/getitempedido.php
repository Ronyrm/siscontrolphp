<?php
    
    session_start();
    $retorno      = array();
    if (isset($_GET["idpedido"]))
    {
        include_once("../../connDB.php");
        $IdPedido = $_GET["idpedido"];
        
    
        $strsql =   "SELECT PE.DFIDITEMPEDIDO,PE.DFIDPEDIDO,PE.DFIDPRODUTO,PE.DFVOLUME,
                    PE.DFQTDPRODUTO,PE.DFPESOPRODUTO,PE.DFIDNUMNATOPERACAO," .
                    "NT.dfnatoperacao || ' - ' || NT.dfdescnatoperacao AS NATOPERACAO, PE.DFVALORUNT,PE.DFVALORBRUTOMERCADORIA,PE.DFPERCDESCONTO," .
                    "PE.DFPERCALIQIPI,PE.DFPERCALIQICMS,PE.DFCUSTOUNT,PE.DFCUSTOMEDIO,
                    PE.DFVALFRETECTRC,PE.DFPERCICMSFRETE,PE.DFVALDIFICMSFRETE," .
                    "PE.DFVALORIPI,PE.DFVALORICMS,PE.DFDIFALIQICMS,PE.DFVALDESCONTO,PE.DFVALACFRETE,
                    PE.DFVALACICMSFRETE,PE.DFVALACEMBALAGEM," .
                    "PE.DFVALACICMSEMBALAGEM,PE.DFVALACIPIEMB,PE.DFVALACENCARGOS,PE.DFVALACICMSENCARGOS,
                    PE.DFVALACIPIENCARGOS,PE.DFPERCCOMISSAO," .
                    "PE.DFPESOBRUTOPRODUTO,PE.DFVALORLIQUIDOMERCADORIA,PE.DFIDSITTRIBUTARIA,PE.DFBASEICMS,
                    PE.DFVALORCOMISSAO,PE.DFALIQSUBTRIB," .
                    "PE.DFBASESUBTRIB,PE.DFCODAUTSEFAZ,PE.DFNUMPASSEFISCAL,PE.DFHORASAIDA,PE.DFTEMPERATURA,
                    PE.DFBASEICMSSUBST,PE.DFALIQMVA," .
                    "PE.DFVALICMSSUBSTTRIB,PE.DFALIQBASEICMS,PE.DFIDMENSFISCAL,PE.DFVALORRATEIO,
                    PE.DFDESCCOMPLEMENTAR,PE.DFESPECIEVOLUME," .
                    "PE.DFVALDESCFINANC,PE.DFPERCDESCFINANC,PE.DFUNIDADE,PE.DFBASEIPI,PE.DFIDSITTRIBUTARIAIPI,
                    PE.DFALIQBASEIPI,PE.DFBASEPIS," .
                    "PE.DFIDSITTRIBUTARIAPIS,PE.DFALIQBASEPIS,PE.DFVALORPIS,PE.DFPERCALIQPIS,
                    PE.DFBASECOFINS,PE.DFIDSITTRIBUTARIACOFINS," .
                    "PE.DFALIQBASECOFINS,PE.DFVALORCOFINS,PE.DFPERCALIQCOFINS,PE.DFPRECOPAUTA,
                    PE.DFPERCCOMISLOGIST,PE.DFVALCOMISLOGIST," .
                    "PE.DFALIQBASEINSS,PE.DFVALORINSS,PE.DFBASEINSS,PE.DFPERCALIQINSS,PE.DFVALORSEGURO,
                    PE.DFVALBASEICMSSEGURO,PE.DFALIQICMSSEGURO," .
                    "PE.DFVALICMSSEGURO,PE.DFBASEICMSFRETE,PE.DFCODBCCPISCOFINS,PE.DFCODTIPOCREDITO,
                    PE.DFCODCONTSOCIALAP,PE.DFIDPRODUTOESTOQUELOTE," .
                    "PE.DFNUMDOCIMPORT,PE.DFDATAREGISTRODI,PE.DFLOCALDESEMBARACO,
                    PE.DFIDSIGLAUFDESEMBARACO,PE.DFCODEXPORT,PE.DFDATADESEMBARACO," .
                    "PE.DFNUMADICAO,PE.DFSEQUENCIAADICAO,PE.DFCODFABESTRANG,
                    PE.DFVALDESCITEMEXPORT,PDT.DFDESCPRODUTO,PDT.DFCODNCM," .
                    "PDT.DFREFPRODUTO,PDT.DFCLASFISCPRODUTO,PDT.DFCODPRODNBM" .
                    " FROM TBITEMPEDIDO PE" .
                    " INNER JOIN TBPRODUTODT PDT ON PDT.DFIDPRODUTO = PE.DFIDPRODUTO" .
                    " LEFT JOIN tbnatoperacao NT ON PE.dfidnumnatoperacao = NT.dfidnumnatoperacao" .
                    " WHERE DFIDPEDIDO = ".$IdPedido;
        
        $capturaitens = fbird_query($dbh,$strsql);
        if($capturaitens){
            while ($linha = fbird_fetch_object($capturaitens))
            {
                $index = $linha->DFIDITEMPEDIDO;
                $retorno[$index]["itens"]["iditempedido"] = $linha->DFIDITEMPEDIDO;
                $retorno[$index]["itens"]["idpedido"] = $linha->DFIDPEDIDO;
                $retorno[$index]["itens"]["idproduto"] = $linha->DFIDPRODUTO;
                $retorno[$index]["itens"]["descproduto"] = utf8_encode($linha->DFDESCPRODUTO);
                $retorno[$index]["itens"]["volumeitem"] = $linha->DFVOLUME;
                $retorno[$index]["itens"]["qtdproduto"] = $linha->DFQTDPRODUTO;
                $retorno[$index]["itens"]["pesoproduto"] = $linha->DFPESOPRODUTO;
                $retorno[$index]["itens"]["idnatoperacao"] = $linha->DFIDNUMNATOPERACAO;
                $retorno[$index]["itens"]["decnatoperacao"] = $linha->NATOPERACAO;
                
                $retorno[$index]["itens"]["valorunt"] = number_format(($linha->DFVALORUNT),3,",",".");
                $retorno[$index]["itens"]["valorbruto"] =number_format(($linha->DFVALORBRUTOMERCADORIA),3,",",".");
                $retorno[$index]["itens"]["valdesconto"] =number_format(($linha->DFVALDESCONTO),3,",",".");
                
                $retorno[$index]["itens"]["percdesconto"] =number_format(($linha->DFPERCDESCONTO),3,",",".");
                
                $retorno[$index]["itens"]["percaliq_ipi"] =number_format(($linha->DFPERCALIQIPI),3,",",".");
                $retorno[$index]["itens"]["percaliq_icms"] =number_format(($linha->DFPERCALIQICMS),3,",",".");
                
                $retorno[$index]["itens"]["custount"] =number_format(($linha->DFCUSTOUNT),3,",",".");
                $retorno[$index]["itens"]["customedio"] =number_format(($linha->DFCUSTOMEDIO),3,",",".");
                
                $retorno[$index]["itens"]["pesobruto"] =number_format(($linha->DFPESOBRUTOPRODUTO),3,",",".");
                $retorno[$index]["itens"]["valorliquido"] =number_format(($linha->DFVALORLIQUIDOMERCADORIA),3,",",".");
                $retorno[$index]["itens"]["DFIDSITTRIBUTARIA"] = $linha->DFPESOBRUTOPRODUTO;
                $retorno[$index]["itens"]["baseicms"] =number_format(($linha->DFBASEICMS),3,",",".");
                $retorno[$index]["itens"]["aliqsubtrib"] =  ($linha->DFALIQSUBTRIB);
                $retorno[$index]["itens"]["valorcomissao"] =number_format(($linha->DFVALORCOMISSAO),3,",",".");
                
            }
        }
        fbird_free_result($capturaitens);
        
    }
    fbird_close($dbh);
    echo json_encode($retorno);
?>
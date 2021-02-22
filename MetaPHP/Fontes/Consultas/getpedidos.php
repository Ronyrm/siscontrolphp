<?php
    include_once("../../connDB.php");
    session_start();
    $retorno      = array();
    $achou      = array();
    if (isset($_GET["CodUni"]))
    {
        $CodUni = $_GET["CodUni"];
        $DiaIni = $_GET["DiaIni"];
        $DiaFim = $_GET["DiaFim"];
        $TpMov  = $_GET["TpMov"];
        if (!isset($_SESSION["idgrau1"]))
        {
            
            $SqlStr = "SELECT UN.DFIDGRAU1, UN.DFIDGRAU2, UN.DFIDGRAU3 FROM tbunidade UN WHERE UN.dfidunidade=".$CodUni;
            $capturauni   = fbird_query($dbh,$SqlStr);
            if ($capturauni)
            {
                $linha = fbird_fetch_object($capturauni);
                
                $idgrau1 = ($linha->DFIDGRAU1);
                $idgrau2 = ($linha->DFIDGRAU2);
                $idgrau3 = ($linha->DFIDGRAU3);
                
                $_SESSION["idgrau1"] = $idgrau1;
                $_SESSION["idgrau2"] = $idgrau2;
                $_SESSION["idgrau3"] = $idgrau3;
            }
            fbird_free_result($capturauni);
        }
        else
        {
            $idgrau1 = $_SESSION["idgrau1"];
            $idgrau2 = $_SESSION["idgrau2"];
            $idgrau3 = $_SESSION["idgrau3"];
        }
        
        
        $SqlWhere = " where(PE.dfdatapedido between '".$DiaIni."' AND '".$DiaFim."') AND(TF.dftipomovimento ='".$TpMov."')  AND (UN.dfidgrau1 ='".$idgrau1."' AND UN.dfidgrau2 ='".$idgrau2."' AND UN.dfidgrau3 <> '000') ";
        //AND (pe.dfstatus='A' and  pe.dfstatusfaturamento='N')";
        
        
        $SqlStr = "SELECT tf.dftipomovimento,DfStatusAnCredito, DfStatusFormacCarga,pe.DFIDOBSNF," .
                    "DfStatusRomaneio, DfStatusFaturamento, DfStatusExpedicao,pe.DfIdTransFiscal, pe.DfIdPedido," .
                    "DfDescTransFiscal,pe.DfDataMovimento, pe.DfIdEntidade,pe.dfidpessoa," .
                    "pe.DfIdEntidade ||'-'|| CASE pe.DfEntidade" .
                    " WHEN 0 THEN pcl.DfNomePessoa" .
                    " WHEN 1 THEN pfo.DfNomePessoa" .
                    " WHEN 2 THEN ppr.DfNomePessoa" .
                    " WHEN 3 THEN pve.DfNomePessoa" .
                    " WHEN 4 THEN pfu.DfNomePessoa" .
                    " WHEN 5 THEN pve.DfNomePessoa" .
                    " WHEN 6 THEN pca.DfNomePessoa" .
                    " WHEN 7 THEN pve.DfNomePessoa" .
                    " WHEN 8 THEN ptr.DfNomePessoa" .
                    " WHEN 9 THEN pde.DfNomePessoa" .
                    " WHEN 10 THEN pde.DfNomePessoa" .
                    " END AS NomedaEntidade," .
                    " CASE pe.DfEntidade" .
                    " WHEN 0 THEN pcl.dfnomefantasia" .
                    " WHEN 1 THEN pfo.dfnomefantasia" .
                    " WHEN 2 THEN ppr.dfnomefantasia" .
                    " WHEN 3 THEN pve.dfnomefantasia" .
                    " WHEN 4 THEN pfu.dfnomefantasia" .
                    " WHEN 5 THEN pve.dfnomefantasia" .
                    " WHEN 6 THEN pca.dfnomefantasia" .
                    " WHEN 7 THEN pve.dfnomefantasia" .
                    " WHEN 8 THEN ptr.dfnomefantasia" .
                    " WHEN 9 THEN pde.dfnomefantasia" .
                    " WHEN 10 THEN pde.dfnomefantasia" .
                    " END AS FantasiaPessoa," .
                    " CASE pe.DfEntidade" .
                    " WHEN 0 THEN pcl.dfidpessoa" .
                    " WHEN 1 THEN pfo.dfidpessoa" .
                    " WHEN 2 THEN ppr.dfidpessoa" .
                    " WHEN 3 THEN pve.dfidpessoa" .
                    " WHEN 4 THEN pfu.dfidpessoa" .
                    " WHEN 5 THEN pve.dfidpessoa" .
                    " WHEN 6 THEN pca.dfidpessoa" .
                    " WHEN 7 THEN pve.dfidpessoa" .
                    " WHEN 8 THEN ptr.dfidpessoa" .
                    " WHEN 9 THEN pde.dfidpessoa" .
                    " WHEN 10 THEN pde.dfidpessoa" .
                    "  END AS DFIDPESSOAENT," .
                    " pe.DfIdUnidade, un.DfRazSocUnidade,pe. DfValDesconto, pe.dfvalorbrutopedido," .
                    " pe.DfIdUsuario, DfNomeUsuario, pe.dfvalorliquidopedido,    DfNumeroPedido,  DfDataPedido," .
                    " pe.DfEntidade, pe.DfIdCarteira, pe.DfNumeroOrigem,pe.DfIdVendedor, pe.DfIdLocEntrega," .
                    " pe.DfIdTransportador, pe.DfIdPortador, pg. dfdescplanopagamento, pe.DfIdPlanoPagamento, pe.DfValFrete," .
                    "  DfIncFrete, pe.DfCIFFOB, pe.DfValEmbalagem, pe.DfNumCarga, pe.DfEspecieCarga, DfMarcaVolume," .
                    " pe.DfQtdCarga, pe.DfPercDesconto, cast(pe.DfMsgFiscal as varchar(500)) as DfMsgFiscal, pe.DfStatus, cast(pe.DfObservacao as varchar(500)) as DfObservacao, pe.DfIdNumNatOperacao, " . 
                    " pe.DfPesoLiqCarga, pe.DfPesoBrutoCarga, pe.DfDataEntrega, pe.dfidcoletapneus," .
                    " pe.DfIdNumMapaFormacaoCarga,pe.DfIdVeiculo,pe.dfplacaveiculo, vfc.dfplacaveiculo as  dfplacaveiculoFormaC," .
                    " pe.DfIdModulo, pe.DfDataSistema, pe.DfHoraSistema, pe.DfIdAuditoria, DfTipoOperacao," .
                    " DfIdTransFiscalTransf, DfEntidadeTransf, DfIdEntidadeTransf,  DfIdUnidadeTransf, DfIdNumNatOperacaoTransf," .
                    " SUBSTRING(DfDataPedido FROM 1 FOR 7) AS DataPedido," .
                    " SUBSTRING(pe.DfDataMovimento FROM 1  FOR 7) AS DataMov," .
                    " SUBSTRING(pe.DfDataEntrega FROM 1 FOR 7) AS DataEntreg," .
                    " u.DfIdGrau1, u.DfIdGrau2, u.DfIdGrau3, nf.DfNumNF,nf.dfchavenfe," .
                    " mo.DfNomeModulo||' - '||au.DfDescricao AS Auditoria," .
                    " pv.dfnomepessoa  as NOMEVENDEDOR," .
                    " pe.DFNUMDECLARACAO," .
                    " pe.DFDATADECLARACAO," .
                    " pe.DFTIPODOCEXPIMP," .
                    " pe.DFNUMREGEXPORT," .
                    " pe.DFNATUREZAEXPORT," .
                    " pe.DFDATAREGEXPORT," .
                    " pe.DFNUMCONEMBAR," .
                    " pe.DFDATACONEMBAR," .
                    " pe.DFDATAAVERBACAO," .
                    " pe.DFVALORPIS," .
                    " pe.DFVALORCOFINS," .
                    " pe.DFTIPOCONTRANSPOR," .
                    " pe.DFCODPAISDEST," .
                    " pe.DFNUMMEMORANDO," .
                    " pe.DFDATAVENCIMENTO," .
                    " pe.dfidromaneio," .
                    " pe.DFIDPROPRIEDADE," .
                    "  ban.Dfidbanco," . 
                    "  ban.dfnomebanco," .
                    " pe.DfUfVeiculo," .
                    " pe.DFVALORFINANCEIROPEDIDO," .
                    " pe.DFDESCONTOFINANCEIRO," . 
                    " pe.dfordementrega," .
                    " pe.DFIDTRANSLOGIST," .
                    " pe.DFVALORINSS," .
                    " car.dfdescricao," .
                    " car.dfcarteira," . 
                    " pe.dfcodajuste," .
                    " pe.dftipodestajuste," .
                    "(SELECT UNP.dfrazsocunidade FROM TBUNIDADE UNP WHERE UNP.dfidgrau1=un.dfidgrau1 AND UNP.dfidgrau2=un.dfidgrau2 AND UNP.dfidgrau3='000') as UNIDADEPRINCIPAL," .
                    "NT.dfnatoperacao || ' - ' || NT.dfdescnatoperacao as NatOperacao,nf.dfidnotafiscal" .
                    " FROM tbPedido pe" .
                    " LEFT JOIN tbTransFiscal tf ON tf.DfIdTransFiscal=pe.DfIdTransFiscal" .
                    " LEFT JOIN tbUnidade un ON un.DfIdUnidade=pe.DfIdUnidade" .
                    " LEFT JOIN tbUsuario us ON us.DfIdUsuario=pe.DfIdUsuario" .
                    " LEFT JOIN tbCliente cl ON cl.DfIdCliente=pe.DfIdEntidade" .
                    " LEFT JOIN tbPessoa pcl ON pcl.DfIdPessoa=cl.DfIdPessoa" .
                    " LEFT JOIN tbFornecedor fo ON fo.DfIdFornecedor=pe.DfIdEntidade" .
                    " LEFT JOIN tbPessoa pfo ON pfo.DfIdPessoa=fo.DfIdPessoa" .
                    " LEFT JOIN tbProdutor pr ON pr.DfIdProdutor=pe.DfIdEntidade" .
                    " LEFT JOIN tbPessoa ppr ON ppr.DfIdPessoa=pr.DfIdPessoa" .
                    " LEFT JOIN tbVendedor ve ON ve.DfIdVendedor=pe.DfIdEntidade" .
                    " LEFT JOIN tbPessoa pve ON pve.DfIdpessoa=ve.DfIdPessoa" .
                    " LEFT JOIN tbFuncionario fu ON fu.DfIdFuncionario=pe.DfIdEntidade" .
                    " LEFT JOIN tbPessoa pfu ON pfu.DfIdPessoa=fu.DfIdPessoa" .
                    " LEFT JOIN tbCarreteiro ca ON ca.DfIdCarreteiro=pe.DfIdEntidade" .
                    " LEFT JOIN tbPessoa pca ON pca.DfIdPessoa=ca.DfIdPessoa" .
                    " LEFT JOIN tbTransportador tr ON tr.DfIdTransportador=pe.DfIdEntidade" .
                    " LEFT JOIN tbPessoa ptr ON ptr.DfIdPessoa=tr.DfIdPessoa" .
                    " LEFT JOIN tbUnidade de ON de.DfIdUnidade=pe.DfIdEntidade" .
                    " LEFT JOIN tbPessoa pde ON pde.DfIdPessoa=de.DfIdPessoa" .
                    " LEFT JOIN tbEndereco le ON le.DfIdEndereco=pe.DfIdLocEntrega" .
                    " LEFT JOIN tbVeiculo vi ON pe.DfIdVeiculo=vi.DfIdVeiculo" .
                    " LEFT JOIN tbUnidade u ON u.DfIdUnidade=pe.DfIdUnidade" .
                    " LEFT JOIN tbFormacCarga fc ON fc.DfIdNumMapaFormacaoCarga=pe.DfIdNumMapaFormacaoCarga" .
                    " LEFT JOIN tbVeiculo vfc ON vfc.DfIdVeiculo=fc.DfIdVeiculo" .
                    " LEFT JOIN tbNF nf ON pe.DfIdPedido=nf.DfIdPedido" .
                    " LEFT JOIN tbModulo mo ON  mo.DfIdModulo=pe.DfIdModulo " .
                    " LEFT JOIN tbAuditoria au ON au.DfIdAuditoria=pe.DfIdAuditoria" .
                    " LEFT JOIN tbPlanoPagamento pg ON pg.DfIdplanopagamento=pe.DfIdplanopagamento" .
                    " LEFT join tbcarteira car on pe.dfidcarteira = car.dfidcarteira" .
                    " LEFT join tbbanco ban on car.dfidbanco = ban.dfidbanco" .
                    " LEFT join tbvendedor vep on vep.dfidvendedor = pe.dfidvendedor" .
                    " LEFT JOIN tbnatoperacao  NT ON pe.dfidnumnatoperacao = NT.dfidnumnatoperacao" .
                    " LEFT join tbpessoa pv ON pv.dfidpessoa=vep.dfidpessoa" . $SqlWhere;
                    $SqlStr .=" ORDER BY pe.DFDATASISTEMA desc, pe.dfhorasistema desc ";

        
        
        $consulta   = fbird_query($dbh,$SqlStr);
        if ($consulta)
        {
            $cont = 0;
            
            while ($linha = fbird_fetch_object($consulta))
            {
                
                $idpedido = ($linha->DFIDPEDIDO);
                
                
                switch($linha->DFENTIDADE)
                {
                    case 0:
                        $strentidade = "Cliente";
                        break;
                    case 1:
                        $strentidade = "Fornecedor";
                        break;
                    case 2:
                        $strentidade = "Produtor Rural";
                        break;
                    case 3:
                        $strentidade = "Vendedor";
                        break;
                    case 4:
                        $strentidade = "Funcionário";
                        break;
                    case 5:
                        $strentidade = "Representante";
                        break;
                    case 6:
                        $strentidade = "Carreteiro";
                        break;
                    case 7:
                        $strentidade = "Promotor";
                        break;
                    case 8:
                        $strentidade = "Transportador";
                        break;
                    case 9:
                        $strentidade = "Departamento";
                        break;
                    case "10":
                        $strentidade = "Unidade";
                        break;
                    default: 
                        $strentidade = "Rony";
                }
                    
                $retorno[$cont]["Pedido"]["idpedido"] = ($linha->DFNUMEROPEDIDO);
                
                $dataped = new DateTime(($linha->DFDATAPEDIDO));
                $retorno[$cont]["Pedido"]["data"]= $dataped->format("d/m/Y");
                // Val liquido
                $retorno[$cont]["Pedido"]["valorliquido"] = number_format(($linha->DFVALORLIQUIDOPEDIDO),3,",",".");
                //valor bruto
                $retorno[$cont]["Pedido"]["valorbruto"] = number_format(($linha->DFVALORBRUTOPEDIDO),3,",",".");
                //valor desconto
                $retorno[$cont]["Pedido"]["valordesconto"] = number_format(($linha->DFVALDESCONTO),3,",",".");
                //id unidade
                $retorno[$cont]["Pedido"]["idunidade"] = ($linha->DFIDUNIDADE);
                //DfRazSocUnidade
                $retorno[$cont]["Pedido"]["descunidade"] = utf8_encode(($linha->DFRAZSOCUNIDADE));
                
                $retorno[$cont]["Pedido"]["idtransfiscal"] = ($linha->DFIDTRANSFISCAL);
                $retorno[$cont]["Pedido"]["desctransfiscal"] = utf8_encode($linha->DFDESCTRANSFISCAL);
                $retorno[$cont]["Pedido"]["identidade"] = ($linha->DFIDENTIDADE);
                $retorno[$cont]["Pedido"]["nomedaentidade"] = utf8_encode($linha->NOMEDAENTIDADE);
                $retorno[$cont]["Pedido"]["descplanopagto"] = utf8_encode($linha->DFDESCPLANOPAGAMENTO);
                $retorno[$cont]["Pedido"]["idplanopagto"] = ($linha->DFIDPLANOPAGAMENTO);
                $retorno[$cont]["Pedido"]["status"] = ($linha->DFSTATUS);
                $retorno[$cont]["Pedido"]["statusfaturamento"] = ($linha->DFSTATUSFATURAMENTO);
                $retorno[$cont]["Pedido"]["numnf"] = ($linha->DFNUMNF);
                $retorno[$cont]["Pedido"]["chavenfe"] = ($linha->DFCHAVENFE);
                
                
                $retorno[$cont]["Pedido"]["entidade"] = ($linha->DFENTIDADE);
                $retorno[$cont]["Pedido"]["descentidade"] = utf8_encode($strentidade);
                $retorno[$cont]["Pedido"]["tipomovimento"] = ($TpMov=="S")?"Saída":"Entrada";
                $retorno[$cont]["Pedido"]["idvendedor"] = $linha->DFIDVENDEDOR;
                $retorno[$cont]["Pedido"]["nomevendedor"] = utf8_encode($linha->NOMEVENDEDOR);
                $retorno[$cont]["Pedido"]["idusario"] = $linha->DFIDUSUARIO;
                $retorno[$cont]["Pedido"]["nomeusuario"] = utf8_encode($linha->DFNOMEUSUARIO);
                
                $dataped = new DateTime(($linha->DFDATASISTEMA));
                $retorno[$cont]["Pedido"]["datasistema"] = $dataped->format("d/m/Y");
                $dataped = new DateTime(($linha->DFHORASISTEMA));
                $retorno[$cont]["Pedido"]["horasistema"] = $dataped->format("H:i:s");
                
                $retorno[$cont]["Pedido"]["valdescfinanc"] =number_format(($linha->DFDESCONTOFINANCEIRO),3,",",".");
                $retorno[$cont]["Pedido"]["valordocfinanc"] =number_format(($linha->DFVALORFINANCEIROPEDIDO),3,",",".");
                
                $retorno[$cont]["Pedido"]["idcarteira"] = $linha->DFIDCARTEIRA;
                $retorno[$cont]["Pedido"]["desccarteira"] = utf8_encode($linha->DFDESCRICAO);
                $retorno[$cont]["Pedido"]["carteira"] = utf8_encode($linha->DFCARTEIRA);
                $retorno[$cont]["Pedido"]["unidadepai"] = utf8_encode($linha->UNIDADEPRINCIPAL);
                $retorno[$cont]["Pedido"]["idbanco"] = $linha-> DFIDBANCO;
                $retorno[$cont]["Pedido"]["nomebanco"] = utf8_encode($linha->DFNOMEBANCO);
                $retorno[$cont]["Pedido"]["msgfiscal"] =  utf8_encode($linha->DFMSGFISCAL);
                $retorno[$cont]["Pedido"]["observacaoped"] =  utf8_encode($linha->DFOBSERVACAO);
                $retorno[$cont]["Pedido"]["natoperacao"] = utf8_encode($linha->NATOPERACAO);
                $retorno[$cont]["Pedido"]["numnatoperacao"] = $linha->DFIDNUMNATOPERACAO;
                 
                
                $cont+=1;
            }
            
            $achou["pesquisa"]= $cont;
        }
        
        fbird_free_result($consulta); 
    }
    else{
        $achou["pesquisa"]= 0;
    }

    echo json_encode(array($achou,$retorno));
    fbird_close($dbh);
?>
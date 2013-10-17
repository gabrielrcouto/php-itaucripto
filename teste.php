<?php
	include "Itaucripto.php";

	$cripto = new Itaucripto();
	
	$codEmp ="J1234567890123456789012345";
	$chave="ABCD123456ABCD12";

	$pedido = "1234";
	$valor = "1,99";
	$observacao = "Essa щ uma observaчуo";
	$nomeSacado = "Josщ Antєnio";
	$codigoInscricao = "01";
	$numeroInscricao = "82938674341";
	$enderecoSacado = "Rua das Hortъncias";
	$bairroSacado = "Jardim das Flores";
	$cepSacado = "13080040";
	$cidadeSacado = "Campinas";
	$estadoSacado = "SP";
	$dataVencimento = "31122013";
	$urlRetorna = "retorno/retorno.php";
	$obsAd1 = "Aqui vai a observaчуo 1";
	$obsAd2 = "Aqui vai a observaчуo 2";
	$obsAd3 = "Aqui vai a observaчуo 3";
	
	$dados = $cripto->geraDados($codEmp,$pedido,$valor,$observacao,$chave,$nomeSacado,$codigoInscricao,$numeroInscricao,$enderecoSacado,$bairroSacado,$cepSacado,$cidadeSacado,$estadoSacado,$dataVencimento,$urlRetorna,$obsAd1,$obsAd2,$obsAd3);
	
	echo $dados;

?>
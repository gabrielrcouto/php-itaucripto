<?php

	include "Itaucripto.php";

	$cripto = new Itaucripto();
	
	$codEmp ="J1234567890123456789012345";
	$chave="ABCD123456ABCD12";

	$pedido = "1234";
	$valor = "150,00";
	$observacao = "";
	$nomeSacado = "José Pereira";
	$codigoInscricao = "";
	$numeroInscricao = "";
	$enderecoSacado = "";
	$bairroSacado = "";
	$cepSacado = "";
	$cidadeSacado = "";
	$estadoSacado = "";
	$dataVencimento = "";
	$urlRetorna = "";
	$obsAd1 = "";
	$obsAd2 = "";
	$obsAd3 = "";
	
	$dados = $cripto->geraDados($codEmp,$pedido,$valor,$observacao,$chave,$nomeSacado,$codigoInscricao,$numeroInscricao,$enderecoSacado,$bairroSacado,$cepSacado,$cidadeSacado,$estadoSacado,$dataVencimento,$urlRetorna,$obsAd1,$obsAd2,$obsAd3);
	
	echo $dados;
?>
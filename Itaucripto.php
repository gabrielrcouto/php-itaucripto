<?php

namespace Itaucripto;

/**
 * Itaucripto Class
 *
 * Essa classe permite utilizar as funções de criptografia do Itaú Shopline
 * Tem como base a classe Itaucripto feita em Java
 *
 * @author Gabriel Rodrigues Couto - @gabrielrcouto
 * @link
 */
class Itaucripto {

    public $sbox;
    public $key;
    public $codEmp;
    public $numPed;
    public $tipPag;
    public $CHAVE_ITAU = "SEGUNDA12345ITAU";
    public $TAM_COD_EMP = 26;
    public $TAM_CHAVE = 16;
    public $dados;

    function __construct() {
        $this->sbox = array();
        $this->key = array();

        $this->numPed = "";
        $this->tipPag = "";
        $this->codEmp = "";
    }

    //$dados, $chave
    private function Algoritmo($paramString1, $paramString2) {
        $paramString2 = strtoupper($paramString2);

        $k = 0;
        $m = 0;

        $str = "";
        $this->Inicializa($paramString2);

        for ($j = 1; $j <= strlen($paramString1); $j++) {
            $k = ($k + 1) % 256;
            $m = ($m + $this->sbox[$k]) % 256;
            $i = $this->sbox[$k];
            $this->sbox[$k] = $this->sbox[$m];
            $this->sbox[$m] = $i;

            $n = $this->sbox[(($this->sbox[$k] + $this->sbox[$m]) % 256)];

            $i1 = (ord(substr($paramString1, ($j - 1), 1)) ^ $n);

            $str = $str . chr($i1);
        }

        return $str;
    }

    private function PreencheBranco($paramString, $paramInt) {
        $str = $paramString . "";

        while (strlen($str) < $paramInt) {
            $str = $str . " ";
        }

        return substr($str, 0, $paramInt);
    }

    private function PreencheZero($paramString, $paramInt) {
        $str = $paramString . "";

        while (strlen($str) < $paramInt) {
            $str = "0" . $str;
        }

        return substr($str, 0, $paramInt);
    }

    private function Inicializa($paramString) {
        $m = strlen($paramString);

        for ($j = 0; $j <= 255; $j++) {
            $this->key[$j] = substr($paramString, ($j % $m), 1);
            $this->sbox[$j] = $j;
        }

        $k = 0;

        for ($j = 0; $j <= 255; $j++) {
            $k = ($k + $this->sbox[$j] + ord($this->key[$j])) % 256;
            $i = $this->sbox[$j];
            $this->sbox[$j] = $this->sbox[$k];
            $this->sbox[$k] = $i;
        }
    }

    //Função criada para substituir o Math.random() do Java
    //Retorna um número entre 0.0 e 0.9999999999 (equivalente ao Double do Java, mas com menor precisão)
    private function JavaRandom() {
        return rand(0, 999999999) / 1000000000;
    }

    //Retira as letras acentuadas e substitui pelas não acentuadas
    private function TiraAcento($str) {
        return strtr(utf8_decode($str), utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'), 'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');
    }

    private function Converte($paramString) {
        $c = chr(floor(26.0 * $this->JavaRandom() + 65.0));
        $str = "" . $c;

        for ($i = 0; $i < strlen($paramString); $i++) {
            $k = substr($paramString, $i, 1);
            $j = ord($k);
            $str = $str . $j;
            $c = chr(floor(26.0 * $this->JavaRandom() + 65.0));
            $str = $str . $c;
        }

        return $str;
    }

    private function Desconverte($paramString) {
        $str1 = "";

        for ($i = 0; $i < strlen($paramString); $i++) {
            $str2 = "";

            $c = substr($paramString, $i, 1);

            while (is_numeric($c)) {
                $str2 = $str2 . substr($paramString, $i, 1);
                $i += 1;
                $c = substr($paramString, $i, 1);
            }

            if ($str2 != "") {
                $j = $str2 + 0;
                $str1 = $str1 . chr($j);
            }
        }

        return $str1;
    }

    //$codEmp,$pedido,$valor,$observacao,$chave,$nomeSacado,$codigoInscricao,$numeroInscricao,$enderecoSacado,$bairroSacado,$cepSacado,$cidadeSacado,$estadoSacado,$dataVencimento,$urlRetorna,$obsAd1,$obsAd2,$obsAd3
    public function geraDados($paramString1, $paramString2, $paramString3, $paramString4, $paramString5, $paramString6, $paramString7, $paramString8, $paramString9, $paramString10, $paramString11, $paramString12, $paramString13, $paramString14, $paramString15, $paramString16, $paramString17, $paramString18) {
        $paramString1 = strtoupper($paramString1);
        $paramString5 = strtoupper($paramString5);

        if (strlen($paramString1) != $this->TAM_COD_EMP) {
            return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
        }

        if (strlen($paramString5) != $this->TAM_CHAVE) {
            return "Erro: tamanho da chave da chave diferente de 16 posições.";
        }

        if ((strlen($paramString2) < 1) || (strlen($paramString2) > 8)) {
            return "Erro: número do pedido inválido.";
        }

        if (is_numeric($paramString2)) {
            $paramString2 = $this->PreencheZero($paramString2, 8);
        } else {
            return "Erro: numero do pedido não é numérico.";
        }

        if ((strlen($paramString3) < 1) || (strlen($paramString3) > 11)) {
            return "Erro: valor da compra inválido.";
        }

        $i = strpos($paramString3, ',');

        if ($i !== FALSE) {
            $str3 = substr($paramString3, ($i + 1));

            if (!is_numeric($str3)) {
                return "Erro: valor decimal não é numérico.";
            }

            if (strlen($str3) != 2) {
                return "Erro: valor decimal da compra deve possuir 2 posições após a virgula.";
            }

            $paramString3 = substr($paramString3, 0, strlen($paramString3) - 3) . $str3;
        } else {
            if (!is_numeric($paramString3)) {
                return "Erro: valor da compra não é numérico.";
            }

            if (strlen($paramString3) > 8) {
                return "Erro: valor da compra deve possuir no máximo 8 posições antes da virgula.";
            }

            $paramString3 = $paramString3 . "00";
        }

        $paramString3 = $this->PreencheZero($paramString3, 10);

        $paramString7 = trim($paramString7);

        if (($paramString7 != "02") && ($paramString7 != "01") && ($paramString7 != "")) {
            return "Erro: código de inscrição inválido.";
        }

        if (($paramString8 != "") && (!is_numeric($paramString8)) && (strlen($paramString8) > 14)) {
            return "Erro: número de inscrição inválido.";
        }

        if (($paramString11 != "") && ((!is_numeric($paramString11)) || (strlen($paramString11) != 8))) {
            return "Erro: cep inválido.";
        }

        if (($paramString14 != "") && ((!is_numeric($paramString14)) || (strlen($paramString14) != 8))) {
            return "Erro: data de vencimento inválida.";
        }

        if (strlen($paramString16) > 60) {
            return "Erro: observação adicional 1 inválida.";
        }

        if (strlen($paramString17) > 60) {
            return "Erro: observação adicional 2 inválida.";
        }

        if (strlen($paramString18) > 60) {
            return "Erro: observação adicional 3 inválida.";
        }

        //Retira os acentos
        $paramString4 = $this->TiraAcento($paramString4);
        $paramString6 = $this->TiraAcento($paramString6);
        $paramString9 = $this->TiraAcento($paramString9);
        $paramString10 = $this->TiraAcento($paramString10);
        $paramString12 = $this->TiraAcento($paramString12);
        $paramString16 = $this->TiraAcento($paramString16);
        $paramString17 = $this->TiraAcento($paramString17);
        $paramString18 = $this->TiraAcento($paramString18);

        $paramString4 = $this->PreencheBranco($paramString4, 40);
        $paramString6 = $this->PreencheBranco($paramString6, 30);
        $paramString7 = $this->PreencheBranco($paramString7, 2);
        $paramString8 = $this->PreencheBranco($paramString8, 14);
        $paramString9 = $this->PreencheBranco($paramString9, 40);
        $paramString10 = $this->PreencheBranco($paramString10, 15);
        $paramString11 = $this->PreencheBranco($paramString11, 8);
        $paramString12 = $this->PreencheBranco($paramString12, 15);
        $paramString13 = $this->PreencheBranco($paramString13, 2);
        $paramString14 = $this->PreencheBranco($paramString14, 8);
        $paramString15 = $this->PreencheBranco($paramString15, 60);
        $paramString16 = $this->PreencheBranco($paramString16, 60);
        $paramString17 = $this->PreencheBranco($paramString17, 60);
        $paramString18 = $this->PreencheBranco($paramString18, 60);

        $str1 = $this->Algoritmo($paramString2 . $paramString3 . $paramString4 . $paramString6 . $paramString7 . $paramString8 . $paramString9 . $paramString10 . $paramString11 . $paramString12 . $paramString13 . $paramString14 . $paramString15 . $paramString16 . $paramString17 . $paramString18, $paramString5);

        $str2 = $this->Algoritmo($paramString1 . $str1, $this->CHAVE_ITAU);

        return $this->Converte($str2);
    }

    public function geraCripto($paramString1, $paramString2, $paramString3) {
        if (strlen($paramString1) != $this->TAM_COD_EMP) {
            return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
        }

        if (strlen($paramString3) != $this->TAM_CHAVE) {
            return "Erro: tamanho da chave da chave diferente de 16 posições.";
        }

        $paramString2 = trim($paramString2);

        if ($paramString2 == "") {
            return "Erro: código do sacado inválido.";
        }

        $str1 = $this->Algoritmo($paramString2, $paramString3);

        $str2 = $this->Algoritmo($paramString1 . $str1, $this->CHAVE_ITAU);

        return $this->Converte($str2);
    }

    public function geraConsulta($paramString1, $paramString2, $paramString3, $paramString4) {
        if (strlen($paramString1) != $this->TAM_COD_EMP) {
            return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
        }

        if (strlen($paramString4) != $this->TAM_CHAVE) {
            return "Erro: tamanho da chave da chave diferente de 16 posições.";
        }

        if ((strlen($paramString2) < 1) || (strlen($paramString2) > 8)) {
            return "Erro: número do pedido inválido.";
        }

        if (is_numeric($paramString2)) {
            $paramString2 = $this->PreencheZero($paramString2, 8);
        } else {
            return "Erro: numero do pedido não é numérico.";
        }

        if (($paramString3 != "0") && ($paramString3 != "1")) {
            return "Erro: formato inválido.";
        }

        $str1 = $this->Algoritmo($paramString2 . $paramString3, $paramString4);

        $str2 = $this->Algoritmo($paramString1 . $str1, $this->CHAVE_ITAU);

        return $this->Converte($str2);
    }

    //$dados, $chave
    public function decripto($paramString1, $paramString2) {
        //A chave precisa sempre estar em maiusculo
        $paramString2 = strtoupper($paramString2);

        $paramString1 = $this->Desconverte($paramString1);

        $str = $this->Algoritmo($paramString1, $paramString2);

        $this->codEmp = substr($str, 0, 26);

        $this->numPed = substr($str, 26, 8);

        $this->tipPag = substr($str, 34, 2);

        return $str;
    }

    public function retornaCodEmp() {
        return $this->codEmp;
    }

    public function retornaPedido() {
        return $this->numPed;
    }

    public function retornaTipPag() {
        return $this->tipPag;
    }

    public function geraDadosGenerico($paramString1, $paramString2, $paramString3) {
        $paramString1 = strtoupper($paramString1);
        $paramString3 = strtoupper($paramString3);

        if (strlen($paramString1) != $this->TAM_COD_EMP) {
            return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
        }

        if (strlen($paramString3) != $this->TAM_CHAVE) {
            return "Erro: tamanho da chave da chave diferente de 16 posições.";
        }

        if (strlen($paramString2) < 1) {
            return "Erro: sem dados.";
        }

        $str1 = $this->Algoritmo($paramString2, $paramString3);

        $str2 = $this->Algoritmo($paramString1 . $str1, $this->CHAVE_ITAU);

        return $this->Converte($str2);
    }

}

?>
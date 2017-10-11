PHP ITAUCRIPTO
==============

Versão em PHP da classe Itaucripto, originalmente escrita em Java.

O nome dos métodos foi mantido seguindo o padrão Java, apenas para evitar confusões.

Como a classe em Java foi descompilada, alguns nomes se tornaram nomes genéricos (ex: $paramString1, $paramString2).

Dúvidas
==============

Caso tenha alguma dúvida, crie uma issue nesse repositório. Algumas pessoas me contactaram pelas redes sociais, porém fica mais fácil deixarmos documentadas as perguntas/respostas aqui no Github, assim ajudamos mais pessoas.

Criei essa biblioteca em 2013 para um pequeno e-commerce, sem a ajuda do Itaú ou qualquer relação com eles, por isso, não consigo fornecer suporte para mensagens de erro do backend deles, somente para a forma como deve ser utilizada essa biblioteca (e espero que ainda esteja funcionando).

Como Usar
==============

Após o cliente preencher os dados, criptografe eles utilizando o seguinte código:

```php
  include "Itaucripto.php";
  
  $cripto = new Itaucripto();
  
  //Coloque o código da empresa em MAIÚSCULO
  $codEmp = "J1234567890123456789012345";
  //Coloque a chave de criptografia em MAIÚSCULO
  $chave = "ABCD123456ABCD12";
  
  //Preencha as variáveis abaixo com os dados do cliente e da cobrança
  //Abaixo é só um exemplo!
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
  
  $dados_criptografados = $cripto->geraDados($codEmp,$pedido,$valor,$observacao,$chave,$nomeSacado,
      $codigoInscricao,$numeroInscricao,$enderecoSacado,$bairroSacado,$cepSacado,$cidadeSacado,$estadoSacado,
      $dataVencimento,$urlRetorna,$obsAd1,$obsAd2,$obsAd3);
```

Campos
==============

```php
  $pedido // Identificação do pedido - máximo de 8 dígitos (12345678) - Obrigatório  
  $valor // Valor do pedido - máximo de 8 dígitos + vírgula + 2 dígitos - 99999999,99 - Obrigatório  
  $observacao // Observações - máximo de 40 caracteres  
  $nomeSacado // Nome do sacado - máximo de 30 caracteres  
  $codigoInscricao // Código de Inscrição: 01->CPF, 02->CNPJ  
  $numeroInscricao // Número de Inscrição: CPF ou CNPJ - até 14 caracteres  
  $enderecoSacado // Endereco do Sacado - máximo de 40 caracteres  
  $bairroSacado // Bairro do Sacado - máximo de 15 caracteres  
  $cepSacado // Cep do Sacado - máximo de 8 dígitos  
  $cidadeSacado // Cidade do sacado - máximo 15 caracteres  
  $estadoSacado // Estado do Sacado - 2 caracteres  
  $dataVencimento // Vencimento do título - 8 dígitos - ddmmaaaa  
  $urlRetorna // URL do retorno - máximo de 60 caracteres  
  $obsAdicional1 // ObsAdicional1 - máximo de 60 caracteres  
  $obsAdicional2 // ObsAdicional2 - máximo de 60 caracteres  
  $obsAdicional3 // ObsAdicional3 - máximo de 60 caracteres
```

Changelog
==============

* v0.1 - 30 de Janeiro de 2013

Classe Java descompilada e traduzida para PHP

* v0.2 - 01 de Fevereiro de 2013

Correções na função Algoritimo e Inicializa

Teste feito em ambiente de produção, geração de dados criptografados validada pelo Itaú Shopline

* v0.3 - 17 de Outubro de 2013

Correções na função Algoritimo - A chave de criptografia precisa estar sempre em maiúsculo, colocada função strtoupper para facilitar

Agora a decripto funciona corretamente

* v0.4 - 28 de Maio de 2014

Correção do uso da função substr dentro da função decripto. (Obrigado Jorge Marmion e lucaspacheco).


Author
==============

[R3C Web](http://www.r3c.com.br)

[@gabrielrcouto](http://www.twitter.com/gabrielrcouto)

Licença
==============

[MIT License](http://zenorocha.mit-license.org/)

<a target='_blank' rel='nofollow' href='https://app.codesponsor.io/link/bvezX9B9cTJTidmcB4iikNff/gabrielrcouto/php-itaucripto'>  <img alt='Sponsor' width='888' height='68' src='https://app.codesponsor.io/embed/bvezX9B9cTJTidmcB4iikNff/gabrielrcouto/php-itaucripto.svg' /></a>

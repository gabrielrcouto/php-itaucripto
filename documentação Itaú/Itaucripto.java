package Itau;

public class Itaucripto
{
  private int[] sbox;
  private int[] key;
  private String codEmp;
  private String numPed;
  private String tipPag;
  private String CHAVE_ITAU = "SEGUNDA12345ITAU";
  private int TAM_COD_EMP = 26;
  private int TAM_CHAVE = 16;
  private String dados;
  public String numbers = "0123456789";

  public Itaucripto()
  {
    this.sbox = new int[256];
    this.key = new int[256];

    this.numPed = "";
    this.tipPag = "";
    this.codEmp = "";
  }

  private String Algoritmo(String paramString1, String paramString2)
  {
    int k = 0;
    int m = 0;

    String str = "";
    Inicializa(paramString2);

    for (int j = 1; j <= paramString1.length(); j++) {
      k = (k + 1) % 256;
      m = (m + this.sbox[k]) % 256;
      int i = this.sbox[k];
      this.sbox[k] = this.sbox[m];
      this.sbox[m] = i;

      int n = this.sbox[((this.sbox[k] + this.sbox[m]) % 256)];

      int i1 = paramString1.charAt(j - 1) ^ n;
      str = str + (char)i1;
    }
    return str;
  }

  private String PreencheBranco(String paramString, int paramInt)
  {
    String str = paramString.toString();
    while (str.length() < paramInt)
      str = str + " ";
    return str.substring(0, paramInt);
  }

  private String PreencheZero(String paramString, int paramInt)
  {
    String str = paramString.toString();
    while (str.length() < paramInt)
      str = "0" + str;
    return str.substring(0, paramInt);
  }

  private void Inicializa(String paramString)
  {
    int m = paramString.length();
    for (int j = 0; j <= 255; j++) {
      this.key[j] = paramString.charAt(j % m);
      this.sbox[j] = j;
    }

    int k = 0;
    for (j = 0; j <= 255; j++) {
      k = (k + this.sbox[j] + this.key[j]) % 256;
      int i = this.sbox[j];
      this.sbox[j] = this.sbox[k];
      this.sbox[k] = i;
    }
  }

  private boolean isNumeric(String paramString)
  {
    if (paramString.length() > 1) {
      boolean bool = true;
      for (int i = 0; i < paramString.length(); i++)
      {
        bool = isNumeric(paramString.substring(i, i + 1));
        if (!bool) return bool;
      }
      return bool;
    }

    if (this.numbers.indexOf(paramString) >= 0) return true;
    return false;
  }

  private String Converte(String paramString)
  {
    char c = (char)(int)(26.0D * Math.random() + 65.0D);
    String str = "" + c;

    for (int i = 0; i < paramString.length(); i++)
    {
      int k = paramString.charAt(i);

      int j = k;

      str = str + Integer.toString(j);
      c = (char)(int)(26.0D * Math.random() + 65.0D);
      str = str + c;
    }
    return str;
  }

  private String Desconverte(String paramString)
  {
    String str1 = "";

    for (int i = 0; i < paramString.length(); i++) {
      String str2 = "";

      char c = paramString.charAt(i);

      while (Character.isDigit(c)) {
        str2 = str2 + paramString.charAt(i);
        i += 1;
        c = paramString.charAt(i);
      }

      if (str2.compareTo("") != 0) {
        int j = Integer.parseInt(str2);
        str1 = str1 + (char)j;
      }
    }
    return str1;
  }

  public String geraDados(String paramString1, String paramString2, String paramString3, String paramString4, String paramString5, String paramString6, String paramString7, String paramString8, String paramString9, String paramString10, String paramString11, String paramString12, String paramString13, String paramString14, String paramString15, String paramString16, String paramString17, String paramString18)
  {
    paramString1 = paramString1.toUpperCase();
    paramString5 = paramString5.toUpperCase();

    if (paramString1.length() != this.TAM_COD_EMP)
      return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
    if (paramString5.length() != this.TAM_CHAVE)
      return "Erro: tamanho da chave da chave diferente de 16 posições.";
    if ((paramString2.length() < 1) || (paramString2.length() > 8)) {
      return "Erro: número do pedido inválido.";
    }
    if (isNumeric(paramString2))
      paramString2 = PreencheZero(paramString2, 8);
    else {
      return "Erro: numero do pedido não é numérico.";
    }
    if ((paramString3.length() < 1) || (paramString3.length() > 11)) {
      return "Erro: valor da compra inválido.";
    }

    int i = paramString3.indexOf(',');
    if (i != -1)
    {
      String str3 = paramString3.substring(i + 1);
      if (!isNumeric(str3))
        return "Erro: valor decimal não é numérico.";
      if (str3.length() != 2) {
        return "Erro: valor decimal da compra deve possuir 2 posições após a virgula.";
      }
      paramString3 = paramString3.substring(0, paramString3.length() - 3) + str3;
    }
    else
    {
      if (!isNumeric(paramString3)) {
        return "Erro: valor da compra não é numérico.";
      }
      if (paramString3.length() > 8) {
        return "Erro: valor da compra deve possuir no máximo 8 posições antes da virgula.";
      }

      paramString3 = paramString3 + "00";
    }
    paramString3 = PreencheZero(paramString3, 10);

    paramString7 = paramString7.trim();
    if ((paramString7.compareTo("02") != 0) && (paramString7.compareTo("01") != 0) && (paramString7.compareTo("") != 0))
      return "Erro: código de inscrição inválido.";
    if ((paramString8.compareTo("") != 0) && (!isNumeric(paramString8)) && (paramString8.length() > 14)) {
      return "Erro: número de inscrição inválido.";
    }

    if ((paramString11.compareTo("") != 0) && ((!isNumeric(paramString11)) || (paramString11.length() != 8))) {
      return "Erro: cep inválido.";
    }

    if ((paramString14.compareTo("") != 0) && ((!isNumeric(paramString14)) || (paramString14.length() != 8)))
      return "Erro: data de vencimento inválida.";
    if (paramString16.length() > 60)
    {
      return "Erro: observação adicional 1 inválida.";
    }
    if (paramString17.length() > 60)
    {
      return "Erro: observação adicional 2 inválida.";
    }
    if (paramString18.length() > 60)
    {
      return "Erro: observação adicional 3 inválida.";
    }

    paramString4 = PreencheBranco(paramString4, 40);
    paramString6 = PreencheBranco(paramString6, 30);
    paramString7 = PreencheBranco(paramString7, 2);
    paramString8 = PreencheBranco(paramString8, 14);
    paramString9 = PreencheBranco(paramString9, 40);
    paramString10 = PreencheBranco(paramString10, 15);
    paramString11 = PreencheBranco(paramString11, 8);
    paramString12 = PreencheBranco(paramString12, 15);
    paramString13 = PreencheBranco(paramString13, 2);
    paramString14 = PreencheBranco(paramString14, 8);
    paramString15 = PreencheBranco(paramString15, 60);
    paramString16 = PreencheBranco(paramString16, 60);
    paramString17 = PreencheBranco(paramString17, 60);
    paramString18 = PreencheBranco(paramString18, 60);

    String str1 = Algoritmo(paramString2 + paramString3 + paramString4 + paramString6 + paramString7 + paramString8 + paramString9 + paramString10 + paramString11 + paramString12 + paramString13 + paramString14 + paramString15 + paramString16 + paramString17 + paramString18, paramString5);

    String str2 = Algoritmo(paramString1 + str1, this.CHAVE_ITAU);

    return Converte(str2);
  }

  public String geraCripto(String paramString1, String paramString2, String paramString3)
  {
    if (paramString1.length() != this.TAM_COD_EMP)
      return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
    if (paramString3.length() != this.TAM_CHAVE)
      return "Erro: tamanho da chave da chave diferente de 16 posições.";
    paramString2 = paramString2.trim();
    if (paramString2.compareTo("") == 0) {
      return "Erro: código do sacado inválido.";
    }

    String str1 = Algoritmo(paramString2, paramString3);

    String str2 = Algoritmo(paramString1 + str1, this.CHAVE_ITAU);

    return Converte(str2);
  }

  public String geraConsulta(String paramString1, String paramString2, String paramString3, String paramString4)
  {
    if (paramString1.length() != this.TAM_COD_EMP)
      return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
    if (paramString4.length() != this.TAM_CHAVE)
      return "Erro: tamanho da chave da chave diferente de 16 posições.";
    if ((paramString2.length() < 1) || (paramString2.length() > 8)) {
      return "Erro: número do pedido inválido.";
    }
    if (isNumeric(paramString2))
      paramString2 = PreencheZero(paramString2, 8);
    else
      return "Erro: numero do pedido não é numérico.";
    if ((paramString3.compareTo("0") != 0) && (paramString3.compareTo("1") != 0)) {
      return "Erro: formato inválido.";
    }

    String str1 = Algoritmo(paramString2 + paramString3, paramString4);

    String str2 = Algoritmo(paramString1 + str1, this.CHAVE_ITAU);

    return Converte(str2);
  }

  public String decripto(String paramString1, String paramString2)
  {
    paramString1 = Desconverte(paramString1);
    String str = Algoritmo(paramString1, paramString2);

    this.codEmp = str.substring(0, 26);

    this.numPed = str.substring(26, 34);

    this.tipPag = str.substring(34, 36);
    return str;
  }

  public String retornaCodEmp()
  {
    return this.codEmp;
  }

  public String retornaPedido()
  {
    return this.numPed;
  }

  public String retornaTipPag()
  {
    return this.tipPag;
  }

  public String geraDadosGenerico(String paramString1, String paramString2, String paramString3)
  {
    paramString1 = paramString1.toUpperCase();
    paramString3 = paramString3.toUpperCase();

    if (paramString1.length() != this.TAM_COD_EMP)
    {
      return "Erro: tamanho do codigo da empresa diferente de 26 posições.";
    }
    if (paramString3.length() != this.TAM_CHAVE)
    {
      return "Erro: tamanho da chave da chave diferente de 16 posições.";
    }
    if (paramString2.length() < 1)
    {
      return "Erro: sem dados.";
    }

    String str1 = Algoritmo(paramString2, paramString3);

    String str2 = Algoritmo(paramString1 + str1, this.CHAVE_ITAU);

    return Converte(str2);
  }
}
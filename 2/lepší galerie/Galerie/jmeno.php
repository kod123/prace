<head>
  <meta charset="utf-8" />
  <title>Ověřovací kód</title>
   <link rel="stylesheet" href="styly/styl-jmeno.css" /> 
   <!--Script pro zachování údajů v polích hmtl, pokud došlo k vyvolání chyby-->
   <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js" type="text/javascript"></script>
   <script src="javascript/zachovani/rls.js" type="text/javascript"></script>
</head>
<body>
 <div id="obal">
     <form method="POST" action="jmeno.php" enctype="multipart/form-data">
     <fieldset>
       <h2 class="email">Obnovení uživatelského jména</h2>
         <ul>
           <li>
           <label for="email">E-mail<span class="povinne">*</span>:</label>
            <input type="email" id="email" name="email" class="velke" placeholder="Zadejte uživatelský e-mail" required="required" autofocus="autofocus" data-rls-id="email"/>
           </li>           
           <li>
            <label for="heslo">Heslo<span class="povinne">*</span>:</label>
            <input type="password" id="heslo" name="heslo" class="velke" placeholder="Zadejte uživatelské heslo" required="required" data-rls-id="heslo"/>
            <p id="popisPovinne"><span class="povinne">*</span> povinné údaje</p>
          </li>
         </ul>  
     </fieldset> 
      
     <fieldset>
        <input type="submit" class="vytvorit_ucet" value="Potvrdit" name="tlacitko"/>
        <a href="prihlaseni.php" id="prihlaseni">Přihlásit se</a>
     </fieldset>

<?php
// Třída pro připojení databáze
class mojeMysql extends mysqli
{
   public function __construct($adresa, $login, $heslo, $db)
   {
      parent::__construct($adresa, $login, $heslo, $db);                      
      $this->set_charset("utf8");
   }
} 
?>

<?php
// Třída, která převezme vstup od uživatele
class informace
{
  public $kodChyby = 0;
  
  public function __construct()
  {
    $zavolaniChyb = new informaceChyby;
    if(empty($_POST["email"]) && isset($_POST["tlacitko"]))
    {
      $this->kodChyby = 1;
      $zavolaniChyb->VypsaniChybVstupu($this->kodChyby);
    }
    elseif(empty($_POST["heslo"]) && isset($_POST["tlacitko"]))
    {
      $this->kodChyby = 2;
      $zavolaniChyb->VypsaniChybVstupu($this->kodChyby);
    }
    else
    {
      if(isset($_POST["email"]) && isset($_POST["heslo"]) && isset($_POST["tlacitko"]))
      {
         $this->PredaniVstupu();   
      }
    }
  }
  
   public function PredaniVstupu()
   {
     $emailVstup = $_POST["email"];
     $hesloVstup = $_POST["heslo"];
  
     $predani = new obnovaJmena($emailVstup, $hesloVstup);
   }
}

// Třída pro samotné zpracování obnovy jména
class obnovaJmena
{
  private $server = "vyuka.pslib.cz";
  private $jmenoServer = "P3";
  private $hesloServer = "p3";
  private $databazeServer = "piskoviste_P3";

  public $emailV;
  public $hesloV;
  
  public $shodaEmailHeslo;
  public $uzivatel;
  
  public $kodInformaci = 0;
  
  public function __construct($emailVstup, $hesloVstup)
  {
     $this->emailV = $emailVstup;
     $this->hesloV = hash("sha256",$hesloVstup);
     $this->PripojeniServer();
  }

  public function PripojeniServer()
  {
    $mojeMysql = new mojeMysql($this->server, $this->jmenoServer, $this->hesloServer, $this->databazeServer);
         
    if ($mojeMysql->connect_error) 
    { 
        'Při připojení došlo k chybě: ' . $mojeMysql->connect_error . '. Číslo 
         chyby: ' .$mojeMysql->connect_errno; 
    }
     else
    {  
        $this->DotazMysql($mojeMysql);         
    } 
  }
  
  public function DotazMysql($mojeMysql)
  {
    $shodaEmailHesloMysql = $mojeMysql->query("SELECT COUNT(*) AS cisloEmailHeslo FROM labovsky_prihlaseni WHERE email='$this->emailV' AND heslo='$this->hesloV'");   // Nalezení shody e-mailu a hesla 
    $vyberUzivatel = $mojeMysql->query("SELECT uzivatel FROM labovsky_prihlaseni WHERE email='$this->emailV' AND heslo='$this->hesloV'"); 
    
    $this->Zpracovani($shodaEmailHesloMysql, $vyberUzivatel);
  }
  
  public function Zpracovani($shodaEmailHesloMysql, $vyberUzivatel)
  {    
      while($radek = $shodaEmailHesloMysql->fetch_array(MYSQLI_ASSOC))
      {
	       $this->shodaEmailHeslo=$radek['cisloEmailHeslo'];
      }
      
      if($this->shodaEmailHeslo == 1)
      {
      
       while($radek = $vyberUzivatel->fetch_array(MYSQLI_ASSOC))
      {
	       $this->uzivatel=$radek["uzivatel"];
      }
         echo("<p data-rls-clear='email'></p>");
         echo("<p data-rls-clear='heslo'></p>");
         
         $shodaEmailHesloMysql->Close();
         $vyberUzivatel->Close();
         
         $this->PoslaniEmail();
      }
      else
      {
        $this->kodInformaci = 2;
        $zavolaniNeuspesne = new informaceChyby();
        $zavolaniNeuspesne->VypsaniInformaci($this->kodInformaci);     
      }
  }
  
  public function PoslaniEmail()
  {
      $predmet = "=?utf-8?B?".base64_encode("Uživatelské jméno - galerie PHP")."?=";
      $hlavicka = "MIME-Version: 1.0\n";
      $hlavicka .= "Content-Type: text/plain; charset=utf-8\n";
      $hlavicka .= "From: =?UTF-8?B?".base64_encode("Server galerie")."?=<server.galerie>";
      $zprava = "\n Vaše uživatelské jméno: ".$this->uzivatel;
      mail ("roman.labovsky@pslib.cz", $predmet, $zprava, $hlavicka);
      
      $this->kodInformaci = 1;
      $zavolaniUspesne = new informaceChyby();
      $zavolaniUspesne->VypsaniInformaci($this->kodInformaci);
  }
}

class informaceChyby
{
   public $emailChybaVstup = "Musíte vyplnit e-mail!!!";
   public $hesloChybaVstup = "Musíte vyplnit heslo!!!";

   public $uspechInformace = "<p id='ulozeno'>Bylo Vám na e-mail posláno uživatelské jméno.</p>";
   public $chybaInformace = "<p class='chyba' id='uzivatelEmail'>Špatně zadaný  e-mail nebo heslo!!!</p>";
   
   public function VypsaniChybVstupu($chyba)
   {
     if($chyba == 1)
     {
        echo $this->emailChybaVstup;
     }
     if($chyba == 2)
     {
        echo $this->hesloChybaVstup;
     }
   }
   
   public function VypsaniInformaci($kod)
   {
     if($kod == 1)
     {
        echo $this->uspechInformace;
     }
     if($kod == 2)
     {
        echo $this->chybaInformace;
     }
   }
}

  $volani = new informace();
  
?>

   </form>
  </div> 
</body>
</html>
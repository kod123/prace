<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Ověřovací kód</title>
   <link rel="stylesheet" href="styly/styl-heslo.css" /> 
   <!--Script pro zachování údajů v polích hmtl, pokud došlo k vyvolání chyby-->
   <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js" type="text/javascript"></script>
   <script src="javascript/zachovani/rls.js" type="text/javascript"></script>
</head>
<body>
 <div id="obal">
     <form method="POST" action="heslo.php" enctype="multipart/form-data">
     <fieldset>
       <h2 class="email">Obnovení hesla</h2>
         <ul>
           <li>
           <label for="email">Uživatel<span class="povinne">*</span>:</label>
            <input type="text" id="uzivatel" name="uzivatel" class="velke" placeholder="Zadejte uživatelské jméno" required="required" autofocus="autofocus" data-rls-id="uzivatel"/>
           </li>
           <li>
           <label for="email">E-mail<span class="povinne">*</span>:</label>
            <input type="email" id="email" name="email" class="velke" placeholder="Zadejte uživatelský e-mail" required="required" data-rls-id="email"/>
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
    if(empty($_POST["uzivatel"]) && isset($_POST["tlacitko"]))
    {
      $this->kodChyby = 1;
      $zavolani = new informaceChyby;
      $zavolani->VypsaniChybVstupu($this->kodChyby);
    }
    elseif(empty($_POST["email"]) && isset($_POST["tlacitko"]))
    {
      $this->kodChyby = 2;
      $zavolani = new informaceChyby;
      $zavolani->VypsaniChybVstupu($this->kodChyby);
    }
    else
    {
      if(isset($_POST["email"])&& isset($_POST["tlacitko"]))
      {
         $this->PredaniVstupu();   
      }
    } 
  }
  
    public function PredaniVstupu()
    {
      $uzivatelVstup = $_POST["uzivatel"];
      $emailVstup = $_POST["email"];

      $predaniEmail = new obnovaHesla($uzivatelVstup, $emailVstup);
    }
}

// Třída pro samotné zpracování obnovy hesla
class obnovaHesla
{
  private $server = "vyuka.pslib.cz";
  private $jmenoServer = "P3";
  private $hesloServer = "p3";
  private $databazeServer = "piskoviste_P3";
  
  public $uzivatelV;
  public $emailV;
  public $shodaUzivatelEmail;
  public $kod;
  
  public $kodChyb = 0;
  
  public function __construct($uzivatelVstup, $emailVstup)
  {
     $this->uzivatelV = $uzivatelVstup;
     $this->emailV = $emailVstup;
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
  
  public function GenerovaniKod()
  {
     $znaky = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
     $pocet = mb_strlen($znaky);

     for ($i = 0, $kod = ''; $i < 20; $i++) 
     {
        $index = rand(0, $pocet - 1);
        $this->kod .= mb_substr($znaky, $index, 1);
     }  
  }
  
  public function DotazMysql($mojeMysql)
  {     
     $shodaMysql = $mojeMysql->query("SELECT COUNT(*) AS cisloUzivatelEmail FROM labovsky_prihlaseni WHERE email='$this->emailV' AND uzivatel='$this->uzivatelV'");
     
     $this->Zpracovani($shodaMysql, $mojeMysql);
  }
  
  public function Zpracovani($shodaMysql, $mojeMysql)
  {
      $this->GenerovaniKod(); 
      $hesloZaheslovani = hash("sha256", $this->kod);
      
      while($radek = $shodaMysql->fetch_array(MYSQLI_ASSOC))
      {
	       $this->shodaUzivatelEmail=$radek['cisloUzivatelEmail'];
      }
     
      if($this->shodaUzivatelEmail == 1)
      {   
         $mojeMysql->query("UPDATE labovsky_prihlaseni SET heslo='$hesloZaheslovani' WHERE email='$this->emailV' AND uzivatel='$this->uzivatelV'"); 
         
         echo("<p data-rls-clear='uzivatel'></p>");           
         echo("<p data-rls-clear='email'></p>");
         $shodaMysql->Close();
         $mojeMysql->Close();
         
         $this->PoslaniEmail();
       }
       else
       {
         $this->kodChyb = 2;
         $zavolaniNeuspesne = new informaceChyby();
         $zavolaniNeuspesne->VypsaniInformaci($this->kodChyb);
       }
  }
  
  public function PoslaniEmail()
  {
      $predmet = "=?utf-8?B?".base64_encode("Obnova hesla - galerie PHP")."?=";
      $hlavicka = "MIME-Version: 1.0\n";
      $hlavicka .= "Content-Type: text/plain; charset=utf-8\n";
      $hlavicka .= "From: =?UTF-8?B?".base64_encode("Server galerie")."?=<server.galerie>";
      $zprava = "\n Vaše nové heslo: ".$this->kod."\n Po přihlášení změnte své heslo!!!";
      mail ("roman.labovsky@pslib.cz", $predmet, $zprava, $hlavicka);
      
      $this->kodChyb = 1;
      $zavolaniUspesne = new informaceChyby();
      $zavolaniUspesne->VypsaniInformaci($this->kodChyb);
  }
}

class informaceChyby
{
  public $emailChybaVstup = "Musíte vyplnit e-mail!!!";
  public $uzivatelChybaVstup = "Musíte vyplnit uživatelské jméno!!!";
  
  public $odeslanoEmail = "<p id='ulozeno'>Bylo Vám na email odesláno nové heslo.</p>";
  public $chybaUzivatelEmail = "<p class='chyba' id='uzivatelEmail'>Špatně zadané uživatelské jméno nebo e-mail!!!</p>";
   
  public function VypsaniChybVstupu($kod)
  {
      if($kod == 1)
      {
         echo $this->uzivatelChybaVstup;
      }
      if($kod == 2)
      {
         echo $this->emailChybaVstup;
      }
  }
  
  public function VypsaniInformaci($kod)
  {
     if($kod == 1)
     {
        echo $this->odeslanoEmail;
     }
     if($kod == 2)
     {
        echo $this->chybaUzivatelEmail;
     }
  }
}

 $volani = new informace();
 
?>

   </form>
  </div> 
</body>
</html>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Registrace uživatele</title>
  <link rel="stylesheet" href="styly/styl-registrace.css" />
  <!--Script pro zachování údajů v polích hmtl, pokud došlo k vyvolání chyby-->
  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js" type="text/javascript"></script>
  <script src="javascript/zachovani/rls.js" type="text/javascript"></script>
</head>
 <body>
  <div id="obal">
    <h1>Vytvoření nového účtu</h1>

    <form method="POST" action="registrace.php" enctype="multipart/form-data">
      <fieldset>
        <h2 class="ucet">Účet</h2>
        <ul>
          <li>
            <label for="jmeno">Jméno<span class="povinne">*</span>:</label>
            <input type="text" id="jmeno" name="jmeno" class="velke" placeholder="Zadejte své jméno" required="required" autofocus="autofocus" data-rls-id="jmeno"/>
          </li>
          <li>
            <label for="prijmeni">Příjmení<span class="povinne">*</span>:</label>
            <input type="text" id="prijmeni" name="prijmeni" class="velke" placeholder="Zadejte své přijmení" required="required" data-rls-id="prijmeni"/>
          </li>
          <li>
            <label for="uzivatel">Uživatelské jméno<span class="povinne">*</span>:</label>
            <input type="text" id="prijmeni" name="uzivatel" class="velke" placeholder="Zadejte své uživatelské jméno" required="required" data-rls-id="uzivatel"/>
          </li>
          <li>
            <label for="email">E-mail<span class="povinne">*</span>:</label>
            <input type="email" id="email" name="email" class="velke" placeholder="Zadejte svůj e-mail" required="required" data-rls-id="email"/>
          </li> 
          <li>
            <label for="heslo">Heslo<span class="povinne">*</span>:</label>
            <input type="password" id="heslo" name="heslo" placeholder="Zadejte nové heslo" required="required" data-rls-id="heslo"/>
          </li>
          <li>
            <label for="password">Potvrzení hesla<span class="povinne">*</span>:</label>
            <input type="password" id="heslo2" name="hesloPotvrzeni" placeholder="Potvrďte své heslo" required="required" data-rls-id="hesloPotvrzeni"/>
            <p id="popisPovinne"><span class="povinne">*</span> povinné údaje</p>
          </li>  
        </ul> 
      </fieldset>
      
      <fieldset>
        <input type="submit" class="vytvorit_ucet" value="Vytvořit účet" name="tlacitko"/>
        <a href="prihlaseni.php" id="prihlaseni">Přihlásit se</a>
      </fieldset>
      
<?php
// Třída pro připojení databáze
class mojeMysql extends mysqli
  {
		public function __construct($adresa, $login, $heslo, $db)
		{
			parent::__construct($adresa, $login, $heslo, $db);
			$this->set_charset('utf8');
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
      $zavolani = new informaceChyby();
      if(empty($_POST["jmeno"]) && isset($_POST["tlacitko"]))
      {
          $this->kodChyby = 1;
          $zavolani->VypsaniChybVstupu($this->kodChyby); 
      }
      elseif(empty($_POST["prijmeni"]) && isset($_POST["tlacitko"]))
      {
           $this->kodChyby = 2;
           $zavolani->VypsaniChybVstupu($this->kodChyby);   
      }
      elseif(empty($_POST["uzivatel"]) && isset($_POST["tlacitko"]))
      {
           $this->kodChyby = 3;
           $zavolani->VypsaniChybVstupu($this->kodChyby);      
      }
       elseif(empty($_POST["email"]) && isset($_POST["tlacitko"]))
      {   
           $this->kodChyby = 4;
           $zavolani->VypsaniChybVstupu($this->kodChyby); 
      }
      elseif(empty($_POST["heslo"]) && isset($_POST["tlacitko"]))
      {
           $this->kodChyby = 5;
           $zavolani->VypsaniChybVstupu($this->kodChyby);    
      }
      elseif(empty($_POST["hesloPotvrzeni"]) && isset($_POST["tlacitko"]))
      {  
           $this->kodChyby = 6;
           $zavolani->VypsaniChybVstupu($this->kodChyby); 
      }
      else
      {
        if(isset($_POST["jmeno"]) && isset($_POST["prijmeni"]) && isset($_POST["uzivatel"]) && isset($_POST["email"]) && isset($_POST["heslo"]) && isset($_POST["hesloPotvrzeni"]))
         {
            $this->PredaniVstupu();
         }
      }    
    }
    
    public function PredaniVstupu()
    {
       $jmenoVstup = $_POST["jmeno"];
       $prijmeniVstup = $_POST["prijmeni"];
       $uzivatelVstup = $_POST["uzivatel"];
       $emailVstup = $_POST["email"];
       $hesloVstup = hash("sha256", $_POST["heslo"]);
       $hesloPotvrzeniVstup = hash("sha256", $_POST["hesloPotvrzeni"]); 
             
       $pocetZnakuHeslo = strlen($_POST["heslo"]);
    
       $zaregistruj = new registrace($jmenoVstup,  $prijmeniVstup, $uzivatelVstup, $emailVstup, $hesloVstup, $hesloPotvrzeniVstup, $pocetZnakuHeslo); 
    }
}

// Třída pro samotné zpracování registrace
class registrace
{
  public $jmenoV;
  public $prijmeniV;
  public $uzivatelV;
  public $emailV;
  public $hesloV;
  public $hesloPotvrzeniV;
  public $pocetZnakuH;
  
  public $shodaUzivatel;
  public $shodaUzivatel2;
  public $shodaEmail;
  public $kod;
  
  public $kodChyby = 0;
   
  public function __construct($jmenoVstup, $prijmeniVstup, $uzivatelVstup, $emailVstup, $hesloVstup, $hesloPotvrzeniVstup, $pocetZnakuHeslo)
  {
	    $this->jmenoV = $jmenoVstup;
      $this->prijmeniV = $prijmeniVstup;
      $this->uzivatelV = $uzivatelVstup;
      $this->emailV = $emailVstup;
      $this->hesloV = $hesloVstup;
      $this->hesloPotvrzeniV = $hesloPotvrzeniVstup;
      $this->pocetZnakuH = $pocetZnakuHeslo;
      $this->PripojeniServer();
  }
   
  // Metoda pro zavolání připojovací třídy k databázi + vypsání přípádné chyby při nenavázání spojení  
   public function PripojeniServer()
   {
      $mojeMysql = new mojeMysql('vyuka.pslib.cz', 'P3', 'p3', 'piskoviste_P3');
  	  if ($mojeMysql->connect_error) 
  	  { 
         	die('Při připojení došlo k chybě: ' . $mojeMysql->connect_error . '. Číslo chyby: ' . $mojeMysql->connect_errno); 
  	  }
         $this->DotazMysql($mojeMysql);   
   }  
   
   public function DotazMysql($mojeMysql)
   {
     $shodaUzivatelMysql = $mojeMysql->query("SELECT COUNT(*) AS cisloUzivatel FROM labovsky_prihlaseni WHERE uzivatel='$this->uzivatelV'");
     $shodaEmailMysql = $mojeMysql->query("SELECT COUNT(*) AS cisloEmail FROM labovsky_prihlaseni WHERE email='$this->emailV'");
     
     $this->Kontrola($shodaUzivatelMysql, $shodaEmailMysql, $mojeMysql);
   }
   
   public function Kontrola($shodaUzivatelMysql, $shodaEmailMysql, $mojeMysql)
   {        
      while($radek = $shodaUzivatelMysql->fetch_array())
	    {
	        $this->shodaUzivatel=$radek['cisloUzivatel'];
	    } 
         
      while($radek = $shodaEmailMysql->fetch_array())
      {
	        $this->shodaEmail=$radek['cisloEmail'];
      }  
       
      $zavolaniChyb = new informaceChyby();         
      if($this->shodaUzivatel!=0)
      {
         $this->kodChyby = 1;
         $zavolaniChyb->KontrolaParametru($this->kodChyby); 
      }
      elseif($this->shodaEmail!=0)
      {
       $this->kodChyby = 2;
         $zavolaniChyb->KontrolaParametru($this->kodChyby);
      }
      elseif($this->pocetZnakuH < 8)
      {
         $this->kodChyby = 3;
         $zavolaniChyb->KontrolaParametru($this->kodChyby);
      } 
      elseif($this->hesloV != $this->hesloPotvrzeniV)
      {
         $this->kodChyby = 4;
         $zavolaniChyb->KontrolaParametru($this->kodChyby); 
      }
      else
      {
          $shodaUzivatelMysql->Close();
          $shodaEmailMysql->Close();
          $this->ZpracovaniRegistrace($mojeMysql);
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

  public function ZpracovaniRegistrace($mojeMysql)
  {    
     $this->GenerovaniKod();
  /*if(isset($_POST["jmeno"]) && isset($_POST["prijmeni"]) && isset($_POST["uzivatel"]) && isset($_POST["email"]) && isset($_POST["heslo"]) && empty($_POST["hesloPotvrzeni"]) && isset($_POST["tlacitko"]))
  {
    echo ("Musíte potvrdit heslo!!!");
  } 
  elseif(isset($_POST["jmeno"]) && isset($_POST["prijmeni"]) && isset($_POST["uzivatel"]) && isset($_POST["email"]) && empty($_POST["heslo"]) && isset($_POST["hesloPotvrzeni"]) && isset($_POST["tlacitko"]))
  {
    echo ("Musíte vyplnit heslo!!!");
  } 
  elseif(isset($_POST["jmeno"]) && isset($_POST["prijmeni"]) && isset($_POST["uzivatel"]) && empty($_POST["email"]) && isset($_POST["heslo"]) && isset($_POST["hesloPotvrzeni"]) && isset($_POST["tlacitko"]))
  {
    echo ("Musíte vyplnit email!!!");
  } 
  elseif(isset($_POST["jmeno"]) && isset($_POST["prijmeni"]) && empty($_POST["uzivatel"]) && isset($_POST["email"]) && isset($_POST["heslo"]) && isset($_POST["hesloPotvrzeni"]) && isset($_POST["tlacitko"]))
  {
    echo ("Musíte vyplnit uživatelské jméno!!!");
  }
  elseif(isset($_POST["jmeno"]) && empty($_POST["prijmeni"]) && isset($_POST["uzivatel"]) && isset($_POST["email"]) && isset($_POST["heslo"]) && isset($_POST["hesloPotvrzeni"]) && isset($_POST["tlacitko"]))
  {
    echo ("Musíte vyplnit příjmení!!!");
  }  
  elseif(empty($_POST["jmeno"]) && isset($_POST["prijmeni"]) && isset($_POST["uzivatel"]) && isset($_POST["email"]) && isset($_POST["heslo"]) && isset($_POST["hesloPotvrzeni"]) && isset($_POST["tlacitko"]))
  {
    echo ("Musíte vyplnit jméno!!!");
  }  */
     
     // Jméno a příjmení bude začínat vždy na velké písmeno
     $jmenoVstupVelke = mb_convert_case($this->jmenoV, MB_CASE_TITLE, "UTF-8");           
     $prijmeniVstupVelke =  mb_convert_case($this->prijmeniV, MB_CASE_TITLE, "UTF-8");    
              
     $mojeMysql->query("INSERT INTO labovsky_prihlaseni (aktivace, uzivatel, jmeno, prijmeni, heslo, email, datum, kod) VALUES ('0', '$this->uzivatelV','$jmenoVstupVelke','$prijmeniVstupVelke','$this->hesloV', '$this->emailV', NOW(), '$this->kod')"); 
       
     // Vymazání informací z polí html
     echo("<p data-rls-clear='jmeno'></p>");
     echo("<p data-rls-clear='prijmeni'></p>");
     echo("<p data-rls-clear='uzivatel'></p>");
     echo("<p data-rls-clear='email'></p>");
     echo("<p data-rls-clear='heslo'></p>");
     echo("<p data-rls-clear='hesloPotvrzeni'></p>");
     $mojeMysql->Close();
     $this->PoslaniEmail();     
   }
   
   public function PoslaniEmail()
   {
     $predmet = "=?utf-8?B?".base64_encode("Dokončení registrace - galerie PHP")."?=";
     $hlavicka = "MIME-Version: 1.0\n";
     $hlavicka .= "Content-Type: text/plain; charset=utf-8\n";
     $hlavicka .= "From: =?UTF-8?B?".base64_encode("Server galerie")."?=<server.galerie>";
     $zprava = "Dokončení registrace: \n Uživatel: ".$this->uzivatelV."\n Pro dokončení klikněte zde: http://www.pslib.cz/roman.labovsky/Galerie/kod.php?id=".$this->kod;
     mail ("roman.labovsky@pslib.cz", $predmet, $zprava, $hlavicka);
     
     $this->kodChyby = 5;
     $zavolaniUspesne = new informaceChyby(); 
     $zavolaniUspesne-> KontrolaParametru($this->kodChyby);
   }
 }

class informaceChyby
{
    public $jmenoChybaVstup = "Musíte vyplnit jméno!!!";
    public $prijmeniChybaVstup = "Musíte vyplnit příjmení!!!";
    public $uzivatelChybaVstup = "Musíte vyplnit uživatelské jméno!!!";
    public $emailChybaVstup = "Musíte vyplnit email!!!";
    public $hesloChybaVstup = "Musíte vyplnit heslo!!!";
    public $hesloPotvrzeniChybaVstup = "Musíte potvrdit heslo!!!";
    
    public $uzivatelChybaParametr = "<p class='chyba' id='uzivatelPouziti'>Zadané uživatelské jméno je již použité!!!</p>";    
    public $emailChybaParametr = "<p class='chyba' id='uzivatelEmail'>Zadaný e-mail je již použitý!!!</p>"; 
    public $hesloChybaParametr = "<p class='chyba' id='uzivatelHeslo'>Heslo musí mít minimálně 8 znaků!!!</p>";
    public $hesloPotvrzeniChybaParametr = "<p class='chyba' id='neshodaHesel'>Hesla se neshodují!!!</p>";
    public $uspesneUlozenoParametr = "<p id='ulozeno'>Byl Vám poslán dokončovací e-mail.</p>";
     
    public function VypsaniChybVstupu($chyba)
    {
      switch($chyba)
      {
        case 1:
          echo $this->jmenoChybaVstup;
          break;
        case 2:
          echo $this->prijmeniChybaVstup;
          break;
        case 3:
          echo $this->uzivatelChybaVstup;
          break;
        case 4:
          echo $this->emailChybaVstup;
          break;
        case 5:
          echo $this->hesloChybaVstup;
          break;
        case 6:
          echo $this->hesloPotvrzeniChybaVstup;
          break;
      }  
    }
    
    public function KontrolaParametru($par)
    {
      switch($par)
      {
        case 1:
          echo $this->uzivatelChybaParametr;
          break;
        case 2:
          echo $this->emailChybaParametr;
          break;
        case 3:
          echo $this->hesloChybaParametr;
          break;
        case 4:
          echo $this->hesloPotvrzeniChybaParametr;
          break;
        case 5:
          echo $this->uspesneUlozenoParametr;
          break;
      }
    }
} 
 
  $volani = new informace();
 
?> 
     
    </form>    
  </div>
</body>
</html>
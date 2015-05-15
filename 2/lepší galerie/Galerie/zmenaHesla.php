<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Registrace uživatele</title>
  <link rel="stylesheet" href="styly/styl-zmenaHesla.css" />
  <!--Script pro zachování údajů v polích hmtl, pokud došlo k vyvolání chyby-->
  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js" type="text/javascript"></script>
  <script src="javascript/zachovani/rls.js" type="text/javascript"></script>
</head>
 <body>
  <div id="obal">
    
    <form method="POST" action="zmenaHesla.php" enctype="multipart/form-data">
      <fieldset>
        <h2 class="ucet">Změna hesla</h2>
        <ul>
          <li>
            <label for="jmeno">Staré heslo<span class="povinne">*</span>:</label>
            <input type="password" id="stareHeslo" name="stareHeslo" class="velke" placeholder="Zadejte staré heslo" required="required" autofocus="autofocus" data-rls-id="stareHeslo"/>
          </li>
          <li>
            <label for="prijmeni">Nové heslo<span class="povinne">*</span>:</label>
            <input type="password" id="noveHeslo" name="noveHeslo" class="velke" placeholder="Zadejte nové heslo" required="required" data-rls-id="noveHeslo"/>
          </li>
          <li>
            <label for="uzivatel">Potvrzení hesla<span class="povinne">*</span>:</label>
            <input type="password" id="potvrzeniHesla" name="potvrzeniHesla" class="velke" placeholder="Potvrďte nové heslo" required="required" data-rls-id="potvrzeniHesla"/>
            <p id="popisPovinne"><span class="povinne">*</span> povinné údaje</p>
          </li>
          </ul>
      </fieldset>

      <fieldset>
        <input type="submit" class="vytvorit_ucet" value="Odeslat" name="tlacitko"/>
        <a href="galerie.php" id="prihlaseni" >Zpět do galerie</a>
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
    session_start();
    if( $_SESSION["user_is_logged"] !== 1)
    {
       header("Location: prihlaseni.php");
    }
    else
    {
      $zavolaniChyb = new informaceChyby();
      if(empty($_POST["stareHeslo"]) && isset($_POST["tlacitko"]))
      {
         $this->kodChyby = 1;
         $zavolaniChyb->VypsaniChybVstupu($this->kodChyby);
      }
      elseif(empty($_POST["noveHeslo"]) && isset($_POST["tlacitko"]))
      {
         $this->kodChyby = 2;
         $zavolaniChyb->VypsaniChybVstupu($this->kodChyby);
      }
      elseif(empty($_POST["potvrzeniHesla"]) && isset($_POST["tlacitko"]))
      {
         $this->kodChyby = 3;
         $zavolaniChyb->VypsaniChybVstupu($this->kodChyby);
      }
      else
      {
        if(isset($_POST["stareHeslo"]) && isset($_POST["noveHeslo"]) && isset($_POST["potvrzeniHesla"]) && isset($_POST["tlacitko"]))
        {
          $this->PredaniVstupu();
        }
      }
    }
  }
  
  public function PredaniVstupu()
  {
        $stareHesloVstup =  hash("sha256",$_POST["stareHeslo"]);
        $noveHesloVstup =  hash("sha256",$_POST["noveHeslo"]);
        $potvrzeniHeslaVstup =  hash("sha256",$_POST["potvrzeniHesla"]);
        
        $pocetZnakuHeslo = strlen($_POST["noveHeslo"]);
        
        $predani = new zmenaHesla($stareHesloVstup, $noveHesloVstup, $potvrzeniHeslaVstup, $pocetZnakuHeslo); 
  }
}

// Třída pro samotné zpracování změny hesla
class zmenaHesla
{
  private $server = "vyuka.pslib.cz";
  private $jmenoServer = "P3";
  private $hesloServer = "p3";
  private $databazeServer = "piskoviste_P3";
  
  public $stareHesloV;
  public $noveHesloV;
  public $potvrzeniHeslaV;
  public $shodaStareHeslo;
  public $uzivatel;
  public $pocetZnakuH;
  
  public $kodChyby = 0;
  
  public function __construct($stareHesloVstup, $noveHesloVstup, $potvrzeniHeslaVstup, $pocetZnakuHeslo)
  {  
     $this->stareHesloV = $stareHesloVstup;
     $this->noveHesloV = $noveHesloVstup;
     $this->potvrzeniHeslaV = $potvrzeniHeslaVstup;
     $this->pocetZnakuH = $pocetZnakuHeslo;
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
  
  public function ZjisteniUzivatele()
  {  
    
     $this->uzivatel = $_SESSION["uzivatel"]; 
  }
  
  public function DotazMysql($mojeMysql)
  {
     $this->ZjisteniUzivatele();
     
     $shodaStareHesloHesloMysql = $mojeMysql->query("SELECT COUNT(*) AS cisloStareHeslo FROM labovsky_prihlaseni WHERE uzivatel='$this->uzivatel' AND heslo='$this->stareHesloV'");
   
     $this->Zpracovani($shodaStareHesloHesloMysql, $mojeMysql);
  }
    
  public function Zpracovani($shodaStareHesloHesloMysql, $mojeMysql)
  { 
    $zavolaniInformaci = new informaceChyby();   

       while($radek = $shodaStareHesloHesloMysql->fetch_array(MYSQLI_ASSOC))
       {
  	      $this->shodaStareHeslo=$radek['cisloStareHeslo'];
       }
          
       if($this->shodaStareHeslo == 1)
       {
        if($this->pocetZnakuH > 8)
        {
          if($this->noveHesloV == $this->potvrzeniHeslaV)
          {           
             $mojeMysql->query("UPDATE labovsky_prihlaseni SET heslo='$this->noveHesloV' WHERE uzivatel='$this->uzivatel'");   
                       
             echo("<p data-rls-clear='stareHeslo'></p>"); 
             echo("<p data-rls-clear='noveHeslo'></p>"); 
             echo("<p data-rls-clear='potvrzeniHesla'></p>"); 
             
             $shodaStareHesloHesloMysql->Close(); 
             $mojeMysql->Close();
             
             $this->kodChyby = 1;
             $zavolaniInformaci->VypsaniInformaci($this->kodChyby);
          }
          else
          {
             $this->kodChyby = 2;
             $zavolaniInformaci->VypsaniInformaci($this->kodChyby);         
          }   
       }
       else
       {
             $this->kodChyby = 4;
             $zavolaniInformaci->VypsaniInformaci($this->kodChyby);   
       }
      }
      else
      {
            $this->kodChyby = 3;
            $zavolaniInformaci->VypsaniInformaci($this->kodChyby);  
      } 
  }
   
}

class informaceChyby
{
    public $stareHesloVstup = "Musíte vyplnit staré heslo!!!";
    public $noveHesloVstup = "Musíte vyplnit nové heslo!!!";
    public $potvrzeniHeslaVtup = "Musíte potvrdit nové heslo!!!";
    
    public $informaceVPoradku = "<p id='ulozeno'>Heslo bylo změněno.</p>";
    public $chybaNoveHeslo = "<p class='chyba' id='uzivatelEmailHeslo'>Nové heslo a potvrzení hesla se neschodují!!!</p>";
    public $chybaStareHeslo = "<p class='chyba' id='uzivatelHeslo'>Špatně zadané staré heslo!!!</p>";
    public $hesloChybaPocet = "<p class='chyba' id='zmenaHesla'>Nové heslo musí mít minimálně 8 znaků!!!</p>";
 
    public function VypsaniChybVstupu($chyba)
    {
      switch($chyba)
      {
        case 1:
          echo $this->stareHesloVstup;
          break;
        case 2:
          echo $this->noveHesloVstup;
          break;
        case 3:
          echo $this->potvrzeniHeslaVstup;
          break;
      }
    }
     
    public function VypsaniInformaci($kod)
    {  
      switch($kod)
      {
       case 1:
          echo $this->informaceVPoradku;
          break;
       case 2:
          echo $this->chybaNoveHeslo;
          break;
       case 3:
          echo $this->chybaStareHeslo;
          break;
       case 4:
          echo $this->hesloChybaPocet;
          break;
      }
    }
}

$volani = new informace();

?>

    </form>
  </body>
</html>
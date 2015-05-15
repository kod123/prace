   <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>


    
    <form method="POST" action="administrace.php" enctype="multipart/form-data">

        <h2 class="ucet">Změna hesla</h2>

         <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Staré heslo</label>
    <div class="col-sm-10">
            <input type="password"  class="form-control"   name="stareHeslo" placeholder="Zadejte staré heslo" required="required" autofocus="autofocus"/>
              </div>
  </div>
      
            <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Nové heslo</label>
    <div class="col-sm-10">
            <input type="password" class="form-control"  name="noveHeslo" placeholder="Zadejte nové heslo" required="required"/>
                     </div>
  </div>
        
            <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Potvrzení hesla</label>
    <div class="col-sm-10">
            <input type="password" class="form-control"  name="potvrzeniHesla" placeholder="Potvrďte nové heslo" required="required" />
   
                         </div>
  </div>
          <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" class="btn btn-default" value="Odeslat" name="tlacitko"/>
        
          </div>
  </div>
      
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
    //session_start();
  //  if( $_SESSION["user_is_logged"] !== 1)
  //  {
   //    header("Location: prihlaseni.php");
   // }
   // else
    //{
    if(isset($_POST["tlacitko"]))
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

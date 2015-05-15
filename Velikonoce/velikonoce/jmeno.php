   <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
     <form method="POST" action="jmeno.php" enctype="multipart/form-data">

       <h2 class="email">Obnovení uživatelského jména</h2>
         <div class="form-group">
           <label for="inputEmail3" class="col-sm-2 control-label">E-mail</label>
             <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail3" name="email"  placeholder="Zadejte uživatelský e-mail" required="required" autofocus="autofocus"/>
               </div>
        </div>
         <div class="form-group">
            <label  for="inputPassword3" class="col-sm-2 control-label">Heslo</label>
              <div class="col-sm-10">
            <input type="password"  name="heslo" class="form-control" id="inputPassword3" placeholder="Zadejte uživatelské heslo" required="required" />
        </div>
        </div>

      
          <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input type="submit"  class="btn btn-default" value="Potvrdit" name="tlacitko"/>
         </div>
  </div>
          <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
       <a href="prihlaseni.php"><button type="submit" class="btn btn-default">Přihlásit se</button></a>
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
  private $server = "127.0.0.1";
  private $jmenoServer = "root";
  private $hesloServer = "";
  private $databazeServer = "velikonoce";

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
    $shodaEmailHesloMysql = $mojeMysql->query("SELECT COUNT(*) AS cisloEmailHeslo FROM uzivatele WHERE email='$this->emailV' AND heslo='$this->hesloV'");   // Nalezení shody e-mailu a hesla 
    $vyberUzivatel = $mojeMysql->query("SELECT uzivatel FROM uzivatele WHERE email='$this->emailV' AND heslo='$this->hesloV'"); 
    
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
        <nav>
  <ul class="pager">
    <li class="previous enable"><a href="velikonoce.php"><span aria-hidden="true">&larr;</span> Domů</a></li>
  </ul>
</nav>
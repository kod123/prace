

  <div id="kontejner">

    <form action="velikonoce.php" method="POST" class="form-inline">
      
            <h3>Přihlášení</h3>
             <div class="form-group">
                <label for="exampleInputName2">Jméno:</label>
                <input type="text" id="jmeno"  class="form-control" id="exampleInputName2" name="uzivatel" required="required"  placeholder="Zadejte uživatelské jméno"/>
            </div>  
            <div class="form-group">
                <label for="prijmeni">Heslo:</label>
                <input type="password" name="heslo" class="form-control" id="exampleInputPassword3"  required="required" placeholder="Zadejte uživatelské heslo"/>
            </div> 
        
           
    
            <input type="submit" value="Příhlásit" name="tlacitko"  class="btn btn-default"/>              
           <ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="registrace.php" >Registrace</a></li>
  <li role="presentation"><a href="heslo.php" >Obnovení hesla</a></li>
  <li role="presentation"><a href="jmeno.php" >Obnovení jména</a></li>
</ul>
         
    </form>    
  </div>   
          
 
           
<?php
// Třída pro připojení databáze
/*class mojeMysql extends mysqli
{
   public function __construct($adresa, $login, $heslo, $db)
   {
      parent::__construct($adresa, $login, $heslo, $db);                      
      $this->set_charset("utf8");
   }
}   */

// Třída pro získání vstupnín údajů od uživatele
class informace
{
  public $kodChyby = 0;
  
  public function __construct()
  {   
      $zavolaniChyby = new informaceChyby();  
      if(empty($_POST["uzivatel"]) && empty($_POST["heslo"]) && isset($_POST["tlacitko"]))
      {
           $this->kodChyby = 1;
           $zavolaniChyby->VypsaniChybVstupu($this->kodChyby);
      } 
      elseif(empty($_POST["uzivatel"]) && isset($_POST["tlacitko"]))
      {
           $this->kodChyby = 2;
           $zavolaniChyby->VypsaniChybVstupu($this->kodChyby);
      }
      elseif(empty($_POST["heslo"]) && isset($_POST["tlacitko"]))
      {
           $this->kodChyby = 3;
           $zavolaniChyby->VypsaniChybVstupu($this->kodChyby);
      } 
      else
      {      
        if (isset($_POST["uzivatel"]) && isset($_POST["heslo"]))
        {                
           $this->PredaniVstupu();
        }
      }
    }
    
    public function PredaniVstupu()
    {
          $uzivatel = $_POST["uzivatel"];
          $heslo = hash("sha256", $_POST["heslo"]); 
          $prihlas = new prihlaseni($uzivatel, $heslo); 
    }
}   
  
class prihlaseni
{
    public $uzivatelVstup;
    public $hesloVstup;
    public $chyba = 0;   // V případě, když je špatně vyplněné jméno nebo heslo
      
    private $server = "127.0.0.1";
    private $jmenoServer = "root";
    private $hesloServer = "";
    private $databazeServer = "velikonoce";       
           
    public function __construct($uzivatel, $heslo)
    {
        $this->uzivatelVstup = $uzivatel;         
        $this->hesloVstup =  $heslo;
      //   session_start();
         if(!isset($_SESSION["user_is_logged"]))
       {
        $this->PripojeniServer();
        }
    } 
      
    // Metoda pro zavolání připojovací třídy k databázi + vypsání přípádné chyby při nenavázání spojení  
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
    
    // Metoda s mysql dotazem
    public function DotazMysql($mojeMysql)
    {
         $prikazMysql = "SELECT id, uzivatel, heslo, aktivace FROM uzivatele";
         $vysledekMysql = $mojeMysql->query($prikazMysql);         
         $this->ZpracovaniPrihlaseni($vysledekMysql, $mojeMysql);
    }
   
    public function ZpracovaniPrihlaseni($vysledekMysql, $mojeMysql)
    {   
    // if($vysledekMysql)
  //    {                
         while ($radek = $vysledekMysql->fetch_array(MYSQLI_ASSOC)) 
         { 
             $id = $radek["id"];
             $uzivatel = $radek["uzivatel"];
             $heslo = $radek["heslo"];
             $aktivace = $radek["aktivace"];  
                 
        if(($this->uzivatelVstup == $uzivatel) && ($this->hesloVstup == $heslo) && $aktivace == 1)
        {
             // Pokud se přihlásí nový uživatel vytvoří se pro něj nové šložky pro ukládání 
             if(!file_exists("up/".$this->uzivatelVstup))
             {
                mkdir("up/".$this->uzivatelVstup."/");
                mkdir("up/".$this->uzivatelVstup."/thumb/");
             }
                      
             $vysledekMysql->Close();
             $mojeMysql->Close();
                        
             $prihlaseniGalerie = new predaniGalerie($this->uzivatelVstup, $id);   
        }
       }  
       if($this->chyba == 0)
       {    
         $volaniChyb = new informaceChyby();
         $volaniChyb->Neuspesne();
       }  
      // } 
    }
}

class informaceChyby
{
  public $uzivatelHesloChybaVstup ="Musíte vyplnit uživatelské jméno a heslo!!!"; 
  public $uzivatelChybaVstup = "Musíte vyplnit uživatelské jméno!!!";
  public $hesloChybaVstup = "Musíte vyplnit heslo!!!";

  public $chyba = "<p id='chyba'>Špatně vyplněné jméno nebo heslo!!!</p>";
    
  public function VypsaniChybVstupu($kod)
  {
     switch($kod)
     {
        case 1:
          echo $this->uzivatelHesloChybaVstup;
          break;
        case 2:
          echo $this->uzivatelChybaVstup;
          break;
        case 3:
          echo $this->hesloChybaVstup;
          break;
     }
  }
  
  public function Neuspesne()
  {
     echo $this->chyba;
  }
}

class predaniGalerie
{
  public function __construct($uzivatelVstup, $id)
  {
     // session_start();
      header("Cache-control: private");
      $_SESSION["user_is_logged"] = 1; // Potvrzení, že uživatel je přihlášen (1)
      $_SESSION["uzivatel"] = $uzivatelVstup;  // Přidání uživatele do session
      $_SESSION["id"] = $id;  // Přidání id do session
   //   echo("<p data-rls-clear='uzivatel'></p>"); // Odstranění uživatele z pole html
     
   /*if(isset($_SESSION["user_is_logged"]))
   {
    echo ("<p id='registrace'><a href='pridani.php'>Pridani</a></p>"); 
   } */
    //  header("Location: velikonoce.php");
      
   
  }
}

  $volani = new informace();
  
?>




 
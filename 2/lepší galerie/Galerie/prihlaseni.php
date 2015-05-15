<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Přihlášení do galerie</title> 
  <link rel="stylesheet" href="styly/styl-prihlaseni.css" /> 
  <!--Script pro zachování údajů v polích hmtl, pokud došlo k vyvolání chyby-->
  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js" type="text/javascript"></script>
  <script src="javascript/zachovani/rls.js" type="text/javascript"></script>
</head>
<body>
  <div id="kontejner">

    <form action="prihlaseni.php" method="POST">
         <fieldset>
            <h2 class="ucet">Galerie</h2>
            <ul>
              <li>
                <label for="jmeno">Jméno:</label>
                <input type="text" id="jmeno"  name="uzivatel"  class="delkaInput" required="required"  placeholder="Zadejte uživatelské jméno" data-rls-id="uzivatel"/>
              </li>
              <li>
                <label for="prijmeni">Heslo:</label>
                <input type="password" id="prijmeni" name="heslo" class="delkaInput"  required="required" placeholder="Zadejte uživatelské heslo"/>
              </li>     
            </ul>
          </fieldset>    
           
          <fieldset>
            <input type="submit" id="vytvoritUcet" value="Příhlásit" name="tlacitko"/>              
          </fieldset>   
          
          <p id="registrace"><a href="registrace.php" >Registrace</a></p> 
          <p id="obnoveniHesla"><a href="heslo.php" >Obnovení hesla</a></p> 
          <p id="obnoveniJmena"><a href="jmeno.php" >Obnovení jména</a></p> 
           
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
      
    private $server = "vyuka.pslib.cz";
    private $jmenoServer = "P3";
    private $hesloServer = "p3";
    private $databazeServer = "piskoviste_P3";       
           
    public function __construct($uzivatel, $heslo)
    {
        $this->uzivatelVstup = $uzivatel;         
        $this->hesloVstup =  $heslo;
        $this->PripojeniServer();
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
         $prikazMysql = "SELECT uzivatel, heslo, aktivace FROM labovsky_prihlaseni";
         $vysledekMysql = $mojeMysql->query($prikazMysql);         
         $this->ZpracovaniPrihlaseni($vysledekMysql, $mojeMysql);
    }
   
    public function ZpracovaniPrihlaseni($vysledekMysql, $mojeMysql)
    {                   
         while ($radek = $vysledekMysql->fetch_array(MYSQLI_ASSOC)) 
         { 
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
                        
             $prihlaseniGalerie = new predaniGalerie($this->uzivatelVstup);   
        }
       }  
       if($this->chyba == 0)
       {    
         $volaniChyb = new informaceChyby();
         $volaniChyb->Neuspesne();
       }   
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
  public function __construct($uzivatelVstup)
  {
      session_start();
      header("Cache-control: private");
      $_SESSION["user_is_logged"] = 1; // Potvrzení, že uživatel je přihlášen (1)
      $_SESSION["uzivatel"] = $uzivatelVstup;  // Přidání uživatele do session
      echo("<p data-rls-clear='uzivatel'></p>"); // Odstranění uživatele z pole html
      header("Location: galerie.php");
  }
}

  $volani = new informace();
  
?>
         
    </form>    
  </div>   
</body>
</html>


 
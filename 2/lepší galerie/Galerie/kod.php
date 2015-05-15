<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Ověřovací kód</title>
   <link rel="stylesheet" href="styly/styl-kod.css" /> 
</head>
<body>

<?php
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
class informace
{
  public function __construct()
  {
    if(isset($_GET["id"]))
    {
        $kod = $_GET["id"];
        $predaniKod = new overeni($kod); 
    }
  }
}

class overeni
{
  private $server = "vyuka.pslib.cz";
  private $jmenoServer = "P3";
  private $hesloServer = "p3";
  private $databazeServer = "piskoviste_P3";
  
  public $mojeMysql;
  public $kodV;
  public $shodaUzivatel;
  
  public $kodInformaci = 0;
 
  public function __construct($kodVstup)
  {  
     $this->kodV = $kodVstup;
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
     $shodaUzivatelMysql = $mojeMysql->query("SELECT COUNT(*) AS cisloUzivatel FROM labovsky_prihlaseni WHERE kod='$this->kodV'");
     
     $this->Zpracovani($shodaUzivatelMysql, $mojeMysql);
  }
  
  public function Zpracovani($shodaUzivatelMysql, $mojeMysql)
  {         
     while($radek = $shodaUzivatelMysql->fetch_array(MYSQLI_ASSOC))
     {
	      $this->shodaUzivatel=$radek['cisloUzivatel'];
     } 
    
     $zavolaniInformaci = new informaceChyby();
     
     if($this->shodaUzivatel == 1)
     {
        $mojeMysql->query("UPDATE labovsky_prihlaseni SET aktivace=1, kod=1 WHERE kod='$this->kodV'");  
        $mojeMysql->query("DELETE FROM labovsky_overeni WHERE aktivace=0 AND UNIX_TIMESTAMP() - UNIX_TIMESTAMP(datum) > 3600");          
        
        $shodaUzivatelMysql->Close();
        $mojeMysql->Close();
        
        $this->kodInformaci = 1;
        $zavolaniInformaci->VypsaniInformaci($this->kodInformaci);         
     }
     else
     {
        $this->kodInformaci = 2;
        $zavolaniInformaci->VypsaniInformaci($this->kodInformaci);
     }      
  }     
}

class informaceChyby
{
    public $informace = "<p id='ulozeno'>Úspěšně jste byl/a zaregistrován/a, nyní se můžete přihlásit.</p>";
    public $chyba = "<p id='chyba'>Zadaný kód je špatný, opakujte akci!!!</p>";
    public $odkaz = "<a href='prihlaseni.php'>Přihlásit</a>";
    
    public function VypsaniInformaci($kod)
    {
       if($kod == 1)
       {
          echo $this->informace;
          echo $this->odkaz;
       }
       if($kod == 2)
       {
          echo $this->chyba;
       }
    }
}

  $volani = new informace();

?>    

</body>
</html>
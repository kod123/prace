<?php
// Tøída pro pøipojení databáze
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
class ulozeniJson
{
    private $server = "vyuka.pslib.cz";
    private $jmenoServer = "P3";
    private $hesloServer = "p3";
    private $databazeServer = "sady_obce";  
        
    // Metoda pro zavolání pøipojovací tøídy k databázi + vypsání pøípádné chyby pøi nenavázání spojení   
    public function PripojeniServer()
    {
       $mojeMysql = new mojeMysql($this->server, $this->jmenoServer, $this->hesloServer, $this->databazeServer);
    
       if ($mojeMysql->connect_error) 
       { 
         'Pøi pøipojení došlo k chybì: ' . $mojeMysql->connect_error . '. Èíslo 
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
          $polePrikazu = array ("SELECT LAU1, nazev FROM okresy ORDER BY nazev ASC", "SELECT LAU1, LAU2, nazev FROM obce ORDER BY nazev ASC", "SELECT LAU2, rok, celkem FROM obyvatelstvo");
          $poleSouboru = array ("okresy.json", "obce.json", "obyvatelstvo.json");

              for($i = 0; $i < 3; $i++)
              {
                  $vysledekPrikazu =  $mojeMysql->query($polePrikazu[$i]);
                  $pole = array();                   
                  $cislo = 0; // Aktuální index pro ukládaní do pole
                  
                   while($radek = $vysledekPrikazu->fetch_array())
	     	           {   
                      if($i == 0)
                      { 
                      $pole[$cislo]['LAU1'] = $radek['LAU1'];
                      $pole[$cislo]['Nazev'] = $radek['nazev'];
                      
                      }
                      
                      if($i == 1)
                      {
                       $pole[$cislo]['LAU1'] = $radek['LAU1'];
                       $pole[$cislo]['LAU2'] = $radek['LAU2'];
                       $pole[$cislo]['Nazev'] = $radek['nazev'];
                      }
                      
                      if($i == 2)
                      {
                       $pole[$cislo]['LAU2'] = $radek['LAU2'];
                       $pole[$cislo]['Rok'] = $radek['rok'];
                       $pole[$cislo]['Celkem'] = $radek['celkem'];
                      }
                                          
                      $cislo +=1;
                   }
                  
                   $fp = fopen("soubory-json/".$poleSouboru[$i], 'w');
          	       fwrite($fp, json_encode($pole));        
          	       fclose($fp);
                   
                   $cislo = 0; 
                   $pole = array(); // Vymazání pole s daty
              }    
    }
}
 $zavolani = new ulozeniJson();
 $zavolani->PripojeniServer();
?>
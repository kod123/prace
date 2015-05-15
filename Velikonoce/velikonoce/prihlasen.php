<?php
class prihlasen
{

private $server = "127.0.0.1";
    private $jmenoServer = "root";
    private $hesloServer = "";
    private $databazeServer = "velikonoce";
    
    
    public $slozka;  // Odkud se budou zobrazovat obrázky
  public $poleJmena; // Pole pro zobrazování obrázků
  public $uzivatel; // Jméno přihlášeného uživatele
  
   public function __construct()
   {
      $uzivatel = $_SESSION["uzivatel"];
      
         $this->uzivatel = $_SESSION["uzivatel"];  // Získání jména přihlášeného uživatele   
    $this->slozka = "up/".$this->uzivatel."/";  // Nastavení čtecí složky
    $this->Otevreni($this->slozka); 
      
   // $this->PripojeniServer(); 
   }
   
    public function Otevreni($nazev)
  {          
    $predaniNazvu = opendir($nazev);  // Otevře zadanou složku
    $this->Pridani($predaniNazvu);     
  }
   
  /* public function PripojeniServer()
    {
       $mojeMysql = new mojeMysql($this->server, $this->jmenoServer, $this->hesloServer, $this->databazeServer);
    
       if ($mojeMysql->connect_error) 
       { 
         'Při připojení došlo k chybě: ' . $mojeMysql->connect_error . '. Číslo 
           chyby: ' .$mojeMysql->connect_errno; 
       }
       else
       {  
        // $this->DotazMysql($mojeMysql);        
       }            
    }     */

    /*public function DotazMysql($mojeMysql);
    {
    
    }  */
    
    
  public function Pridani($otevrenaSlozka)
  {
    $pripony =  array('gif','png' ,'jpg', 'jpeg');
                 
    while($vyberJmena = readdir($otevrenaSlozka)) // Prečte soubory v adresáři
    {
      $existencePripony = pathinfo(strtolower($vyberJmena), PATHINFO_EXTENSION); // Zjistí příponu souboru
      // Pokud je v poli $pripony přidá nazev soubru do poleJmena
      if(in_array($existencePripony, $pripony)) 
      {
        $this->poleJmena[] = $vyberJmena;  
      }      
    }

    $pocet = count($this->poleJmena);

    if($pocet != 0)
     {
   
       $this->Vypsani($this->poleJmena);
     }
  }
  
  public function Vypsani($poleJmena)
  {  
   // $pocetPolozek = count($poleJmena); // Zjistí počet souborů       
    //echo ("<br>Počet obrázků: $pocetPolozek<br>\n");
    
    //sort($this->poleJmena);  // Seřadí pole podle abecedy    
       //-------------------------------------------------------------------------------------  
       
    echo("<div id='zobrazeni'>");
     
    for($i=0; $i < 1; $i++)  
     {       
      if (file_exists("$this->slozka/thumb")) // Zda existuje složka s náhledy
       {    
         if(file_exists("$this->slozka/thumb/$poleJmena[$i]")) //Pokud existuje náhled zobrazí ho jinak zobrazí univerzální obrázek
          {   
            $nazev = explode(".",$poleJmena[$i]);
             echo("<img src=\"$this->slozka/thumb/$poleJmena[$i]\" alt='$poleJmena[$i]' id='ramecek' />");
            echo("<label>Přihlášen: ".$this->uzivatel."<label>");
           
          //  echo("<input type='checkbox' name ='vymazat[]' value='$poleJmena[$i]' />");                
          }        
          /*else
           {
             $nazev = explode(".",$poleJmena[$i]);
             echo("<a href=\"$this->slozka/$poleJmena[$i]\" rel='external' title='$nazev[0]' class='mezeryObrazky' data-lightbox='roadtrip'><img src='nahled-neni-k-dispozici.jpg' alt='Obrázek není k dipozici' id='ramecek'/> </a>");
             echo("<input type='checkbox' name ='vymazat[]' value='$poleJmena[$i]' />"); 
           } */                
        }        
     }
    echo("</div>");
  } 

}

$zavolani = new prihlasen();
?>
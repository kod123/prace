<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Přihlášení do galerie</title> 
  <link rel="stylesheet" href="styly/styl-prihlaseni.css" /> 
</head>
<body>
  <div id="kontejner">
   <?php  
      // Zachování jména i po špatném zadání (heslo še vymaže)                  
      $jmeno = (isset($_POST['jmeno'])) ? $_POST['jmeno'] : '';
    ?>
    <form action="prihlaseni.php" method="POST">
         <fieldset>
            <h2 class="ucet">Galerie</h2>
            <ul>
              <li>
                <label for="jmeno">Jméno:</label>
                <input type="text" id="jmeno"  name="jmeno" value="<?= htmlspecialchars($jmeno) ?>" class="delkaInput" required="required" placeholder="Zadejte uživatelské jméno" />
              </li>
              <li>
                <label for="prijmeni">Heslo:</label>
                <input type="password" id="prijmeni" name="heslo" class="delkaInput" required="required" placeholder="Zadejte uživatelské heslo"/>
              </li>     
            </ul>
          </fieldset>
          
          <fieldset>
            <input type="submit" id="vytvoritUcet" value="Příhlásit" />   

<?php
class prihlaseni
{
  // Příhlašovací jména a hesla
  private $poleJmena = array('roman', 'evzen', 'tomas', 'honza', 'anna');
  private $poleHesla = array('123','456','789', '369', '852'); 
  private $pocet;
  public $chyba;
  

  
  public function __construct()
  {
    $this->pocet = count($this->poleJmena);
  }
   
  // Pokud je špatně zadaného jméno nebo heslo ukáže se chyba 
  public function ZpracovaniPrihlaseniChyba()
  { 
    if (isset($_POST["jmeno"]) && isset($_POST["heslo"]))
    {
     for($i = 0; $i < $this->pocet; $i++)
     {
      if(($_POST['jmeno']!==$this->poleJmena[$i])||($_POST['heslo']!==$this->poleHesla[$i]))
         {   
             $jmeno= $_POST['jmeno'];
            echo("<p id='chyba'>Špatně vyplněné jméno nebo heslo!!!</p>");
            $i = $this->pocet; // Vypsání chyby pouze jednou                                              
         }
      }  
    }  
  }   
      
 public function ZpracovaniPrihlaseni()
 {
   if (isset($_POST["jmeno"]) && isset($_POST["heslo"]))
    {         
     for($i = 0; $i < $this->pocet; $i++)
      {
       if(($_POST['jmeno']==$this->poleJmena[$i])&&($_POST['heslo']==$this->poleHesla[$i]))
        { 
        
        // Pokud neexistuje složka uživatele (především prvotní přihlášení) vytvoří se složka s jeho jménem
        if(!file_exists("up/".$this->poleJmena[$i]))
        {
          mkdir("up/".$this->poleJmena[$i]."/");
          mkdir("up/".$this->poleJmena[$i]."/thumb/");
        }
      //  else
      //  {        
         session_start();
         $_SESSION['uzivatel'] = $this->poleJmena[$i]; // Přidání uživatelského hesla do session pro další zpracování v galerii
         header("Cache-control: private");
         
         $_SESSION["user_is_logged"] = 1; // Potvrzení, že uživatel je přihlášen (1)

         header("Location: galerie.php"); // Přesměrování do galerie
         exit;
        // }              
        }
      }
    }
  }  
}
 $volani = new prihlaseni(); 
 $volani->ZpracovaniPrihlaseniChyba();
 $volani->ZpracovaniPrihlaseni();
?>
      </fieldset>     
    </form> 
  </div> 
</body>
</html>


 
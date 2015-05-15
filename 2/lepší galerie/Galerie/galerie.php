<!DOCTYPE html>
<html  lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Galerie PHP</title>
    <link rel="stylesheet" href="styly/styl-galerie.css" />
    <script src="javascript/lightbox/js/jquery-1.11.0.min.js"></script>
    <script src="javascript/lightbox/js/lightbox.min.js"></script>
    <link href="javascript/lightbox/css/lightbox.css" rel="stylesheet" />	
</head>
<body>

  <h1>Galerie PHP</h1>
    <p id="odhlaseniTlacitko"><a href=odhlaseni.php id="odhlaseni" >Odhlásit <?php session_start(); $uzivatel = $_SESSION["uzivatel"]; echo $uzivatel?></a></p>
    <a href="zmenaHesla.php" id="zmenaHesla">Změna hesla</a>
  <form method="post" enctype="multipart/form-data">
    <label for="soubor" ><strong>Vybrat obrázek</strong></label>
      <input type="file" name="file" id="soubor" />
      <input type="submit" value="Nahrát obrázek"/><br>
    
  </form>
  <form  action="vymazani.php" method="post" enctype="multipart/form-data">
    <label for="vymazat" ><strong>Vymazání zaškrtnutých obrázků</strong></label>
      <input type="submit" value="Vymazat" id="vymazat"/>
       
  
<?php 
class ulozeni
{
  public $pripony = array("gif", "jpeg", "jpg", "png");
  public $ukladaciCesta; 
  public $ukladaciCestaNahledy;
  public $nahledSirka = 100;
  public $nahledSirkaVetsi = 50;
  public $uzivatel;
  
  public function __construct()
  {
    // Pokud snaha o načtení galerie.php bez přihlášení, přesměruje se do přihlášení
    if( $_SESSION["user_is_logged"] !== 1)
    {
       header("Location: prihlaseni.php");
    }
    else
    {
      // Vytvoření cest do složek přihlášeného uživatele
      $this->uzivatel = $_SESSION["uzivatel"]; 
      $this->ukladaciCesta="up/".$this->uzivatel."/";
      $this->ukladaciCestaNahledy ="up/".$this->uzivatel."/thumb/";
    }
  }
  
  public function Vstup()
  {
    if (!empty($_FILES))
    {
      $temp = explode(".", strtolower($_FILES["file"]["name"]));
      $extension = end($temp);
      // Podmínky za kterých bude obrázek zpracován
      if ((($_FILES["file"]["type"] == "image/gif")
          || ($_FILES["file"]["type"] == "image/jpeg")
          || ($_FILES["file"]["type"] == "image/jpg")
          || ($_FILES["file"]["type"] == "image/pjpeg")
          || ($_FILES["file"]["type"] == "image/x-png")
          || ($_FILES["file"]["type"] == "image/png"))
          && ($_FILES["file"]["size"] < 200000000000000000000000000)
          && in_array($extension, $this->pripony))
      {
        if ($_FILES["file"]["error"] > 0)
         {
          echo "Error: " . $_FILES["file"]["error"] . "<br>";
         }
        else
         {
          // Získání informací z nahraného obrázku a vypsání
          echo("<div class='informace'>");
            echo "<strong>Nahráno: </strong>" . $_FILES["file"]["name"] . "<br>";
            echo "<strong>Typ: </strong>" . $_FILES["file"]["type"] . "<br>";
            echo "<strong>Velikost: </strong>" . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            echo "<strong>Nahráno (temp) z: </strong>" . $_FILES["file"]["tmp_name"]."<br>";
          echo("</div>");
          
          // Pokud již soubor existuje
          if (file_exists($this->ukladaciCesta . $_FILES["file"]["name"]))
           {
            echo("<div  class='bezMezery'>");
              echo "<em>".$_FILES["file"]["name"]."</em>". " <strong>již existuje</strong>";    
            echo("</div>");
           }
          else
           {
            // Uloženní obrázku do složky
            move_uploaded_file($_FILES["file"]["tmp_name"], $this->ukladaciCesta . $_FILES["file"]["name"]);
            echo("<div  class='bezMezery'>");
              echo "<strong>Uloženo do: </strong>" . $this->ukladaciCesta . $_FILES["file"]["name"];
            echo("</div>");
          
            // Vytvoření ikony pro náhled
            if ($_FILES["file"]["type"] == "image/jpeg" || "image/jpg") 
            {     
            $obrazek = imagecreatefromjpeg($this->ukladaciCesta . $_FILES["file"]["name"]);
            }
            if($_FILES["file"]["type"] == "image/gif") 
            {
               $obrazek = imagecreatefromgif($this->ukladaciCesta . $_FILES["file"]["name"]);
            }
            if($_FILES["file"]["type"] == "image/png") 
            {
               $obrazek = imagecreatefrompng($this->ukladaciCesta . $_FILES["file"]["name"]);
            }
            $sirka = imagesx($obrazek);
            $vyska = imagesy($obrazek);
            
            // Pokud je výška větší než šířka
            if($vyska > $sirka)
            {
              $novaVyska = floor( $vyska * ($this->nahledSirkaVetsi / $sirka));
            }
            else
            {
              $novaVyska = floor( $vyska * ($this->nahledSirka / $sirka));
            }
            $novaSirka = $this->nahledSirka;          
            $tmpObrazek = imagecreatetruecolor( $novaSirka, $novaVyska );
            imagecopyresampled( $tmpObrazek, $obrazek, 0, 0, 0, 0, $novaSirka, $novaVyska, $sirka, $vyska );  // Vytvoření změnšeného obrázku
            imagejpeg($tmpObrazek, $this->ukladaciCestaNahledy . $_FILES["file"]["name"]);  // Uložení této ikony
           }
        }
    }
    else
     {
      echo "<span id='neplatnySoubor'><strong>Chyba nahrání:</strong> Neplatný soubor!!!</span>";
     } 
  }
 }
}
  $zavolani= new ulozeni();
  $zavolani->Vstup();
    
//-------------------------------------------------------------------------------------------------------------------
  
class galerie
{  
  public $slozka;  // Odkud se budou zobrazovat obrázky
  public $poleJmena; // Pole pro zobrazování obrázků
  public $uzivatel; // Jméno přihlášeného uživatele

  public function __construct()
  { 
    $this->uzivatel = $_SESSION["uzivatel"];  // Získání jména přihlášeného uživatele   
    $this->slozka = "up/".$this->uzivatel."/";  // Nastavení čtecí složky
    $this->Otevreni($this->slozka);     
  }   
        
  public function Otevreni($nazev)
  {          
    $predaniNazvu = opendir($nazev);  // Otevře zadanou složku
    $this->Pridani($predaniNazvu);     
  }
  
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

    if($pocet == 0)
     {
       echo "";
     }
    else
     { 
       $this->Vypsani($this->poleJmena);
     }
  }
  
  public function Vypsani($poleJmena)
  {  
    $pocetPolozek = count($poleJmena); // Zjistí počet souborů       
    echo ("<br>Počet obrázků: $pocetPolozek<br>\n");
    
    sort($this->poleJmena);  // Seřadí pole podle abecedy
 
       //-----------------------------------------------------------------------------------------------
    /*  if (file_exists("$this->slozka/thumb")) // Zda existuje složka s náhledy
      {    
          if(file_exists("$this->slozka/thumb/$poleJmena[$i]")) //Pokud existuje náhled zobrazí ho jinak zobrazí pouze odkaz
          {
            print("<TR><TD><a href=\"$this->slozka/$poleJmena[$i]\"><img src=\"$this->slozka/thumb/$poleJmena[$i]\"/></a></TD></TR>"); 
          }
          else
          {
            print("<TR><TD> <a href=\"$this->slozka/$poleJmena[$i]\">$poleJmena[$i]</a></TD></TR>");
          }                    
      }
      else
      {*/
  
  //    print("<TR><TD> <a href=\"$this->slozka/$poleJmena[$i]\">$poleJmena[$i]</a></TD></TR>");
 
     // }
    
   // } 
        
    
       //-------------------------------------------------------------------------------------  
       
    echo("<div id='zobrazeni'>");
     
    for($i=0; $i < $pocetPolozek; $i++)  
     {       
      if (file_exists("$this->slozka/thumb")) // Zda existuje složka s náhledy
       {    
         if(file_exists("$this->slozka/thumb/$poleJmena[$i]")) //Pokud existuje náhled zobrazí ho jinak zobrazí univerzální obrázek
          {   
            $nazev = explode(".",$poleJmena[$i]);
            echo("<a href=\"$this->slozka/$poleJmena[$i]\" rel='external' title='$nazev[0]' class='mezeryObrazky' data-lightbox='roadtrip'> <img src=\"$this->slozka/thumb/$poleJmena[$i]\" alt='$poleJmena[$i]' id='ramecek' /></a>");
            echo("<input type='checkbox' name ='vymazat[]' value='$poleJmena[$i]' />");                
          }        
          else
           {
             $nazev = explode(".",$poleJmena[$i]);
             echo("<a href=\"$this->slozka/$poleJmena[$i]\" rel='external' title='$nazev[0]' class='mezeryObrazky' data-lightbox='roadtrip'><img src='nahled-neni-k-dispozici.jpg' alt='Obrázek není k dipozici' id='ramecek'/> </a>");
             echo("<input type='checkbox' name ='vymazat[]' value='$poleJmena[$i]' />"); 
           }                 
        }        
     }
    echo("</div>");
  } 
}
 $volani = new galerie();  
?>  

  </form>
</body>
</html>



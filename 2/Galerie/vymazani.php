<!DOCTYPE html>
<html  lang="cs">
<head> 
  <meta charset="utf-8" />
  <title>Vymazání obrázků</title>
  <link rel="stylesheet" href="styly/styl-vymazani.css" />
</head>
<body>
    <div id="tlacitkoGalerie"><a href="galerie.php" id="zpetGalerie" >Zpět do galerie</a></div><br>
</body>
</html>
<?php

class vymazani
{
  public $poleOdstraneni; // Pole s označenými obrázky k odstranění
  public $uzivatel; // Jméno přihlášeného uživatele
  
  // Pokud snaha o načtení vymazani.php bez přihlášení, přesměruje se do přihlášení
  public function __construct()
  {
  session_start();
  
  if( $_SESSION["user_is_logged"] !== 1)
   {
      header("Location: prihlaseni.php"); 
   }
  else
   {
     $this->uzivatel = $_SESSION["uzivatel"];
     $this->poleOdstraneni = $_POST['vymazat'];
     $pocet = count( $this->poleOdstraneni);
     
     // Když se pole rovná 0 nelze nic odstranit
     if($pocet == 0)
      {
        header("Location: galerie.php");
      }
   }
  }
  

  public function VymazaniObrazku()
  {
    echo("<div id='odsazeniChyba'>");  
     foreach($this->poleOdstraneni as $obrazek)
      {
       // Pokud existuje daný obrázek odstraní se jinak zobrazí chybovou hlášku
       if(file_exists("up/".$this->uzivatel."/".$obrazek))
        {
          unlink("up/".$this->uzivatel."/".$obrazek);
          echo("<div id='zpravaPoradek'>Obrázek: <strong>".$obrazek."</strong> byl úspěšně vymazán.<br></div>");
        }
       else
        {
          echo("<div class='chyba'>Obrázek: <strong>".$obrazek."</strong> chybý nebo již byl vymazán!!!<br></div>");
        }
     
       // Pokud existuje daný náhled odstraní se jinak zobrazí chybovou hlášku
       if(file_exists("up/".$this->uzivatel."/thumb/".$obrazek))
        {
          unlink("up/".$this->uzivatel."/thumb/".$obrazek);
        }
       else
        {
          echo("<div class='chyba'>Náhled obrázku: <strong>".$obrazek."</strong> chybý nebo již byl vymazán!!!</div>");
        }
      }
      echo("</div>");
  }
}
  $zavolani = new vymazani();
  $zavolani->VymazaniObrazku();

 
/* $pocet = count($pole);
 echo $pocet;
 print_r($pole);*/
 
 
     /* $pocet = $_POST['vymazat'];
      $poc = count($pocet);
      print_r($pocet);
      foreach($pocet as $smaz)
      {
        unlink("up/img/".$smaz);
        unlink("up/img/thumb/".$smaz);
      }*/
?>
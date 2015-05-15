<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Pøihlášení do galerie</title> 
</head>
<body>

<?php
  // Tøída pro pøipojení databáze
	class mojeMysql extends mysqli
	{
		function __construct($adresa,$login,$heslo,$db)
		{
			parent::__construct($adresa,$login,$heslo,$db);
			$this->set_charset('utf8');
		}
	}
?>

<?php
   $poleSpecializace = $_POST['vybrane'];
   $neco =  $poleSpecializace[0];
      
  $mojeMysql = new mojeMysql('vyuka.pslib.cz', 'P3', 'p3', 'piskoviste_P3_ordinace');
	if ($mojeMysql->connect_error) 
	{ 
 	die('Pøi pøipojení došlo k chybì: ' . $mojeMysql->connect_error . '. Èíslo 
	chyby: ' . $mojeMysql->connect_errno); 
	}  
    $result = $mojeMysql->query("SELECT KodSpecializace FROM Specializace WHERE Nazev= '$neco'");
    while($row = $result->fetch_array())
	  {    
      $vyber = $row['KodSpecializace'];
      $vysledek = $mojeMysql->query("SELECT JmenoLekare, PrijmeniLekare FROM Lekar WHERE KodSpecializace = '$vyber'"); 
      $pocet = 1;
      while($jmenoPrijmeni = $vysledek->fetch_array())
      {  
          echo $pocet.". ".$jmenoPrijmeni["JmenoLekare"]." ".$jmenoPrijmeni["PrijmeniLekare"]."<br>";
          $pocet++;
      }
    }  
    
   $vysledek->Close();
	 $mojeMysql->Close();   
?>
</body>
</html>
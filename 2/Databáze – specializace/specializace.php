<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Výběr specializace</title> 
</head>
<body>

<?php
  // Třída pro připojení databáze
	class mojeMysql extends mysqli
	{
		function __construct($adresa, $login, $heslo, $db)
		{
			parent::__construct($adresa, $login, $heslo, $db);
			$this->set_charset('utf8');
		}
	}

?>
 
 <form  action="vybranaSpecializace.php" method="post" enctype="multipart/form-data'"> 
<?php
  $mojeMysql = new mojeMysql('vyuka.pslib.cz', 'P3', 'p3', 'piskoviste_P3_ordinace');
	if ($mojeMysql->connect_error) 
	{ 
 	die('Při připojení došlo k chybě: ' . $mojeMysql->connect_error . '. Číslo 
	chyby: ' . $mojeMysql->connect_errno); 
	}
  $result = $mojeMysql->query("SELECT Nazev FROM Specializace");
  
  echo("<select name='vybrane[]'>"); 

	while($row = $result->fetch_array())
	{
     $neco =  $row['Nazev'];
     echo("<option value='$neco'>".$row['Nazev']."</option>");   
	}
	   echo("</select>");
      
	$result->Close();
	$mojeMysql->Close(); 
?>  
  
  <input type="submit" value="Odeslat"/>
</form>
</body>
</html>
<?php
  session_start();
  //$_SESSION["ahoj"] = 3;
  //var_dump($_SESSION);
  //$_SESSION = array();
  if (isset($_SESSION["kosik"])) $mujKosik = $_SESSION["kosik"];  else $mujKosik = new kosik();
//  unset($_SESSION['kosik']);
  if (isset($_GET["zbozi"]) && isset($_GET["cena"])) 
  $mujKosik->add(new zbozi($_GET["zbozi"], $_GET["cena"]));
  if(isset($_GET["vymaz"])) $mujKosik->clear();
  if(isset($_GET["smaz"])) $mujKosik->delete($_GET["smaz"]);
  $_SESSION["kosik"] = $mujKosik;
class zbozi
{
  public $nazev;
  public $cena;
  
  public function __construct($nazev, $cena)
  {
  $this->nazev = $nazev;
  $this->cena = $cena;
  }
 
  
  
}
 
class kosik
{
  public $polozky = array();
  
  public function add($zbozi)
  {
    $this->polozky[] = $zbozi;
  }
  
  public function clear()
  {
   $this->polozky = array(); 
  }
  
  public function delete($index)
  {
    if(isset($this->polozky[$index])) unset($this->polozky[$index]);
  }
}


?>    
<html>
<head>
  <meta charset=UTF-8>
</head>
<body>
  <table>
  <?php
   foreach($mujKosik->polozky as $index => $polozka)
   {
    echo "<tr><td>".$polozka->nazev."</td><td><a href=\"?smaz=".$index."\">Smaž</a>";
    echo  "</td></tr>";
   }  
  ?>
  </table>
  <p><a href=?vymaz> Vymaž celý košík</a></p>
<form>
  <form>
    <input name = zbozi />
    <input name = cena />
    <input type=submit />
  </form>
</form> 

</body>
</html>           
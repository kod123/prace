<html>
<head>
 <meta charset="UTF-8"/>
<style>
 .prouzek {height: 20px; background-color: red;}
</style>
</head>
<body>
<form  method="POST" action="graf.php">
  <textarea rows="10" cols="40" name="retezec"></textarea><br>
<?php
          
class vstup
{
 private $pole = array();

 public function __construct()
 {
  if(isset($_POST["retezec"]))
    {
      $retezec=$_POST['retezec'];       
      $this->Osetreni($retezec);
    }
 }
 
 public function Osetreni($retezec)
 {
   $bezBilychZnaku = str_replace(" ", "", $retezec);
   $this->Add( $bezBilychZnaku);
 } 
  
 public function Add($retezec)
 {
   $polozky = explode(";",$retezec);
   foreach ($polozky as $polozka)
   {
    $par = explode(":",$polozka);
     if (isset($this->pole[$par[0]])) $this->pole[$par[0]] = $this->pole[$par[0]] + $par[1];
     else $this->pole[$par[0]] = $par[1]; 
   }
 }

 public function VystupVstupu()
 {
    return $this->pole;
 }
}

class graf
{
  private $data = array();

  public function __construct(array $pole)
  {
    $this->data = $pole;
  }

 public function VystupGrafu()
 {
  $text = "";
  foreach ($this->data as $nazev => $pocet)
  {
   $sirka = $pocet * 10;
   $text .= $nazev . "<br />";
   $text .= "<div class=\"prouzek\" style=\"width:{$sirka}px\"></div><br />";
  }
  return $text;
 }
}

$parser = new vstup();

$vystup = $parser->VystupVstupu();
$gr = new graf($vystup);
echo $gr->VystupGrafu();
?>
<input type="submit"/>
</form>
</body>
</html>
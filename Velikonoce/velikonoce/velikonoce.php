<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <title>Velikonoce</title>
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>

<?php
class vstup
{
 public function __construct()
 {
    session_start();
if(!isset($_SESSION["user_is_logged"]))
{
  //if(!$_SESSION["user_is_logged"])
  //{
  include 'prihlaseni.php';
  //}
}
else
{

include 'prihlasen.php';
echo('   <ul class="nav nav-pills">
  <li role="presentation" class="active"><a href="odhlaseni.php" >Odhlášení</a></li>
  <li role="presentation"><a href="pridani.php" >Přidání</a></li>
  <li role="presentation"><a href="administrace.php" >Administrace</a></li>
</ul>');
/*echo ("<p id='registrace'><a href='odhlaseni.php'>Odhlaseni</a></p>"); 
 echo ("<p id='registrace'><a href='pridani.php'>Pridani</a></p>"); 
     echo ("<p id='registrace'><a href='administrace.php'>Administrace</a></p>");    */

}
  /* if(isset($_SESSION["user_is_logged"]))
   {
    echo ("<p id='registrace'><a href='pridani.php'>Pridani</a></p>"); 
     echo ("<p id='registrace'><a href='administrace.php'>Administrace</a></p>"); 
   }         */
 }
 

}
 
?>      
  
<?php 

// Třída pro připojení databáze
class mojeMysql extends mysqli
{
   public function __construct($adresa, $login, $heslo, $db)
   {
      parent::__construct($adresa, $login, $heslo, $db);                      
      $this->set_charset("utf8");
   }
}  

class zobrazeni
{
    private $server = "127.0.0.1";
    private $jmenoServer = "root";
    private $hesloServer = "";
    private $databazeServer = "velikonoce";
    
    public function __construct()
    {
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
       //include 'pripojeni.php';
       //$zavolani = new pripojeni();
       //$zavolani->PripojeniServer();
     //  $this->DotazMysql($zavolani);          
    }
    
     // Metoda s mysql dotazem
    public function DotazMysql($mojeMysql)
    {
         $prikazMysql = "SELECT id, titulek, datum, mesto, od FROM lide LEFT JOIN mista ON id=id_mista ORDER BY datum DESC";
         $vysledekMysql = $mojeMysql->query($prikazMysql);  
      //   print_r( $vysledekMysql); 
      //   exit();      
         $this->Titulky($vysledekMysql, $mojeMysql);
    } 
    
    public function Titulky($vysledekMysql, $mojeMysql)
    {     
    echo("<h1>Příspěvky</h1>");              
         while ($radek = $vysledekMysql->fetch_array(MYSQLI_ASSOC)) 
         {
          // $id = $radek["id"];
           //  $titulek = $radek["titulek"];
              //$mesto = $radek["mesto"];
          //    echo($mesto);
         //      session_start();
                                        //$radek["datum"]
                     $datum = new DateTime($radek["datum"]);
                  echo('
                  <div class="panel panel-success">
                  <a href="clanek.php?id='.$radek["id"].'" class="list-group-item">'.$radek["titulek"].'</a>
                Město: '.$radek["mesto"]." | Přidáno: ".$datum->format('m.d.Y v H:i:s').'
              </div>');
          //  echo("<p><a href='clanek.php?id=".$radek["id"]."' >".$radek["titulek"]."</a></p>");
           ///echo($radek["mesto"]." ".$radek["datum"]);
           if(isset($_SESSION["id"]))
         {
               $id = $_SESSION["id"];
           if($radek["od"] == $id)
           {
                 echo('<a href="editace.php?id='.$radek["id"].'" ><button type="button" class="btn btn-success">Editace</button></a>');
                 echo('<a href="smazat.php?id='.$radek["id"].'" ><button type="button" class="btn btn-danger">Smazat</button></a>');
           }
         }
         }
    } 
}
$vstup = new vstup();
//$vstup->Vstup();

    $zavolani = new zobrazeni();
//$zavolani->PripojeniServer();


?> 


</body>
</html>



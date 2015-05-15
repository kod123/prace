    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<?php
  class mojeMysql extends mysqli
{
   public function __construct($adresa, $login, $heslo, $db)
   {
      parent::__construct($adresa, $login, $heslo, $db);                      
      $this->set_charset("utf8");
   }
}

class clanek
{
  private $kod;
    public function __construct()
   {
     if(isset($_GET["id"]))
      {
          $this->kod = $_GET["id"];
          $this->PripojeniServer();
      }
   }
   public function PripojeniServer()
   {
      $mojeMysql = new mojeMysql('localhost', 'root', '', 'velikonoce');
  	  if ($mojeMysql->connect_error) 
  	  { 
         	die('Při připojení došlo k chybě: ' . $mojeMysql->connect_error . '. Číslo chyby: ' . $mojeMysql->connect_errno); 
  	  }
         $this->DotazMysql($mojeMysql);   
   }
   
   
   public function DotazMysql($mojeMysql)
  {
//  echo $this->kod;
    //$vyberMysql = $mojeMysql->query("SELECT jmeno, prijmeni, od, id, popis, datum, telefon, titulek, id_mista, mesto, psc, ulice, id_veci, pocet, predmet  FROM lide LEFT JOIN mista ON id=id_mista=".$this->kod." LEFT JOIN veci ON id=id_veci=".$this->kod."");
      $vyberMysql = $mojeMysql->query("SELECT * FROM lide, mista, veci WHERE id=".$this->kod." AND id_mista=".$this->kod." AND id_veci=".$this->kod);
     $this->Zpracovani($vyberMysql, $mojeMysql);
  }
  
   public function Zpracovani($vysledekMysql, $mojeMysql)
    {    
                     
         while ($radek = $vysledekMysql->fetch_array()) 
         {
           echo('
              <div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">'.$radek["titulek"].'</div>
  <div class="panel-body">
  <div>Popis:</div>
    <p>'.$radek["popis"].'</p>
  </div
  </div>
           
           <ul class="list-group">
  <li class="list-group-item">
    <span class="badge">'.$radek["od"].'</span>
    Autor:
  </li>
  <li class="list-group-item">
    <span class="badge">'.$radek["mesto"].'</span>
    Město:
  </li>
   <li class="list-group-item">
    <span class="badge">'.$radek["ulice"].'</span>
    Ulice:
  </li>
    </li>
   <li class="list-group-item">
    <span class="badge">'.$radek["psc"].'</span>
    PSČ:
  </li>
   <li class="list-group-item">
    <span class="badge">'.$radek["jmeno"].' '.$radek["prijmeni"].'</span>
    Kdo pohostil:
  </li>
    </li>
   <li class="list-group-item">
    <span class="badge">'.$radek["telefon"].'</span>
    Kontakt:
  </li>
     <li class="list-group-item">
    <span class="badge">'.$radek["predmet"].'</span>
    Věci:<br>
    <span class="badge">'.$radek["pocet"].'</span>
    Počet:
  </li>

</ul>');
      //    echo($radek["titulek"]."<br />");
       //   echo("Autor: ".$radek["od"]."<br />");
        //  echo("Místo: ".$radek["mesto"]." ".$radek["ulice"]." ".$radek["psc"]."<br />");
       //   echo("Kdo pohostil: ".$radek["jmeno"]." ".$radek["prijmeni"]."<br />");
        //  echo("Kontakt: ".$radek["telefon"]."<br />");
         // echo("Věci: ".$radek["predmet"]." Počet kusů: ".$radek["pocet"]." <br />");
   //       echo("Popis: ".$radek["popis"]." <br />");
      
      
         }
    } 
   
   
 



}

$zavolani = new clanek();
//$zavolani->PripojeniServer();
?>
   <nav>
  <ul class="pager">
    <li class="previous enable"><a href="velikonoce.php"><span aria-hidden="true">&larr;</span> Domů</a></li>
  </ul>
</nav>


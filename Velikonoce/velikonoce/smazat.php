<?php
   class mojeMysql extends mysqli
{
   public function __construct($adresa, $login, $heslo, $db)
   {
      parent::__construct($adresa, $login, $heslo, $db);                      
      $this->set_charset("utf8");
   }
}

class smazat
{
    private $prispevek;
   public function __construct()
   {
     if(isset($_GET["id"]))
      {
          $this->prispevek = $_GET["id"];
          //echo($this->prispevek);
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
    //$vyberMysql = $mojeMysql->query("SELECT jmeno, prijmeni, od, id, popis, datum, telefon, titulek, id_mista, mesto, psc, ulice, id_veci, pocet, predmet  FROM lide LEFT JOIN mista ON id=id_mista=".$this->kod." LEFT JOIN veci ON id=id_veci=".$this->kod."");
  //  $prikazMysql = "SELECT id, titulek, datum, mesto, od FROM lide LEFT JOIN mista ON id=".$this->prispevek;
     $vyberMysql = $mojeMysql->query("DELETE FROM lide WHERE id=".$this->prispevek);
     $vyberMysql = $mojeMysql->query("DELETE FROM mista WHERE id_mista=".$this->prispevek);
     $vyberMysql = $mojeMysql->query("DELETE FROM veci WHERE id_veci=".$this->prispevek);
      //$vyberMysql = $mojeMysql->query($prikazMysql);
     //$this->Zpracovani($vyberMysql, $mojeMysql);
      header("Location: velikonoce.php");
  }

}

$zavolani = new smazat();

?>
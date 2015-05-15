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

class editace
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
     $vyberMysql = $mojeMysql->query("SELECT * FROM lide, mista, veci WHERE id=".$this->prispevek." AND id_mista=".$this->prispevek." AND id_veci=".$this->prispevek."");
     // $vyberMysql = $mojeMysql->query("SELECT * FROM lide JOIN mista ON id=id_mista=".$this->prispevek);
      //$vyberMysql = $mojeMysql->query($prikazMysql);
     $this->Zpracovani($vyberMysql, $mojeMysql);
  }
  
    public function Zpracovani($vysledekMysql, $mojeMysql)
    {        // $this->Editovani($mojeMysql);       
         while ($radek = $vysledekMysql->fetch_array()) 
         {
             echo('<form method="POST" action="editace.php?id='.$this->prispevek.'" enctype="multipart/form-data">
     <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Jméno</label>
    <div class="col-sm-10">
            <input type="text" value='.$radek["jmeno"].' class="form-control" id="inputEmail3" name="jmeno" required="required" autofocus="autofocus"/>
          </div>
            </div>
            
               <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Příjmení</label>
             <div class="col-sm-10">

            <input type="text" value='.$radek["prijmeni"].' class="form-control" id="inputEmail3" name="prijmeni" required="required"/>
               </div>
            </div>
          
           <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Město</label>
             <div class="col-sm-10">
            <input type="text" value='.$radek["mesto"].' class="form-control" id="inputEmail3" name="mesto" required="required"/>
                   </div>
            </div>
       
                <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Ulice</label>
             <div class="col-sm-10">
            <input type="text" value='.$radek["ulice"].' class="form-control" id="inputEmail3" name="ulice"  required="required"/>
                       </div>
            </div>
       
     
               <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">PSČ</label>
             <div class="col-sm-10">
            <input type="text" value='.$radek["psc"].' class="form-control" id="inputEmail3" name="psc" required="required" />
                           </div>
            </div>
       
                <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Telefon</label>
             <div class="col-sm-10">
            <input type="text" value='.$radek["telefon"].' class="form-control" id="inputEmail3" name="telefon" required="required" />
                             </div>
            </div>
       
                <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Co se dostalo</label>
             <div class="col-sm-10">
            <input type="text" value='.$radek["predmet"].' class="form-control" id="inputEmail3" name="predmet" required="required" />   
                             </div>
            </div>
         
            <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Počet</label>
             <div class="col-sm-10">
     
            <input type="text" value='.$radek["pocet"].' class="form-control"  name="pocet" required="required" />
                               </div>
            </div>
     
     
    <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Titulek</label>
             <div class="col-sm-10">
            <input type="text" value='.$radek["titulek"].' class="form-control"  name="titulek" class="velke" required="required" autofocus="autofocus"/>
                              </div>
            </div>
       
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Popis</label>
             <div class="col-sm-10">
         
            <textarea  class="form-control" name="popis" required="required">'.$radek["popis"].'</textarea>
                                  </div>
            </div>
      
          <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <input type="submit" class="vytvorit_ucet" value="Přidat" name="pridat"/>
        
               </div>
  </div>
      </form>');
       /*   echo($radek["titulek"]."<br />");
          echo("Autor: ".$radek["od"]."<br />");
          echo("Místo: ".$radek["mesto"]." ".$radek["ulice"]." ".$radek["psc"]."<br />");
          echo("Kdo pohostil: ".$radek["jmeno"]." ".$radek["prijmeni"]."<br />");
          echo("Kontakt: ".$radek["telefon"]."<br />");
          echo("Věci: ".$radek["predmet"]." Počet kusů: ".$radek["pocet"]." <br />");
          echo("Popis: ".$radek["popis"]." <br />");
                                                      */
      
         }
         if(isset($_POST["pridat"]))
         {
          //   header("Location: velikonoce.php");
        // echo("ahooj");
           $this->Editovani($mojeMysql);
         }
    }
    
    public function Editovani($mojeMysql)
    {
        $mojeMysql->query("UPDATE lide, mista, veci SET jmeno='".$_POST["jmeno"]."', prijmeni='".$_POST["prijmeni"]."', mesto='".$_POST["mesto"]."', ulice='".$_POST["ulice"]."', psc='".$_POST["psc"]."', telefon='".$_POST["telefon"]."', popis='".$_POST["popis"]."', pocet='".$_POST["pocet"]."', titulek='".$_POST["titulek"]."', datum=NOW() WHERE id=".$this->prispevek." AND id_mista=".$this->prispevek." AND id_veci=".$this->prispevek.""); 
      
         
              //echo("ahoj");
        //$mojeMysql->query("UPDATE lide SET jmeno='".$_POST["jmeno"]."' WHERE id=1");
    }
  
   }
 


 $zavolani = new editace();
?>

   <nav>
  <ul class="pager">
    <li class="previous enable"><a href="velikonoce.php"><span aria-hidden="true">&larr;</span> Domů</a></li>
  </ul>
</nav>
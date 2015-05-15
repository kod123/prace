    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <h1>Přidání nového záznamu</h1>

    <form method="POST" action="pridani.php" class="form-horizontal">
  
       
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Jméno</label>
    <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="jmeno" required="required" autofocus="autofocus"/>
          </div>
            </div>
            
               <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Příjmení</label>
             <div class="col-sm-10">

            <input type="text" class="form-control" id="inputEmail3" name="prijmeni" required="required"/>
               </div>
            </div>
          
           <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Město</label>
             <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="mesto" required="required"/>
                   </div>
            </div>
       
                <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Ulice</label>
             <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="ulice"  required="required"/>
                       </div>
            </div>
       
     
               <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">PSČ</label>
             <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="psc" required="required" />
                           </div>
            </div>
       
                <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Telefon</label>
             <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="telefon" required="required" />
                             </div>
            </div>
       
                <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Co se dostalo</label>
             <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" name="predmet" required="required" />   
                             </div>
            </div>
         
            <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Počet</label>
             <div class="col-sm-10">
     
            <input type="text" class="form-control"  name="pocet" required="required" />
                               </div>
            </div>
     
     
    <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Titulek</label>
             <div class="col-sm-10">
            <input type="text" class="form-control"  name="titulek" class="velke" required="required" autofocus="autofocus"/>
                              </div>
            </div>
       
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Popis</label>
             <div class="col-sm-10">
         
            <textarea  class="form-control" name="popis" required="required"></textarea>
                                  </div>
            </div>
       
     
            <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      
        <input type="submit" class="btn btn-default" value="Přidat" name="tlacitko"/>
           </div>
  </div>
    
    


<?php
 class mojeMysql extends mysqli
{
   public function __construct($adresa, $login, $heslo, $db)
   {
      parent::__construct($adresa, $login, $heslo, $db);                      
      $this->set_charset("utf8");
   }
}

class informace
{
 public function PredaniVstupu()
    {
      if(isset($_POST["tlacitko"]))
      {
       $jmenoVstup = $_POST["jmeno"];
       $prijmeniVstup = $_POST["prijmeni"];
       $mestoVstup = $_POST["mesto"];
       $uliceVstup = $_POST["ulice"];
       $pscVstup = $_POST["psc"];
       $telefonVstup = $_POST["telefon"];
       $predmetVstup = $_POST["predmet"];
       $pocetVstup = $_POST["pocet"];
        $titulekVstup = $_POST["titulek"];                   
       $popisVstup = $_POST["popis"];          
    
       $pridej = new pridani($jmenoVstup, $prijmeniVstup, $mestoVstup, $uliceVstup, $pscVstup, $telefonVstup, $predmetVstup, $pocetVstup,  $titulekVstup, $popisVstup); 
     }
    }

}

class pridani
{
  private $jmenoV;
  private $prijmeniV;
  private $mestoV;
  private $uliceV;
  private $pscV;
  private $telefonV;
  private $predmetV;
  private $pocetV;
    private $titulekV;
  private $popisV;
  private $id;

 public function __construct($jmenoVstup, $prijmeniVstup, $mestoVstup, $uliceVstup, $pscVstup, $telefonVstup, $predmetVstup, $pocetVstup,  $titulekVstup, $popisVstup)
  {
  session_start();
	    $this->jmenoV = $jmenoVstup;
      $this->prijmeniV = $prijmeniVstup;
      $this->mestoV = $mestoVstup;
      $this->uliceV = $uliceVstup;
      $this->pscV = $pscVstup;
      $this->telefonV = $telefonVstup;
      $this->predmetV = $predmetVstup;
      $this->pocetV = $pocetVstup;
        $this->titulekV = $titulekVstup;
       $this->popisV = $popisVstup;
      $this->id = $_SESSION["id"]; 
      $this->PripojeniServer();
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
  // echo ($this->id.$this->jmenoV.$this->prijmeniV.$this->pscV.$this->telefonV.$this->popisV);
    $mojeMysql->query("INSERT INTO lide (od, jmeno, prijmeni, telefon, titulek, popis, datum) VALUES ('$this->id', '$this->jmenoV','$this->prijmeniV', '$this->telefonV', '$this->titulekV', '$this->popisV', NOW())"); 
     $prikazMysql = "SELECT LAST_INSERT_ID() AS posledni FROM lide";
         $vysledekMysql = $mojeMysql->query($prikazMysql); 
         $posledni;
         while ($radek = $vysledekMysql->fetch_array(MYSQLI_ASSOC)) 
         { 
             $posledni = $radek["posledni"];
               // echo $posledni;
        }
    $mojeMysql->query("INSERT INTO mista (id_mista, mesto, psc, ulice) VALUES ('$posledni', '$this->mestoV', '$this->pscV','$this->uliceV')"); 
     $mojeMysql->query("INSERT INTO veci (id_veci, predmet, pocet) VALUES ('$posledni', '$this->predmetV', '$this->pocetV')"); 
        //   $mojeMysql->query("INSERT INTO pocet (id, pocet) VALUES ('$this->predmetV', '$this->pocetV')"); 
      $mojeMysql->Close();
   } 
}

$zavolani = new informace();
$zavolani->PredaniVstupu();
?>
 </form>
   <nav>
  <ul class="pager">
    <li class="previous enable"><a href="velikonoce.php"><span aria-hidden="true">&larr;</span> Domů</a></li>
  </ul>
</nav>


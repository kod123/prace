<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset = "UTF-8" />
    <title>Formular</title>
      <link rel="stylesheet" href="" type="text/css" media="all"/>
      <style>
      fieldset {
        width: 320px;
      }
      </style>
  </head>

<body>
 
  <form  method="GET" action="formular.php">
  <fieldset >
    <legend>Osobní údaje</legend>
    <p>Zadejte své křestní jméno:<br>
    <input type="text" name="jmeno" value=""/></p>
    
    <p>Zadejte své příjmení:<br>
    <input type="text" name="prijmeni" value=""/></p>

    Zvolte své datum narození:<br>   
    <select name="den">
    <option value="den" selected="selected">Den</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option>
    <option value="25">25</option>
    <option value="26">26</option>
    <option value="27">27</option>
    <option value="28">28</option>
    <option value="29">29</option>
    <option value="30">30</option>
    <option value="31">31</option>             
    </select>
    
    <select name="mesic">
    <option value="mesic" selected="selected">Měsíc</option>
    <option value="1">Leden</option>
    <option value="2">Únor</option>
    <option value="3">Březen</option>
    <option value="4">Duben</option>
    <option value="5">Květen</option>
    <option value="6">Červen</option>
    <option value="7">Červenec</option>
    <option value="8">Srpen</option>
    <option value="9">Září</option>
    <option value="10">Říjen</option>
    <option value="11">Listopad</option>
    <option value="12">Prosinec</option> 
    </select>
    <input type="text" name="rok" value="Rok"/><br>
    </fieldset> 
    <p><input type="submit" /></p>
  
  </form>



 </body> 
</html> 
   <?php 
    if(isset($_GET["jmeno"]) && isset($_GET["prijmeni"]) && isset($_GET["rok"]))
    {
     $zacatek=false;
     $jmeno = $_GET["jmeno"];
     $prijmeni = $_GET["prijmeni"];
     $den = $_GET["den"];
     $mesic = $_GET["mesic"];
      
     if($jmeno == "" && $prijmeni)
        echo "Musíte vyplnit jméno!!!";
     elseif($prijmeni == "" && $jmeno)
        echo "Musíte vyplnit příjmení!!!";
     elseif ($jmeno == "" && $prijmeni == "")
        echo "Musíte vyplnit jméno a příjmení!!!";
    if (is_numeric($_GET["rok"]) && $jmeno && $prijmeni)
      {
        $rok = $_GET["rok"];
        if($rok > date("Y"))
        {
          echo "<br>"."Není možné, datum narození.";
          $rok = false;
        }
        elseif($rok < 1900)
        {
          echo "<br>"."Rok".$rok." je nesmysl, jste mrtvý.";
          $rok = false;  
        }
        else
        {
          $zacatek = true;
          if($den == date("d") && $mesic == date("m") && $rok != false)
          {
            echo "<br>"."Dnes máte narozeniny.";
            $pocet = date("Y") - $rok;
            echo "<br>"."Je Vám ".$pocet." let.";
          }
          elseif($rok == false)
            $rok = false;
          else
            echo "<br>"."Dnes nemáte narozeniny.";
        }
    }
    else
        echo " Musíte vyplnit rok narození.";
    if($zacatek == true)
      echo "<br>"."Vaše jméno a příjmení je: ".$jmeno." ".$prijmeni."";    
      }
  else 
  {
     $jmeno = false;
     $prijmeni = false;
     $rok = false;
     $mesic = false;
     $den = false;     
  }
  echo "<br>"." Dnes je: ".$date = date("d.m.Y");              
?>

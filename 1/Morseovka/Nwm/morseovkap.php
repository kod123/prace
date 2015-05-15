<!DOCTYPE html>
<html lang="cs">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"">
  <title>Morseova abeceda</title>
  <style>
  #vstup{
    margin-bottom:20px;
  }
  span {
    color: red;
  }
  #chyba {
   font-size: 1.5em;
   font-weight: bold;
  }
  </style>
</head>
<body>
<form  method="post" action="morseovkap.php">
<!--<select name="vyber">
<option name="moznostVyberu"> Vyberte možnost</option>
<option name="doMorseovy"> Do morseovy abecedy</option>
<option name="zMorseovy"> Z morseovy abecedy</option>
</select>-->
Zadejte větu k překladu do morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadano" id="vstup"/></textarea><br>
  
  <!--<textarea rows="10" cols="40"></textarea><br> -->
 

  



<?php 
   
//setcookie("nick",$nick,time()+31536000); //uloží cookie
  
   
 
  class Mor
 {
   //  mb_internal_encoding("UTF-8");
    
    public $zadano;
    //public $vypis;
    //public $bileZnaky;
    
   // public $sDiakritikou=array('á', 'ä', 'č', 'ď', 'é', 'ě', 'ë', 'í', 'ň','ó', 'ö', 'ř', 'š', 'ť','ú', 'ů', 'ü', 'ý', 'ž');
   // public $bezDiakritiky=array('a', 'a', 'c', 'd', 'e', 'e', 'e', 'i', 'n', 'o', 'o', 'r', 's', 't','u', 'u', 'u', 'y', 'z');
   // public $pismena=array('a', 'b', 'ch', 'd', 'e', 'f', 'g', 'h', 'c','i', 'j', 'k', 'l', 'm','n', 'o', 'p', 'q', 'r','s', 't', 'u', 'v', 'w','x', 'y', 'z','0','1','2', '3', '4', '5', '6','7', '8', '9', '?', '|', '!', ';', '/','"',':', '_', '+', '*', '@', ',', '(', ')');
    //public $morseovka=array('.- ', '-... ', '---- ', '-.. ', '. ', '..-. ', '--. ', '.... ', '-.-.', '.. ', '.--- ', '-.- ', '.-.. ', '-- ','-. ', '--- ', '.--. ', '--.- ', '.-. ','... ', '- ', '..- ', '...- ', '.-- ','-..- ', '-.-- ', '--.. ','----- ','.---- ','..--- ', '...-- ', '....- ', '..... ', '-.... ','--... ', '---.. ', '----. ','..--.. ','--..-- ','--...- ', '-.-.-. ', '-..-. ', '.-..- ','---... ', '..--.- ', '.-.-. ', '-.-.- ', '.--.-. ','--..-- ', '--... ', '-.--.- ');
    public $morseovka=array(
        ' ' => '',
        'ch' => '---- ',
        'a' => '.- ',
        'b' => '-... ',
        'c' => '-.-. ',
        'd' => '-.. ',
        'e' => '. ',
        'f' => '..-. ',
        'g' => '--. ',
        'h' => '.... ',
        'i' => '.. ',
        'j' => '.--- ',
        'k' => '-.- ',
        'l' => '.-.. ',
        'm' => '-- ',
        'n' =>'-. ',
        'o' => '--- ',
        'p' => '.--. ',
        'q' => '--.- ',
        'r' => '.-. ',
        's' =>'... ',
        't' => '- ',
        'u' => '..- ',
        'v' => '...- ',
        'w' => '.-- ',
        'x' =>'-..- ',
        'y' => '-.-- ',
        'z' => '--.. ',
        '0' =>'----- ',
        '1' =>'.---- ',
        '2' =>'..--- ',
        '3' => '...-- ',
        '4' => '....- ',
        '5' => '..... ',
        '6' => '-.... ',
        '7' =>'--... ',
        '8' => '---.. ',
        '9' => '----. ',
        '?' =>'..--.. ',
        '|' =>'--..-- ',
        '!' =>'--...- ',
        ';' => '-.-.-. ',
        '/' => '-..-. ',
        '"' => '.-..- ',
        ':' =>'---... ',
        '_' => '..--.- ',
        '+' => '.-.-. ',
        '*' => '-.-.- ',
        '@' => '.--.-. ',
        ',' =>'--..-- ',
        '(' => '--... ',
        ')' => '-.--.- '); 
  
    public function __construct($zadano)
    {
        //$zadano = $_POST['zadano'];
         //$zadano=$_GET['zadano'];
        $this->zadano=$zadano;
       // $zadano=$_GET['zadano'];
    }       
    
    public function mala()
    {    // $con->Morseovka();
       $mal=mb_strtolower($this->zadano);
       return $mal;  
    }
    
    public function bileZnaky()
    {
        $bilyZnak=trim($this->mala());
        return $bilyZnak;   
    }
    public function delka()
    {
      $del=mb_strlen($this->bileZnaky());
      return $del;
    }
    
    public function zjisteni()
    {
    for($i = 0; $i < $this->delka(); $i++)
    {
    $znak = mb_substr($this->bileznaky(), $i, 1); 
    return $znak;   
    } 
    }
    
    public function nahrazeni()
    {    
   /* for($i = 0; $i < $this->delka(); $i++)
    {
    $znak = mb_substr($this->bileznaky(), $i, 1); 
     
    } */      
        if (in_array($this->zjisteni(), $this->morseovka))
        {
            $vypis=str_replace(array_keys($morseovka),array_values($morseovka),$this->bileznaky());
               // return $vypis;
               return $vypis;
              
            // echo "Překlad na morseovu abecedu:<br>";
            //echo "<textarea rows='10' cols='40'>$vypis</textarea>";                     
        }
         
       /* else
       {  
       echo "nic";      
        /* if(in_array($this->zjisteni(), $this->sDiakritikou))
         {
            $vypis1=str_replace($this->sDiakritikou,$this->bezDiakritiky,$this->bileznaky());
            $vypis=str_replace($this->pismena,$this->morseovka,$vypis1);
              
           // echo "Překlad na morseovu abecedu:<br>";
            //echo "<textarea rows='10' cols='40'>$vypis</textarea>";
         }   */
         /*else
         {
         echo "nic";//"<div id='chyba'>Znak (<span>".$znak."</span>), není v morseově abecedě!!!<div>";
         }    */
        }   
           // return $vypis;
        
    
        //echo $vypis;
    }
    
  //  }
 /*   public function vraceni()
    {
        //$nwm = new Morsevoka($zadano=$_GET['zadano']);
        return   $vypis;
    
    }   */  
   /* public function volani()
    {
      
    }*/  
   
      $kk = new Mor("a");   
     echo $kk->nahrazeni();  
    //$v->_toString();
    
    
    
    
    /*
    
    
    
    if (isset($_POST['zadano']))
    {
 
    //mb_internal_encoding("UTF-8");
    $zadano = $_POST['zadano'];
    $mala=mb_strtolower($zadano);
    $bileZnaky=trim($mala);
    // $bezDiakritiky= str_replace('á', 'a', $bileZnaky);
    $delka=mb_strlen($bileZnaky);
    $sDiakritikou=array('á', 'ä', 'č', 'ď', 'é', 'ě', 'ë', 'í', 'ň','ó', 'ö', 'ř', 'š', 'ť','ú', 'ů', 'ü', 'ý', 'ž');
    $bezDiakritiky=array('a', 'a', 'c', 'd', 'e', 'e', 'e', 'i', 'n', 'o', 'o', 'r', 's', 't','u', 'u', 'u', 'y', 'z');
    $pismena=array('a', 'b', 'ch', 'd', 'e', 'f', 'g', 'h', 'c','i', 'j', 'k', 'l', 'm','n', 'o', 'p', 'q', 'r','s', 't', 'u', 'v', 'w','x', 'y', 'z','0','1','2', '3', '4', '5', '6','7', '8', '9', '?', '|', '!', ';', '/','"',':', '_', '+', '*', '@', ',', '(', ')');
    $morseovka=array('.- ', '-... ', '---- ', '-.. ', '. ', '..-. ', '--. ', '.... ', '-.-.', '.. ', '.--- ', '-.- ', '.-.. ', '-- ','-. ', '--- ', '.--. ', '--.- ', '.-. ','... ', '- ', '..- ', '...- ', '.-- ','-..- ', '-.-- ', '--.. ','----- ','.---- ','..--- ', '...-- ', '....- ', '..... ', '-.... ','--... ', '---.. ', '----. ','..--.. ','--..-- ','--...- ', '-.-.-. ', '-..-. ', '.-..- ','---... ', '..--.- ', '.-.-. ', '-.-.- ', '.--.-. ','--..-- ', '--... ', '-.--.- ');
    
   
    for($i = 0; $i < $delka; $i++)
    {
    $znak = mb_substr($bileZnaky, $i, 1);      
    }       
        if (in_array($znak, $pismena))
        {
            $vypis=str_replace($pismena,$morseovka,$bileZnaky);
             echo "Překlad na morseovu abecedu:<br>";
            echo "<textarea rows='10' cols='40'>$vypis</textarea>";                     
        }
        else
       {        
         if(in_array($znak, $sDiakritikou))
         {
            $vypis1=str_replace($sDiakritikou,$bezDiakritiky,$bileZnaky);
            $vypis=str_replace($pismena,$morseovka,$vypis1);
            echo "Překlad na morseovu abecedu:<br>";
            echo "<textarea rows='10' cols='40'>$vypis</textarea>";
         }
         else
         {
         echo "<div id='chyba'>Znak (<span>".$znak."</span>), není v morseově abecedě!!!<div>";
         }
        }
    }
  //}
}  */
       

   
?>

<p><input type="submit" /></p>
<!--Zadejte větu k překladu z morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadanoMor" id="vstup"/></textarea><br> -->
 </form>
 </body>
</html>
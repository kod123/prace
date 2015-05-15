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
<form  method="GET" action="morseovkauuu.php">

Zadejte větu k překladu do morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadano" id="vstup"/></textarea><br>

<?php 
   
//setcookie("nick",$nick,time()+31536000); //uloží cookie
    mb_internal_encoding("UTF-8");
class morseovka
     {
     
    
    
    //public $zadano;
    //public $vypis;
    //public $bileZnaky;
    public $morseovka = array('//' => ' ',
                              '----/' => 'ch',
                              '.-/' => 'a',
                              '-.../' => 'b',
                              '-.-./' => 'c',
                              '-../' => 'd',
                              './' => 'e',
                              '..-./' => 'f',
                              '--./' => 'g',
                              '..../' => 'h',
                              '../' => 'i',
                              '.---/' => 'j',
                              '-.-/' => 'k',
                              '.-../' => 'l',
                              '--/' => 'm',
                              '-./' =>'n',
                              '---/' => 'o',
                              '.--./' => 'p',
                              '--.-/' => 'q',
                              '.-./' => 'r',
                              '.../' =>'s',
                              '-/' => 't',
                              '..-/' => 'u',
                              '...-/' => 'v',
                              '.--/' => 'w',
                              '-..-/' =>'x',
                              '-.--/' => 'y',
                              '--../' => 'z',
                              '-----/' => '0',
                              '----./' => '1',
                              '..---/' => '2',
                              '...--/' => '3',
                              '....-/' => '4',
                              '...../' => '5',
                              '-..../' => '6',
                              '--.../' => '7',
                              '---../' => '8',
                              '----./' => '9',
                              '..--../' => '?',
                              '--..--/' => '|',
                              '--...-/' => '!',
                              '-.-.-./' => ';',                           
                              '.-..-/' => '"',
                              '---.../' =>':',
                              '..--.-/' => '_',
                              '.-.-.' => '+',
                              '-.-.-/' => '*',
                              '.--.-./' => '@',
                              '--..--/' =>',',
                              '--.../' => '(',
                              '-.--.-/' => ')'
                             /* '.-/' => 'á',
                              '.-/' => 'ä',
                              '-.-./' => 'č',
                                '-../' => 'ď',
                                './' => 'é',
                                './' => 'ě',
                                './' => 'ë', 
                                '../' => 'í', 
                                '-./' => 'ň',
                                '---/' => 'ó', 
                                '---/' => 'ö', 
                                '.-./' => 'ř', 
                                '.../' => 'š', 
                                '-/' => 'ť',
                                '..-/' => 'ú', 
                                '..-/' => 'ů', 
                                '..-/' => 'ü', 
                                '-.--/' => 'ý', 
                                '--../' => 'ž'*/);
       
    /*  public $diakritika=array('a' => 'á',
                                'a' => 'ä',
                                'c' => 'č',
                                'd' => 'ď',
                                'e' => 'é',
                                'e' => 'ě',
                                'e' => 'ë', 
                                'i' => 'í', 
                                'n' => 'ň',
                                'o' => 'ó', 
                                'o' => 'ö', 
                                'r' => 'ř', 
                                's' => 'š', 
                                't' => 'ť',
                                'u' => 'ú', 
                                'u' => 'ů', 
                                'u' => 'ü', 
                                'y' => 'ý', 
                                'z' => 'ž');      */     
   
                             public   $prevodniTabulka = array(
                            /*  'ch'=>'ch',
                             'a'=>'a',
                             'b'=>'b',
                             'c'=>'c',
                             'd'=>'d',
                             'e'=>'e',
                             'f'=>'f',
                             'g'=>'g',
                             'h'=>'h',
                             'i'=>'i',
                             'j'=>'j',
                             'a'=>'á',
                             'k'=>'k',
                             'l'=>'l',
                             'm'=>'m',
                             'n'=>'n',
                             'o'=>'o',                           
                             'p'=>'p',
                             'q'=>'q',
                             'r'=>'r',
                             's'=>'s',
                             't'=>'t',
                             'u'=>'u',                            
                             'v'=>'v',
                             'w'=>'w',
                             'x'=>'x',
                             'y'=>'y',
                             'z'=>'z',*/
                             'a'=>'á',
                             'c'=>'č',
                             'd'=>'ď',
                             'e'=>'ě',
                             'a'=>'é',
                             'n'=>'ň',
                             'o'=>'ó',
                             'r'=>'ř',
                             's'=>'š',
                             't'=>'ť',
                             'u'=>'ú',
                             'u'=>'ů',
                             'y'=>'ý',
                             'z'=>'ž',                            
                             'i'=>'í');
                             
                                  
  //  public $sDiakritikou=array('á', 'ä', 'č', 'ď', 'é', 'ě', 'ë', 'í', 'ň','ó', 'ö', 'ř', 'š', 'ť','ú', 'ů', 'ü', 'ý', 'ž');
   
  //  public $bezDiakritiky=array('a', 'a', 'c', 'd', 'e', 'e', 'e', 'i', 'n', 'o', 'o', 'r', 's', 't','u', 'u', 'u', 'y', 'z');
  //  public $pismena=array('a', 'b', 'ch', 'd', 'e', 'f', 'g', 'h', 'c','i', 'j', 'k', 'l', 'm','n', 'o', 'p', 'q', 'r','s', 't', 'u', 'v', 'w','x', 'y', 'z','0','1','2', '3', '4', '5', '6','7', '8', '9', '?', '|', '!', ';', '/','"',':', '_', '+', '*', '@', ',', '(', ')');
    //public $morseovka=array('.-/', '-.../', '----/', '-../', './', '..-./', '--./', '..../', '-.-./', '../', '.---/', '-.-/', '.-../', '--/', '-./', '---/', '.--./', '--.-/', '.-./', '.../', '-/', '..-/', '...-/', '.--/', '-..-/', '-.--/', '--../', '-----/','.----/','..---/', '...--/', '....-/', '...../', '-..../','--.../', '---../', '----./','..--../','--..--/','--...-/', '-.-.-./', '-..-./', '.-..-/','---.../', '..--.-/', '.-.-./', '-.-.-/', '.--.-./','--..--/', '--.../', '-.--.-/');
      // public $morseovka=array('.-\/', '-... ', '---- ', '-.. ', '. ', '..-. ', '--. ', '.... ', '-.-.', '.. ', '.--- ', '-.- ', '.-.. ', '-- ','-. ', '--- ', '.--. ', '--.- ', '.-. ','... ', '- ', '..- ', '...- ', '.-- ','-..- ', '-.-- ', '--.. ','----- ','.---- ','..--- ', '...-- ', '....- ', '..... ', '-.... ','--... ', '---.. ', '----. ','..--.. ','--..-- ','--...- ', '-.-.-. ', '-..-. ', '.-..- ','---... ', '..--.- ', '.-.-. ', '-.-.- ', '.--.-. ','--..-- ', '--... ', '-.--.- '); 
     
    public function vstup()
    {
      if(isset($_GET['zadano']))
      {                 
         $zadano=$_GET['zadano'];
         return $zadano; 
       }
       
    }  
          
    public function kliceDiakritika()
    {
    $klicePoleDiakritika = array_keys($this->prevodniTabulka);
    return $klicePoleDiakritika;
    }
    
    public function hodnotyDiakritika()
    {
    $hodnotyPoleDiakritika = array_values($this->prevodniTabulka);
    return $hodnotyPoleDiakritika;
    }      
    
    public function mala()
    {   
       $mal=mb_strtolower($this->vstup());
       return $mal;  
    }
    
    public function odstraneniDiakritiky()
    {
      $prevod = str_replace($this->hodnotyDiakritika(),$this->kliceDiakritika(),$this->mala());
      return $prevod;
    }
            
    public function bileZnaky()
    {
        $bileZnak=trim($this->odstraneniDiakritiky());
        return $bileZnak;   
    }
    
    public function delka()
    {
      $del=mb_strlen($this->bileZnaky());
      return $del;
    }   
    
    public function znaky()
    {
     for($i = 0; $i < $this->delka(); $i++)
     {
       $znak = mb_substr($this->bileznaky(), $i, 1);    
       return $znak;  
     }   
    } 
        
    public function klice()
    {
    $klicePole = array_keys($this->morseovka);
    return $klicePole;
    }
    
    public function hodnoty()
    {
    $hodnotyPole= array_values($this->morseovka);
    return  $hodnotyPole;
    }
    
    /*  public function kliceDiakritika()
    {
    $klicePoleDiakritika = array_keys($this->diakritika);
    return $klicePoleDiakritika;
    }
    
    public function hodnotyDiakritika()
    {
    $hodnotyPoleDiakritika = array_values($this->diakritika);
    return $hodnotyPoleDiakritika;
    }          */
    
      
    
            
    
    public function nahrazeni()
    {    
           
       if (in_array($this->znaky(), $this->hodnoty()))
        {
            $vypis=str_replace($this->hodnoty(),$this->klice(),$this->bileZnaky());
            return $vypis;
            // echo "Překlad na morseovu abecedu:<br>";
            //echo "<textarea rows='10' cols='40'>$vypis</textarea>";                     
        }
   
        
       // {
             
        /* if(in_array($this->znaky(), $this->sDiakritikou))
         {
            $vypis1=str_replace($this->sDiakritikou,$this->bezDiakritiky,$this->bileZnaky());
            $vypis=str_replace($this->hodnoty(),$this->klice(),$vypis1);
            return $vypis;
           // echo "Překlad na morseovu abecedu:<br>";
            //echo "<textarea rows='10' cols='40'>$vypis</textarea>";
         }*/
         else 
         {  
          if(empty($_GET['zadano']))
          {
            echo "";
          }  
          else
          {
         echo "Znak (".$this->znaky().") není morseově abecedě!!!";//"<div id='chyba'>Znak (<span>".$znak."</span>), není v morseově abecedě!!!<div>";
         }
         } 
        // }
         }
          
    public function vypis()
    {
        return $this->nahrazeni();   
    }   
  }
   

   
?>
 
 
 <textarea rows="10" cols="40"/><?php   mb_internal_encoding("UTF-8");$kk = new morseovka(); echo $kk->vypis();?></textarea><br> 
<p><input type="submit" /></p>

 </form>
 </body>
</html>
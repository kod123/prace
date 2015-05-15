<!DOCTYPE html>
<html lang="cs">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"">
  <title>Morseova abeceda</title>
   <link rel="stylesheet" href="morseovka.css" type="text/css" media="all"/>

</head>
<body>
<form  method="GET" action="celkova.php">

Zadejte větu k překladu do morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadano" id="vstup"/><?php   mb_internal_encoding("UTF-8");$kk = new morseovka(); echo $kk->vypis2(); echo $kk->vstupNormal()?></textarea><br>

<?php 
/*   
    mb_internal_encoding("UTF-8");
class morseovka
  {
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
                              '-.--.-/' => ')');     
   
   public   $bezHacku = array('a'=>'á',
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
     
    public function vstupNormal()
    {
      if(isset($_GET['zadano']) && empty($_GET['vypis']))
      {                 
         $zadano=$_GET['zadano'];
         return $zadano; 
       }       
    }  
     
     public function vstupMorseovka()
     {
       if(isset($_GET['vypis']) && empty($_GET['zadano'])) 
       {
         $zadano=$_GET['vypis'];
         return $zadano; 
       }  
     }
               
    public function kliceDiakritika()
    {
      $klicePoleDiakritika = array_keys($this->bezHacku);
      return $klicePoleDiakritika;
    }
    
    public function hodnotyDiakritika()
    {
      $hodnotyPoleDiakritika = array_values($this->bezHacku);
      return $hodnotyPoleDiakritika;
    }      
    
    public function rozdeleniMorseovka()
    {
      $rozdel = explode('/',$this->vstupMorseovka());
      return  $rozdel;
    } 
       
    public function malaPismena()
    {  
      $mal=mb_strtolower($this->vstupNormal());
      return $mal; 
    }
    
    public function odstraneniDiakritiky()
    {
      $prevod = str_replace($this->hodnotyDiakritika(),$this->kliceDiakritika(),$this->malaPismena());
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
    
    public function znakyProchazeni()
    {
      for($i = 0; $i < $this->delka(); $i++)
      {
        $znak = mb_substr($this->bileznaky(), $i, 1);    
        return $znak;  
      }  
    } 
     
     public function znakymor()
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
     
     
     public function prohlizeniMor()
     {
    // $hodnotyPole= array_values($this->rozdeleniMorsevka());
    //  return  $hodnotyPole;
      foreach($this->rozdeleniMorseovka() as $klic=>$hodnota)
     {
        return $hodnota;//if(in_array($klic, $this->klice()))
      }
     }           
    public function nahrazeni()
    {    
      if(isset($_GET['zadano']) && empty($_GET['vypis']))
      {    
        if (in_array($this->znakyProchazeni(), $this->hodnoty()))
        {
          $vypis=str_replace($this->hodnoty(),$this->klice(),$this->bileZnaky());
          return $vypis;                  
        }        
         else 
         {  
           if(empty($_GET['zadano']))
           {
             echo "";
           }  
           else
           {
             echo "Znak (".$this->znaky().") není morseově abecedě!!!";
           }
         } 
      }   
      else
      {
      if(!in_array($this->prohlizeniMor(), $this->klice()))
      {
         foreach($this->rozdeleniMorseovka() as $klic=>$hodnota)
         {
           if($hodnota=$this->klice())
           {
            $vypis=str_replace($hodnota, $this->hodnoty(), $this->vstupMorseovka());
            $vypis1=str_replace("/","", $vypis);
            return $vypis1;           
           } 
            
         }
        }
        else
            {
              echo "Znak (".$this->prohlizeniMor().") není morseově abecedě!!!" ;
            }
      }
    }
          
    public function vypis()
    {     
      if(isset($_GET['zadano']) && empty($_GET['vypis']))
      {
        return $this->nahrazeni(); 
      }
    }
    
    public function vypis2()
    {    
      if(isset($_GET['vypis']) && empty($_GET['zadano'])) 
      {
        return $this->nahrazeni(); 
      } 
    }     
}
    */
?>  
            
Zadejte větu k překladu do České abecedy:<br> 
 <textarea rows="10" cols="40" name="vypis"/><?php   mb_internal_encoding("UTF-8"); $kk = new morseovka(); echo $kk->vypis(); echo $kk->vstupMorseovka()?></textarea><br> 
<p><input type="submit" /></p>

 </form>
 </body>
</html>
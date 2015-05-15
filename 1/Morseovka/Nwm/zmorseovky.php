<!DOCTYPE html>
<html lang="cs">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"">
  <title>Morseova abeceda</title>
  <style>
 /* #vstup{
    margin-bottom:20px;
  }
  span {
    color: red;
  }
  #chyba {
   font-size: 1.5em;
   font-weight: bold;
  }  */
  </style>
</head>
<body>
<form  method="GET" action="zmorseovky.php">
<!--<select name="vyber">
<option name="moznostVyberu"> Vyberte možnost</option>
<option name="doMorseovy"> Do morseovy abecedy</option>
<option name="zMorseovy"> Z morseovy abecedy</option>
</select>-->
Zadejte větu k překladu do morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadano" id="vstup"/></textarea><br>
  
  <!--<textarea rows="10" cols="40"></textarea><br> -->
 
   
<!--Zadejte větu k překladu z morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadanoMor" id="vstup"/></textarea><br> -->

  

<?php 
   
//setcookie("nick",$nick,time()+31536000); //uloží cookie

  //class morseovka
 //{
 //function upravatextu($zadano)
 //{ 
   // header("Content-Type: text/html; charset=windows-1250");
 // mb_language("uni");
  //mb_internal_encoding("UTF-8");
  //header('Content-Type: text/html; charset=UTF-8');
    mb_internal_encoding("UTF-8");
class morseovka
    {
     
    
    
    //public $zadano;
    //public $vypis;
    //public $bileZnaky;
    public $morseovka = array('----' => 'ch',
                              '.-' => 'a',
                              '-...' => 'b',
                              '-.-.' => 'c',
                              '-..' => 'd',
                              '.' => 'e',
                              '..-.' => 'f',
                              '--.' => 'g',
                              '....' => 'h',
                              '..' => 'i',
                              '.---' => 'j',
                              '-.-' => 'k',
                              '.-..' => 'l',
                              '--' => 'm',
                              '-.' =>'n',
                              '---' => 'o',
                              '.--.' => 'p',
                              '--.-' => 'q',
                              '.-.' => 'r',
                              '...' =>'s',
                              '-' => 't',
                              '..-' => 'u',
                              '...-' => 'v',
                              '.--' => 'w',
                              '-..-' =>'x',
                              '-.--' => 'y',
                              '--..' => 'z',
                              '-----' => '0',
                              '----.' => '1',
                              '..---' => '2',
                              '...--' => '3',
                              '....-' => '4',
                              '.....' => '5',
                              '-....' => '6',
                              '--...' => '7',
                              '---..' => '8',
                              '----.' => '9',
                              '..--..' => '?',
                              '--..--' => '|',
                              '--...-' => '!',
                              '-.-.-.' => ';',                           
                              '.-..-' => '"',
                              '---...' =>':',
                              '..--.-' => '_',
                              '.-.-.' => '+',
                              '-.-.-' => '*',
                              '.--.-.' => '@',
                              '--..--' =>',',
                              '--...' => '(',
                              '-.--.-' => ')'
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
   
                          /*   public   $prevodniTabulka = array(
                              'ch'=>'ch',
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
                             'a'=>'â',
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
                             'z'=>'z',
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
                             'i'=>'í');    */
                             
                                  
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
     
     public function rozdeleni()
    {
      $rozdel = explode('/',$this->vstup());
     //$hodnotyRoz= array_values($rozdel);
      return  $rozdel;
    }     
  /*  public function kliceDiakritika()
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
    }   */
        
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
    
  /*  public function hodnoty2()
    {
    $hodnotyPole= array_values($this->rozdeleni());
    return $hodnotyPole;
    } 
    
    public function prochazeni()
    {
      foreach($this->klice() as $a)
    {
    return  $a;
    }
    }
    
    public function prochazeni2()
    {
      foreach($this->hodnoty2() as $a)
    {
    return  $a;
    }
    }   */
    /*public functio prochazeni()
    {
    foreach($this->morseovka as $klic =>$hodnota)
     {
      return $klic;
      }
    }   */
    
    /* public functio prochazeni2()
    {
    foreach($this->rozdeleni as $klic =>$hodnota)
     {
      return $klic;
      }
    }  */
   /* public function delkamor()
    {
    foreach($this->klice() as $klic=>$hodnota)
    {
      $del=mb_strlen($klic);
      return $del;
    }
    } */
    
    /*  public function delka()
    {
    foreach ($this->rozdeleni() as $klic=>$hodnota)
    {
      $del=mb_strlen($hodnota);
      return $del;
      }
    }
      
    public function delka2()
    {
      foreach ($this->morseovka as $klic=>$hodnota)
      {
      $del=mb_strlen($klic);
      return $del;
      }  
    } */  
   // }
   /* public function znakymor()
    {
     for($i = 0; $i < $this->delkamor(); $i++)
     {
       $znak = mb_substr($this->delkamor(), $i, 1);    
       return $znak;  
     }   
    } */
  /*   public function hodnoty2()
    {
    $hodnotyPole= array_keys($this->morseovka);
    return  $hodnotyPole;
    }   */
    
    
    
    
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
    
    /* public function zjisteniroz()
     {
     $b=$this->rozdeleni();
      foreach($a as $b)
      {
            return $a;
      }
    
     } 
     
     public function zjistenimor()
     {
      $b=$this->rozdeleni();
      foreach($a as $b)
      {
          return $a;
      }
     }    */
   /*    
    
    public function znaky()
    {
     for($i = 0; $i < $this->delka(); $i++)
     {
       $znak = mb_substr($this->delka(), $i, 1);    
       return $znak;  
     }   
    } */
            
    
  /*  public function nahrazeni()
    {    
    
          foreach($this->morseovka as $klic =>$hodnota)
       {
             return $klic;
           
            } 
            
               
        } 
        
        public function nahrazeni2()
    {    
    
          foreach($this->rozdeleni() as $klic =>$hodnota)
       {
             return $hodnota;
           
            } 
            
               
        }*/ 
    
  /*  
    public function nahrazeni()
    {  
  
      //foreach($this->rozdeleni() as $klic =>$hodnota)
     //  {
          
             if($this->prochazeni2()===$this->prochazeni())
             {
            $vypis=str_replace($this->prochazeni2(),$this->prochazeni(),$this->vstup());
            $vypis1=str_replace($vypis,$this->hodnoty(),$this->vstup());
             return $vypis1;
           
            }   */
            
               
       // } 
      //  } 
//------------------------------------------------------------    
      public function nahrazeni()
    {  
  
     // foreach($this->rozdeleni() as $klic =>$hodnota)
      // {
              foreach($this->rozdeleni() as $klic=>$hodnota)
              {
             if($hodnota=$this->klice())
             {
            $vypis=str_replace($hodnota,$this->hodnoty(),$this->vstup());
            $vypis1=str_replace("/","", $vypis);
             return $vypis1;
           
            } 
            }
            
               
       //} 
        }    
 //-------------------------------------------------------------------           
            // echo "Překlad na morseovu abecedu:<br>";
            //echo "<textarea rows='10' cols='40'>$vypis</textarea>";                     
        //}
   
        
       // {
             
        /* if(in_array($this->znaky(), $this->sDiakritikou))
         {
            $vypis1=str_replace($this->sDiakritikou,$this->bezDiakritiky,$this->bileZnaky());
            $vypis=str_replace($this->hodnoty(),$this->klice(),$vypis1);
            return $vypis;
           // echo "Překlad na morseovu abecedu:<br>";
            //echo "<textarea rows='10' cols='40'>$vypis</textarea>";
         }*/
       /*  else 
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
         }  */
         
          
    public function vypis()
    {
        return $this->nahrazeni();   
    }   
  }
  
  
 //if ($_GET)
   // {
   // if (isset($_GET['zadanoMor']))
   // { 
 
   // mb_internal_encoding("UTF-8");
  //  $zadanoMor = $_GET['zadanoMor'];
  //  $pismena=array/*('á', 'ä', 'č', 'ď', 'é', 'ě', 'ë', 'í', 'ň','ó', 'ö', 'ř', 'š', 'ť','ú', 'ů', 'ü', 'ý', 'ž',*/('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'ch','i', 'j', 'k', 'l', 'm','n', 'o', 'p', 'q', 'r','s', 't', 'u', 'v', 'w','x', 'y', 'z','0','1','2', '3', '4', '5', '6','7', '8', '9', '?', '|', '!', ';', '/','"',':', '_', '+', '*', '@', ',', '(', ')');
  //  $morseovka1=array/*('.- ', '.- ', '-.-. ', '-.. ', '. ', '. ', '. ', '.. ', '-. ','--- ', '--- ', '.-. ', '... ', '- ','..- ', '..- ', '..- ', '-.-- ', '--.. ',*/('.- ', '-... ', '-.-. ', '-.. ', '. ', '..-. ', '--. ', '.... ', '---- ', '.. ', '.--- ', '-.- ', '.-.. ', '-- ','-. ', '--- ', '.--. ', '--.- ', '.-. ','... ', '- ', '..- ', '...- ', '.-- ','-..- ', '-.-- ', '--.. ','----- ','.---- ','..--- ', '...-- ', '....- ', '..... ', '-.... ','--... ', '---.. ', '----. ','..--.. ','--..-- ','--...- ', '-.-.-. ', '-..-. ', '.-..- ','---... ', '..--.- ', '.-.-. ', '-.-.- ', '.--.-. ','--..-- ', '--... ', '-.--.- ');
    
   
    // funguje na pul------------------------------
  //  $morseovka = array('.-' => 'a', '-...' => 'b', '-.-.' => 'c', '-..' => 'd', '.' => 'e', '..-.' => 'f', '--.' => 'g', '....' => 'h', '----' => 'ch', '..' => 'i', '.---' => 'j', '-.-' => 'k', '.-..' => 'l', '--' => 'm', '-.' => 'n', '---' => 'o', '.--.' => 'p', '--.-' => 'q', '.-.' => 'r', '...' => 's', '-' => 't', '..-' => 'u', '...-' => 'v', '.--' => 'w', '-..-' => 'x', '-.--' => 'y', '--..' => 'z');
  //  $rozdeleni = explode('/',$zadanoMor);
 // $pole = array_keys($morseovka);
 
      
  
 //  foreach($rozdeleni as $klic =>$hodnota)
 //  {
     // if (in_array($hodnota, $pole))
     // {
   //     $zmena=str_replace($pole, $pismena, $zadanoMor);
   //     echo $zmena;
     // }
 //  }     
   
   //-----------------------------------------------
    //$vypis = str_replace($rozdeleni, $morseovka, $zadanoMor);
      /*foreach ($morseovka as $klic => $hodnota)
   // foreach ($rozdeleni as $klic => $hodnota)
    {
    $kluc=$klic;
       foreach ($rozdeleni as $kl => $hod)
       {
       $hodn=$hod;
        if ($kluc === $hodn)
        {
          $vypis = str_replace($hodn, $kluc, $zadanoMor);
          echo $vypis;
        }
       }
    }  */
   // echo $vypis; 
      
       
    //  } 
    /*foreach (explode(" ", $zadanoMor) as $slovo) 
    {
    $code = "";
    for ($i=0; $i < mb_strlen($slovo); $i++) 
    {
        $code .= ($slovo[$i] == mb_strtoupper($slovo[$i]) ? "-" : ".");
    }  
    echo (isset($morseovka[$code]) ? $morseovka[$code] : "?");
}*/

 
 

   
?>
    <textarea rows="10" cols="40"/><?php $kk = new morseovka(); echo $kk->vypis();?></textarea><br> 
<p><input type="submit" /></p>


  </form>
 </body>
</html>
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
<form  method="GET" action="vypis.php">
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

  //class morseovka
 //{
 //function upravatextu($zadano)
 //{ 
   // header("Content-Type: text/html; charset=windows-1250");
 // mb_language("uni");
  mb_internal_encoding("UTF-8");
  //header('Content-Type: text/html; charset=UTF-8');
   
  if ($_GET)
    {
    if (isset($_GET['zadano']))
    {
 
    //mb_internal_encoding("UTF-8");
    $zadano = $_GET['zadano'];
    $mala=mb_strtolower($zadano);
    $bileZnaky=trim($mala);
    $delka=mb_strlen($bileZnaky);
    $sDiakritikou=array('á', 'ä', 'č', 'ď', 'é', 'ě', 'ë', 'í', 'ň','ó', 'ö', 'ř', 'š', 'ť','ú', 'ů', 'ü', 'ý', 'ž');
    $bezDiakritiky=array('a', 'a', 'c', 'd', 'e', 'e', 'e', 'i', 'n', 'o', 'o', 'r', 's', 't','u', 'u', 'u', 'y', 'z');
    $pismena=array/*('á', 'ä', 'č', 'ď', 'é', 'ě', 'ë', 'í', 'ň','ó', 'ö', 'ř', 'š', 'ť','ú', 'ů', 'ü', 'ý', 'ž',*/('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'ch','i', 'j', 'k', 'l', 'm','n', 'o', 'p', 'q', 'r','s', 't', 'u', 'v', 'w','x', 'y', 'z','0','1','2', '3', '4', '5', '6','7', '8', '9', '?', '|', '!', ';', '/','"',':', '_', '+', '*', '@', ',', '(', ')', '%');
    $morseovka=array/*('.- ', '.- ', '-.-. ', '-.. ', '. ', '. ', '. ', '.. ', '-. ','--- ', '--- ', '.-. ', '... ', '- ','..- ', '..- ', '..- ', '-.-- ', '--.. ',*/('.- ', '-... ', '-.-. ', '-.. ', '. ', '..-. ', '--. ', '.... ', '---- ', '.. ', '.--- ', '-.- ', '.-.. ', '-- ','-. ', '--- ', '.--. ', '--.- ', '.-. ','... ', '- ', '..- ', '...- ', '.-- ','-..- ', '-.-- ', '--.. ','----- ','.---- ','..--- ', '...-- ', '....- ', '..... ', '-.... ','--... ', '---.. ', '----. ','..--.. ','--..-- ','--...- ', '-.-.-. ', '-..-. ', '.-..- ','---... ', '..--.- ', '.-.-. ', '-.-.- ', '.--.-. ','--..-- ', '--... ', '-.--.- ','......------');
    
       // Zjistovani pismen c a h
       for($i = 0; $i < $delka; $i++)
       {
        
        $znak = mb_substr($bileZnaky, $i, 1);
        $klic=mb_strpos($znak,"c");
        if($klic === false)
        {
           // echo "nenalezeno"; 
      
        }
        else
        {
       
          $znak1=mb_substr($bileZnaky,++$i,1);
          $klic1=mb_strpos($znak1,"h");
           if($klic1 === false)
           {
           echo "nenalezeno ch";
           }
           else
           {
             // echo "ch";
            // unset($znak[--$i]);
            // unset($znak1[$i]);
           // $i="ch";
             //  $znak=str_replace($i,"%",$bileZnaky);
           //  $znak=str_replace($i,"ch", $znak1);
            echo "nalezeno ch";
  
        }
        
        }
        
        //--------------------------------------------------------------------------------------
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
      //----------------------------------------------------------------------------------------- 
     
         
       
       
        /* $znak1=mb_substr($bileZnaky,$i+1,1);
         $klic1=mb_strpos($znak1,"h");
         if($klic1 === false)
         {
          echo "nic";
         }
         else
         {*/
        
       /* for($j = $i++; $j < $delka; $j++)
        {
        $znak = mb_substr($bileZnaky-$i, $j, 1); 
        $klic1=mb_strpos($znak,"h");
        if ($klic1 === false)
        {
         echo "nena";
        }
        else
        {
           echo "nalezeno h"; 
        }
        } */
         // echo "nalezeno";
            
         }
        /*  for($j=$i; $j<1; $j++)
          {
          if ((mb_strpos($j,"h") == true)
          {
            $i=="ch";
            $i++;
            
          } */
         // }
       
    }
    }
   // }
    
      /*
    for($i = 0; $i < $delka; $i++)
    {
    $znak = mb_substr($bileZnaky, $i, 1);
       
    }
    
        // if (strpos($znak, 'ch')) 
        // {
          
        // }
          //  $nahrazeniDiakritiky=str_replace($sDiakritikou,$bezDiakritiky,$zadano);
          //$nahrazeniDiakritiky = StrTr ($mala, "áäčďéěëíňóöřšťúůüýž", "aacdeeeinoorstuuuyz");
            $nahrazeno=str_replace($sDiakritikou, $bezDiakritiky,$bileZnaky);//$vypis=$pismena==$morPismena;
            $vypis=str_replace($pismena,$morseovka,$nahrazeno);//$vypis=$pismena==$morPismena;
            echo "Překlad na morseovu abecedu:<br>" ;
         echo "<textarea rows='10' cols='40'>$vypis</textarea>";
           
        }
        else 
       {
    
        if (in_array($znak, $pismena))
        {
        
        
        
            $nahrazeno=str_replace($sDiakritikou, $bezDiakritiky,$bileZnaky);
            $vypis=str_replace($pismena,$morseovka,$nahrazeno);//$vypis=$pismena==$morPismena;
             echo "Překlad na morseovu abecedu:<br>";
            echo "<textarea rows='10' cols='40'>$vypis</textarea>";
                      
        }
        else
        {
         echo "<div id='chyba'>Znak (<span>".$znak."</span>), není v morseově abecedě!!!<div>";
         }
  
     //    else
      //   {
        //    if (in_array($znak, $sDiakritikou))
      //  {
          //   $prunik1=array_merge($sDiakritikou,$pismena);
          //   $prunik2=array_merge($bezDiakritiky,$morseovka);
          //   $vypis=str_replace($prunik1,$prunik2,$mala);
          //   $prunik=str_replace($pismena,$morseovka,$vypis);
            // $nahrazeno=str_replace($sDiakritikou, $bezDiakritiky,$mala);
            //$vypis=str_replace($pismena,$morseovka,$mala || $nahrazeno);//$vypis=$pismena==$morPismena;
          //   echo "Překlad na morseovu abecedu:<br>";
          //   echo "<textarea rows='10' cols='40'>$prunik</textarea>";
     //    }
         
      
        }
        }
             */

   
?>

<p><input type="submit" /></p>
<!--Zadejte větu k překladu z morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadanoMor" id="vstup"/></textarea><br> -->
 </form>
 </body>
</html>
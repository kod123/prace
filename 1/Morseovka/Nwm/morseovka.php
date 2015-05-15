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
<form  method="GET" action="morseovka.php">
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

  class morseovka
 {
 //function upravatextu($zadano)
 //{ 
   // header("Content-Type: text/html; charset=windows-1250");
 // mb_language("uni");
  mb_internal_encoding("UTF-8");
  //header('Content-Type: text/html; charset=UTF-8');
   
    //if ($_GET)
    //   {
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
}
       

   
?>

<p><input type="submit" /></p>
<!--Zadejte větu k překladu z morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadanoMor" id="vstup"/></textarea><br> -->
 </form>
 </body>
</html>
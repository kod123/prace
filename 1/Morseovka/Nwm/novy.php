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
<form  method="GET" action="novy.php">
<!--<select name="vyber">  
<option name="moznostVyberu"> Vyberte možnost</option>
<option name="doMorseovy"> Do morseovy abecedy</option>
<option name="zMorseovy"> Z morseovy abecedy</option>
</select>-->
Zadejte větu k překladu do morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadano" id="vstup"/></textarea><br>

<?php
//if ($_POST)
      // {
  //  if (isset($_POST['zadano']))
  //  {
 $zadano = $_GET['zadano'];
function morse($zadano) {
    $morseovka=array(
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
    return str_replace(
        array_keys($morseovka),
        array_values($morseovka),
        mb_strtolower(iconv('UTF-8', 'ASCII//TRANSLIT', $zadano)));
}

 function __toString()
{
  return $this->morse();
}
//}

//}

//echo morse('Chrochtající příšerně žluťoučký kůň');
?>

<p><input type="submit" /></p>
<!--Zadejte větu k překladu z morseovy abecedy:<br>
  <textarea rows="10" cols="40" name="zadanoMor" id="vstup"/></textarea><br> -->
 </form>
 </body>
</html>
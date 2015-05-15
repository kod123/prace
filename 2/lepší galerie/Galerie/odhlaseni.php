<?php
class odhlaseni
{
  public function ZpracovaniOdhlaseni()
  {
    session_start();   
    $_SESSION = array();   
    session_destroy();  // Odstraní session

    $celkem = count($_SESSION);

    // Pokud obsahuje session ohlásí chybu jinak přesměruje na prihlaseni.php
    if ($celkem > 0)
     {
       echo "FATAL ERROR: Cannot terminate session!";
     } 
    else 
     {
       header("Location: prihlaseni.php");
     }
  } 
}
  $volani = new odhlaseni();
  $volani->ZpracovaniOdhlaseni();    
?>
<?php
    class mojeMysql extends mysqli
{
   public function __construct($adresa, $login, $heslo, $db)
   {
      parent::__construct($adresa, $login, $heslo, $db);                      
      $this->set_charset("utf8");
   }
}

class pripojeni
{
public $mojeMysql;

 private $server = "127.0.0.1";
    private $jmenoServer = "root";
    private $hesloServer = "";
    private $databazeServer = "velikonoce";
public function PripojeniServer()
    {
       $this->mojeMysql = new mojeMysql($this->server, $this->jmenoServer, $this->hesloServer, $this->databazeServer);
    
       if ($this->mojeMysql->connect_error) 
       { 
         'Při připojení došlo k chybě: ' . $this->mojeMysql->connect_error . '. Číslo 
           chyby: ' .$this->mojeMysql->connect_errno; 
       }
       
       return $this->mojeMysql;
      /* else
       {  
         $this->DotazMysql($this->mojeMysql);         
       }  */       
    }
}
?>
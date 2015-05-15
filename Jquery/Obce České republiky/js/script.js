$(document).ready(function () {

// Obnovení dat z databáze
$.ajax({  
  url: "./ulozeni.php"
});

/*--------------------VYPSÁNÍ OKRESŮ--------------------*/                  
		 $.getJSON("soubory-json/okresy.json", function(data) {		 
		  $.each(data, function(klic, hodnota) {
		    $("#okres").append('<option value="' + hodnota.LAU1 + '">' + hodnota.Nazev + '</option>' );
		  });		  
		});
/*----------------------------------------------------------------------------------------------------*/  
    
/*--------------------VÝBĚR OBCÍ NA ZÁKLADĚ VÝBĚRU OKRESU--------------------*/     
   		        
    $("#okres").change(function(){  
      var okres = $("#okres").val(); // Právě vybraný okres v selectu okresů
      $('#obec').empty();            // Vymazání obcí v selectu obce
      
        // Pokud je vybrán okres, vypíší se obce daného okresu
        if (okres != "") 
        {    
          $('#obec').append('<option value=""> --Zvolte obec-- </option>');
            
           $.getJSON("soubory-json/obce.json", function(data) {
 
            var vyskyt = 0; 		 
    		     $.each(data, function(klic, hodnota) {
               if(hodnota.LAU1 == okres)
               {
                  vyskyt +=1;
      		       $("#obec").append('<option value="' + hodnota.LAU2 + '">' + hodnota.Nazev + '</option>' );
               }
    		      });
              
              // Pokud není naleza jáká obce daného okresu
              if(vyskyt == 0)
              {
                  $('#obec').empty(); 
                  $('table').empty();
                  $('#obec').append('<option value=""> --Žádné obce daného okresu-- </option>');
              }	 
  		   });         
        }
        else  
        {           
            $('#obec').append('<option value=""> --Nejprve zvolte okres-- </option>');
            $('table').empty();
        }         
     });
/*----------------------------------------------------------------------------------------------------*/        
        
/*--------------------ZOBRAZENÍ POČTU OBYVATEL DANÉHO ROKU ZVOLEHÉHO OKRESU A OBCE--------------------*/    
             
    $("#obec").change(function(){
      var obec = $("#obec").val();  // Právě vybraná obec v selectu obcí
      $('table').empty();           // Vymazání data
      
       // Pokud je vybraná obce, vypíší se roky a počet obyvatel
      if (obec != "")
      {       
        $.getJSON("soubory-json/obyvatelstvo.json", function(data) {
       
          
             var vyskyt = 0;
             $("table").append("<thead><tr><th>Rok</th><th>Počet obyvatel</th></tr><thead><tbody>");
             $.each(data, function(klic, hodnota) {
  
              if(hodnota.LAU2 == obec)
              {   
                  vyskyt +=1;
      		        $("table").append('<tr><td>' + hodnota.Rok + '</td> <td>' + hodnota.Celkem + '</td></tr>');
              }
  		      });
  		      $("table").append("</tbody>");
       
     
          // Pokud nejsou naleza data určité obce daného okresu
          if(vyskyt == 0)
          {         
            $('table').html("<p>Zvolená data nejsou k dispozici.</p>");   
          }   		 		  
		  });
      }
    });
/*----------------------------------------------------------------------------------------------------*/  
});






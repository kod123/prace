$(document).ready(function () {
$( "input" ).blur(function() {

		var hodnota = $( this ).val();
		var heslo1 = $("#pass1" ).val();
   	    var heslo2 = $( "#pass2" ).val();
		if(hodnota.length == 0)
		{
		  $( this ).addClass( "error" );
		  $(this).nextUntil("label #info").text("toto pole nesmí být prázdné!").css( "color", "red" );
   	    }
   	    else
   	    {
   	      $( this ).removeClass( "error" );
   	       $(this).nextUntil("label #info").text("V pořádku!").css( "color", "green" );
   	    }
   	    
   	    
   	    if(heslo1.length != 0 && heslo2.lenght != 0)
   	    {
	   	    if(heslo1 != heslo2)
	   	    {
	   	       $("#pass1, #pass2").nextUntil("div").text("Hesla se neschodují").css( "color", "red" );
	
	   	    }
	   	    else
	   	    {
	   	    $("#pass1, #pass2").nextUntil("div").text("Hesla se schodují").css( "color", "green" );

	   	    }
   	    }
});
});


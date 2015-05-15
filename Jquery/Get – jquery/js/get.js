$(document).ready(function () {
$( "input" ).click(function() {
    var cesta = $(this).val();

	if(cesta)
	{
		$.get( cesta, function( data ) {
		  $( "#vypis" ).html( data );
		  alert( "Soubor byl načten!" );
		});
	}
	else
	{
	  $( "#vypis" ).empty();
	  alert( "Soubor nebyl načten!" );
	}
	
	});
});


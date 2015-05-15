$(document).ready(function () {
		 $.getJSON("soubory-getJson/data.json", function( data ) {
		 
		  $.each( data, function( key, val ) {
		    $("#vypis").append( "<option value='" + key.id + "'>" + val.jmeno + "</option>" );
		  });
});


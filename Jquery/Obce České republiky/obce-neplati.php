<!DOCTYPE html>
<html lang="cs">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
  <title>Obce</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="js/script.js" type="text/javascript"></script>
  <link rel="stylesheet" href="css/vzhled.css" />
</head>

  <body>
     <h1>Obce České republiky</h1>
    <form class="form-inline" role="form">
   			<div class="form-group">
   		    	<label for="okres">Okres</label>
   		    	<select name="okres" id="okres" class="form-control">
   		    		<option value=""> --Zvolte okres--</option>
   		    	</select>
   			</div>
   			<div class="form-group">
   		    	<label for="obec">Obec</label>
   		    	<select name="obec" id="obec" class="form-control">
   		    		<option value=""> --Nejprve zvolte okres-- </option>
   		    	</select>
   			</div>
   	 </form>
  
    <div id="data">
    </div>
  
  </body>
</html>

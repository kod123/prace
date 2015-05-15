<?php
 if (isset($_POST["name"])) $name = $_POST["name"]; else $name = false;
 if (isset($_POST["lastname"])) $lastname = $_POST["lastname"]; else $lastname = false;
 if (isset($_POST["pass1"])) $pass1 = $_POST["pass1"]; else $pass1 = false;
 if (isset($_POST["pass2"])) $pass2 = $_POST["pass2"]; else $pass2 = false;
 $error = false;
?>
<?php
	if(isset($_POST['send'])) {
	if($name == '' || $lastname == '' || $pass1 == '' || $pass1 != $pass2) {
	$error = 'Formuář obsahuje chyby!';
	} else {
	$error = 'Formulář se odeslal.';
	// zpracování zíkaných dat
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset=UTF-8 />
		<title>Knihovna jQuery validace formuláře</title>
		<link rel="stylesheet" href="css/styl.css" type="text/css" />
    </head>
	<body>
		<div id="container">
			<div class="error"><?php echo $error; ?></div>
			<form method="post" id="customForm" action="">
				<div>
					<label for="name">Jméno</label>
					<input id="name" name="name" value="<?php echo $name; ?>" class="required" type="text" />
					<label id="info" class="error">Zadajte prosím své jméno</label>
				</div>
				<div>
					<label for="lastName">Příjmení</label>
					<input id="lastName" name="lastname" value="<?php echo $lastname ?>" class="required" type="text" />
					<label id="info" class="error">Zadajte prosím své příjmení</label>
				</div>
				<div>
					<label for="pass1">Heslo</label>
					<input id="pass1" name="pass1" class="required" type="password" />
					<label id="info" class="error">Zadajte prosím své heslo</label>
				</div>
				<div>
					<label for="pass2">ověření hesla</label>
					<input id="pass2" name="pass2" class="required" type="password" />
					<label id="info" class="error">Zadajte prosí heslo ještě jednou</label>
				</div>
				<div>
					<input id="send" name="send" type="submit" value="Registrovat" />
				</div>
			</form>
		</div>
	</body>		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="js/kontrola.js" type="text/javascript"></script>
</html>
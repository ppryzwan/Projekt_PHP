<?php
require_once('funkcje.php');
if(isset($_POST['SubmitButton']))
{
	dodajKarnet($_POST['nazwa'],$_POST['cena']);
	
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link rel="Stylesheet" type="text/css" href="style.css" />
</head>
<body>

<form action ="" method = "Post">
Nazwa Karnetu
<br>
<input type = "Text" name = "nazwa" required >
<br>
Cena Karnetu
<br>
<input type="number" step="0.01" min="0" name = "cena" required >
<br>
<button type="Submit" name="SubmitButton">Dodaj Karnet</button>

</form>
</html>

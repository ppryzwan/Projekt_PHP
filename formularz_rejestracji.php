<?php
	require_once('funkcje.php');
	if(isset($_POST['SubmitButton']))
	{
	dodajKlienta($_POST['Login'],$_POST['Haslo'],$_POST['Imie'],$_POST['Nazwisko'],$_POST['Miejscowosc'],$_POST['Ulica'],$_POST['NrLokalu'],$_POST['NrMieszkania']);
	echo "Pomyślnie Zarejestrowano";
	echo "<a href = ./formularz_logowania.html> Przejdz do strony logowania </a>";
	}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<link rel="Stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id = "Kontener" >
<div class = "logowanie">

<h2> Formularz Rejestracji </h2>
<form action ="" method = "Post">
Login		
<br>
<input type = "Text" name = "Login" required >
<br>
Hasło
<br>
<input type = "password" name = "Haslo" required >
<br>
Imie
<br>
<input type = "Text" name = "Imie" required >
<br>
Nazwisko
<br>
<input type = "Text" name = "Nazwisko" required >
<br>
Miejscowosc
<br>
<input type = "Text" name = "Miejscowosc" required >
<br>
Ulica
<br>
<input type = "Text" name = "Ulica" required >
<br>
NrLokalu<br>
<input type = "number" min = 0 name = "NrLokalu" required >
<br>
NrMieszkania
<br>
<input type = "number" min = 0 name = "NrMieszkania" required >
<br>
<button type = "submit" name = "SubmitButton" >Zarejestuj sie </button>
<br>
<a href = "./formularz_logowania.html">Powrot do strony logowania</a> 
</div>
</div>
</html>


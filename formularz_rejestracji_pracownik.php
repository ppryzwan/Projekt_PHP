<?php

require_once('klasy.php');
require_once('funkcje.php');
session_start();
if (!isset($_SESSION['obiekt'])) 
{
		header("Location: formularz_logowania.html");
		exit;
}
$obiekt = $_SESSION['obiekt'];
if(isset($_POST['SubmitButton']))
{
	dodajpracownika($_POST['Login'],$_POST['Haslo'],$_POST['Imie'],$_POST['Nazwisko'],$_POST['Pesel'],$_POST['Stanowisko'],$_POST['Miejscowosc'],$_POST['Ulica'],$_POST['NrLokalu'],$_POST['NrMieszkania']);
	header("Location: index.php");
	exit;
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1"> 
<link rel="Stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id = "Kontener">

<div class = "menu">
		<ul>
			<li><a href = "./index.php">Strona główna</a></li>
			<?php
			if($obiekt->Poziom() == 1)
			{
			
				echo "<li><a href = './index.php?link=konto'>Zarzadzaj kontem</a></li>";
				echo "<li><a href = './index.php?link=przypisz_karnet'>Kup Karnet</a></li>";
				echo "<li><a href = './index.php?link=zapisz_na_kurs'>Zapisz na kurs</a></li>";
				echo "<li><a href = './index.php?link=kursy'>Zarzadzaj Twoimi Kursami</a></li>";
				
			}
				
				if($obiekt->Poziom() == 3 or $obiekt->Poziom() == 5) 
				{ 
				$miesiac = date('m');
				$dzien = date('d');
				$rok = date('o');
				echo "<li><a href = './wybierz_date_kursu.php?dzien=$dzien&miesiac=$miesiac&rok=$rok'>Stworz Nowy Kurs</a></li>";
				echo "<li><a href = './index.php?link=karnet'>Dodaj Nowy Karnet</a></li>";
			}
			if($obiekt->Poziom() == 5) 
			{
					echo "<li><a href = './formularz_rejestracji_pracownik.php'>Dodaj Pracownika </a></li>";
					echo "<li><a href = './index.php?link=pracownicy'>Zarzadzaj Pracownikami </a></li>";
			}		
		
		
		?>
			<li><a href = "./index.php?link=zmienhaslo">Zmien haslo</a></li>
			<li><a href = "./logout.php">Wyloguj </a></li>
		</ul>
	</div>
	<div class = "srodek">
<form action ="" method = "Post" >
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
Pesel:
<br>
<input type="text" name="Pesel" pattern="[0-9]{11}" title="Podaj 11 cyfrowy pesel" required>

<br>
Stanowisko
<br>

<select name="Stanowisko" required >
  <option value="Szef">Szef</option>
  <option value="Trener">Trener</option>
  <option value="Normalny">Biurowy</option>

</select>

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
<input type = "number" min = 0 name = "NrMieszkania"  required >
<br>

<button type = "submit" name = "SubmitButton"> Dodaj Pracownika </button>
</form>
		</div>
	</div>
</html>
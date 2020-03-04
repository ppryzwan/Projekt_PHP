<?php

require('klasy.php');
session_start();
if (!isset($_SESSION['obiekt'])) 
{
		header("Location: formularz_logowania.html");
		exit;
}
$obiekt = $_SESSION['obiekt'];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8"> 
<link rel="Stylesheet" type="text/css" href="style.css" />
</head>
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
		<?php 
		if(!isset($_GET['link']))
		{
			echo "<H1>";
			echo "Witaj!";
			echo "<BR>";
			
			$obiekt -> WypiszLogin();
			echo "</H1>";
		}
		else
		{	
			if($_GET['link'] == 'karnet' and $obiekt->Poziom() != 1)
			include("./dodaj_karnet.php"); 
		
			if($_GET['link'] == 'kursy' and $obiekt->Poziom() == 1)
			$obiekt->ZarzadzajKursami();
			
			if($_GET['link'] == 'konto' and $obiekt->Poziom() == 1)
			$obiekt->Aktualizacja_Danych();
		
		
			if($_GET['link'] == 'przypisz_karnet' and $obiekt->Poziom() == 1)
			$obiekt ->PrzypiszKarnet();
		
			if($_GET['link'] == 'zapisz_na_kurs' and $obiekt->Poziom() == 1)
			$obiekt ->ZapiszNaKurs();
		
			if($_GET['link'] == 'pracownicy' and $obiekt->Poziom() == 5)
			$obiekt->ZarzadzajPracownikami();
	
			if($_GET['link'] == 'zmienhaslo')
			$obiekt->Zmien_Haslo();
			
		}
	?>
</div>



</div>


</html>



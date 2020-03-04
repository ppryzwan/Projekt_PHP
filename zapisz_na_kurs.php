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
<meta charset="ISO-8859-1"> 
<link rel="Stylesheet" type="text/css" href="style.css" />
</head>
<div id = "Kontener">

	<div class = "menu">
		<ul>
			<li><a href = "./index.php">Strona główna</a></li>
			<?php
			if($obiekt->Poziom() == 1 or $obiekt->Poziom() == 5)
			{
			
				echo "<li><a href = './zarzadzanie_kontem.php'>Zarzadzaj kontem</a></li>";
				echo "<li><a href = './przypisz_karnet.php'>Kup Karnet</a></li>";
				echo "<li><a href = './zapisz_na_kurs.php'>Zapisz na kurs</a></li>";
			}
				
				if($obiekt->Poziom() == 3 or $obiekt->Poziom() == 5) 
				{ 
				$miesiac = date('m');
				$dzien = date('d');
				$rok = date('o');
				echo "<li><a href = './wybierz_date_kursu.php?dzien=$dzien&miesiac=$miesiac&rok=$rok'>Stworz Nowy Kurs</a></li>";
				echo "<li><a href = './index.php?link=karnet'>Dodaj Nowy Karnet</a></li>";
			}
			?>
		</ul>
	</div>
<div class = "srodek">
		<?php 
		$obiekt ->ZapiszNaKurs()
	?>
</div>

	
</div>


</html>
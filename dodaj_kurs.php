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
$sprawdzanie = Date('Y-m-d');
if($sprawdzanie > $_GET['dzien'])
{
	header('Location: index.php');
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
	<?php if(isset($_POST['SubmitButton']))
		{
		echo "Pomyslnie dodano kurs";
		$data = $_GET['dzien'];
		dodajKurs($_POST['nazwa'],$_POST['id'],$data,$_POST['cena']);
		}
?>
<div class = "srodek">
				<form action ="" method = "Post">
				Nazwa Kursu
				<br>
				<input type = "Text" name = "nazwa" required>
				<br>
				Cena Kursu
				<br>
				<input type="number" step="0.01" min="0" name = "cena"  required >
				<br>
				Wybierz Pracownika 
				<br>
				<?php 
				$polaczenie = new mysqli('localhost', 'root','','projekt');
					if (mysqli_connect_errno() !=0)
					{
						echo "Blad";
						exit;
					}
				$sql = "Select ID_pracownika,Imie,Nazwisko from pracownicy where Stanowisko = 'Trener' ";
				$wynik = $polaczenie -> query($sql);
				if($wynik == false)
				{
					echo 'nie udalo sie wykonac zapytania';
					$polaczenie -> close();
					exit;
				}
				echo "<select name = 'id'>";
				while (($rekord = $wynik -> fetch_assoc()) != null)
				{
					echo "<option value ='" . $rekord['ID_pracownika'] . "'>" . $rekord['Imie'] . ' '.  $rekord['Nazwisko'] . '</option>';
				}
				echo "</select>";	
?>
<br>
<input type="Submit" value = "Dodaj Kurs" name="SubmitButton">
</form>
</div>

	
</div>



</html>

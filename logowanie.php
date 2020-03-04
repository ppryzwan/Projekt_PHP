<?php 
require('klasy.php');
session_start();


$polaczenie = new mysqli('localhost', 'root','','projekt');

if (mysqli_connect_errno() !=0)
	{
	echo 'Jest blad polaczenia '.mysqli_connect_error();
	exit;
	}
	
	$login = $_POST['login'];
	$password = md5($_POST['haslo']);
	
	$sql = "Select * from uzytkownicy where Login = '$login' and Password = '$password' ";
	$wynik = $polaczenie -> query($sql);
   //czy liczba wierszy jest rowna 0
	$ilerowsow = $wynik->num_rows;
	
	if($ilerowsow ==  0)
	{
		echo "Nie ma takiego uzytkownika";
		echo "<br><BR>";
		echo "<a href = './formularz_logowania.html'> Powrot to formularza logowania </a>";
	}
	else
	{		
		$rekord = $wynik -> fetch_assoc();
		//jesli jest adminem rob to
		if($rekord['Poziom_uprawnienia'] == 5)
		{
			$obiekt = new Admin($rekord['ID'],$rekord['Login'],$rekord['Password'],$rekord['ID_pracownika']);
			$_SESSION['obiekt'] = $obiekt;
		}
		else
		{
			if(is_null($rekord['ID_pracownika']))
			{
				$obiekt = new Klient($rekord['ID'],$rekord['Login'],$rekord['Password'],$rekord['ID_klienta']);
				$_SESSION['obiekt'] = $obiekt;
			}
			else
			{
				$obiekt = new Pracownik($rekord['ID'],$rekord['Login'],$rekord['Password'],$rekord['ID_pracownika']);
				$_SESSION['obiekt'] = $obiekt;
			}
		}
			header("Location: index.php");
			exit;
	}
	
	if (!isset($_SESSION['obiekt'])) 
{
header("Location: formularz_logowania.html");
   exit;
}


?>


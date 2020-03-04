<?php
error_reporting(E_ERROR);
require('fpdf.php');
require('klasy.php');
session_start();

if (!isset($_SESSION['obiekt']) ) 
{
	
		header("Location: formularz_logowania.html");
		exit;
}
$obiekt = $_SESSION['obiekt'];

$ID = $obiekt -> getid();

$pdf = new FPDF();

$polaczenie = new mysqli('localhost','root','','projekt');

if (mysqli_connect_errno() !=0)
	{
	echo 'Blad poaczenia'.mysqli_connect_error();
	exit;
	}
	
$sql = "select kursy_klient.znizka as znizka ,kursy_klient.Zaplacone as Zaplacone, kursy_klient.ID as ID,kursy.ID_kursu as ID_kursu, kursy.Nazwa_kursu as Nazwa_kursu, CONCAT(pracownicy.Imie,' ',pracownicy.Nazwisko) as DaneTrenera, kursy.Data_kursu as Data, kursy.Cena_kursu as Cena from kursy join pracownicy on pracownicy.ID_pracownika = kursy.ID_pracownika join kursy_klient on kursy_klient.ID_kursu = kursy.ID_kursu where kursy_klient.ID_klienta = '$ID' ";


$wynik = $polaczenie -> query($sql);

$pdf -> AddPage();
$pdf -> SetFont('Arial','B',20);
$pdf -> Cell(75,15,'',0,0);

$pdf -> Cell(50,15,'Spis Kursow',0,1,'C');
$pdf -> SetFont('Arial','B',11);
$pdf -> Cell(40,8,'Nazwa Kursu',1,0,'L');
$pdf -> Cell(40,8,"Pracownik",1,0,'L');
$pdf -> Cell(30,8,'Data Kursu',1,0,'L');
$pdf -> Cell(30,8,'Cena Kursu',1,0,'L');
$pdf -> Cell(25,8,'Zaplacone',1,0,'L');
$pdf -> Cell(15,8,'Znizka',1,1,'L');


$pdf -> SetFillColor(255,255,255);


while (($rekord = $wynik -> fetch_assoc()) != null)
{


	$dane_pracownika = $rekord['DaneTrenera'];
	$cena = $rekord['Cena'] . ' ' . 'zl';
	
	$pdf -> Cell(40,8,$rekord['Nazwa_kursu'],1,0,'L');
	$pdf -> Cell(40,8,$dane_pracownika,1,0,'L');
	$pdf -> Cell(30,8,$rekord['Data'],1,0,'L');
	$pdf -> Cell(30,8,$rekord['Cena'],1,0,'L');
	$pdf -> Cell(25,8,$rekord['Zaplacone'],1,0,'L');
	$pdf -> Cell(15,8,$rekord['znizka'],1,1,'L');

	
	$pdf -> SetFillColor(255,255,255);
}




$pdf -> Output();

?>
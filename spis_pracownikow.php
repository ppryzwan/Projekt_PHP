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

if($obiekt->poziom() != 5)
{
	header("Location: formularz_logowania.html");
		exit;
}
$pdf = new FPDF();

$polaczenie = new mysqli('localhost','root','','projekt');

if (mysqli_connect_errno() !=0)
	{
	echo 'Blad poaczenia'.mysqli_connect_error();
	exit;
	}
$sql = 'select * from pracownicy where Data_skonczenia_zatrudnienia is null ';


$wynik = $polaczenie -> query($sql);

$pdf -> AddPage();
$pdf -> SetFont('Arial','B',20);
$pdf -> Cell(75,15,'',0,0);

$pdf -> Cell(50,15,'Spis Pracownikow Pracujacych',0,1,'C');
$pdf -> SetFont('Arial','B',14);

$pdf -> SetFillColor(255,255,255);
$halp = 1;

while (($rekord = $wynik -> fetch_assoc()) != null)
{


	$dane_pracownika = $rekord['Imie'] . ' '. $rekord['Nazwisko']; 
	$miejsce_zamieszkania = $rekord['Miejscowosc'] . ' ' .$rekord['Ulica'] . ' ' . $rekord['NrLokalu'] . '/' . $rekord['NrMieszkania'];
	$pensja = $rekord['Pensja']. ' '. 'zl';
	
	$pdf -> Cell(80,8,'Imie i Nazwisko','B',0,'L');
	$pdf -> cell(90,8,$dane_pracownika,'B',1,'L');
	$pdf -> Cell(80,8,'Miejsce Zamieszkania','B',0,'L');
	$pdf -> cell(90,8,$miejsce_zamieszkania,'B',1,'L');
	$pdf -> Cell(80,8,'Pesel','B',0,'L');
	$pdf -> cell(90,8,$rekord['Pesel'],'B',1,'L');
	$pdf -> Cell(80,8,'Stanowisko','B',0,'L');
	$pdf -> cell(90,8,$rekord['Stanowisko'],'B',1,'L');
	$pdf -> Cell(80,8,'Pensja','B',0,'L');
	$pdf -> cell(90,8,$pensja,'B',1,'L');
	$pdf -> Cell(80,8,'Data Zatrudnienia','B',0,'L');
	$pdf -> cell(90,8,$rekord['Data_zatrudnienia'],'B',1,'L');
	$pdf -> cell(60,8,'',0,1,'');
	
	$pdf -> SetFillColor(255,255,255);
}

$sql = 'select * from pracownicy where Data_skonczenia_zatrudnienia is not null ';


$wynik = $polaczenie -> query($sql);


$pdf -> SetFont('Arial','B',20);
$pdf -> Cell(75,15,'',0,0);

$pdf -> Cell(50,15,'Spis Pracownikow Zwolnionych',0,1,'C');
$pdf -> SetFont('Arial','B',14);

$pdf -> SetFillColor(255,255,255);
$halp = 1;

while (($rekord = $wynik -> fetch_assoc()) != null)
{


	$dane_pracownika = $rekord['Imie'] . ' '. $rekord['Nazwisko']; 
	$miejsce_zamieszkania = $rekord['Miejscowosc'] . ' ' .$rekord['Ulica'] . ' ' . $rekord['NrLokalu'] . '/' . $rekord['NrMieszkania'];
	$pensja = $rekord['Pensja']. ' '. 'zl';
	
	$pdf -> Cell(80,8,'Imie i Nazwisko','B',0,'L');
	$pdf -> cell(90,8,$dane_pracownika,'B',1,'L');
	$pdf -> Cell(80,8,'Miejsce Zamieszkania','B',0,'L');
	$pdf -> cell(90,8,$miejsce_zamieszkania,'B',1,'L');
	$pdf -> Cell(80,8,'Pesel','B',0,'L');
	$pdf -> cell(90,8,$rekord['Pesel'],'B',1,'L');
	$pdf -> Cell(80,8,'Stanowisko','B',0,'L');
	$pdf -> cell(90,8,$rekord['Stanowisko'],'B',1,'L');
	$pdf -> Cell(80,8,'Pensja','B',0,'L');
	$pdf -> cell(90,8,$pensja,'B',1,'L');
	$pdf -> Cell(80,8,'Data Zatrudnienia','B',0,'L');
	$pdf -> cell(90,8,$rekord['Data_zatrudnienia'],'B',1,'L');
	$pdf -> Cell(80,8,'Data Skonczenia Zatrudnienia','B',0,'L');
	$pdf -> cell(90,8,$rekord['Data_skonczenia_zatrudnienia'],'B',1,'L');
	$pdf -> cell(60,8,'',0,1,'');
	
	$pdf -> SetFillColor(255,255,255);
}


$pdf -> Output();

?>
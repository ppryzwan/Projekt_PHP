<?php
//funkcja dodajaca klienta z podanych wartosci
function dodajklienta($Login,$Haslo,$Imie,$Nazwisko,$Miejscowosc,$Ulica,$NrLokalu,$NrMieszkania)
{
  $polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
		$Haslo1 = md5($Haslo);
		$dodanie = $polaczenie->prepare('insert into klient (Imie,Nazwisko,Miejscowosc,Ulica,NrLokalu,NrMieszkania) values (:imie,:nazwisko,:miejscowosc,:ulica,:nrlokalu,:nrmieszkania)');
		$dodanie ->bindParam(':imie',$Imie);
		$dodanie ->bindParam(':nazwisko',$Nazwisko);
		$dodanie ->bindParam(':miejscowosc',$Miejscowosc);
		$dodanie ->bindParam(':ulica',$Ulica);
		$dodanie ->bindParam(':nrlokalu',$NrLokalu);
		$dodanie ->bindParam(':nrmieszkania',$NrMieszkania);
		$dodanie ->execute();
		//dodanie do tabeli uzytkownicy
		$id = $polaczenie -> lastInsertId();
		$poziom = 1;
		$dodanie1 = $polaczenie->prepare('insert into uzytkownicy (Login,Password,Poziom_uprawnienia,ID_klienta) values (:login,:haslo,:poziom,:id)');
		$dodanie1 ->bindParam(':login',$Login);
		$dodanie1 ->bindParam(':haslo',$Haslo1);
		$dodanie1 ->bindParam(':poziom',$poziom);
		$dodanie1 ->bindParam(':id',$id);
		$dodanie1 ->execute();
		
		$polaczenie = null;
}
function pensja($Stanowisko)
{
		if($Stanowisko == "Normalny")
		return 2000;
	elseif($Stanowisko == "Trener")
		return 3500;
	else
return 10000;
}

// funkcja dodajaca pracownika
function dodajpracownika($Login,$Haslo,$Imie,$Nazwisko,$Pesel,$Stanowisko,$Miejscowosc,$Ulica,$NrLokalu,$NrMieszkania)
{	
	//przypisywanie pensji
	$pensja = pensja($Stanowisko);
	
	$data = Date("Y-m-d");

	$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
		$Haslo1 = md5($Haslo);
		$dodanie = $polaczenie->prepare('insert into pracownicy (Imie,Nazwisko,Pesel,Pensja,Stanowisko,Miejscowosc,Ulica,NrLokalu,NrMieszkania,Data_zatrudnienia) values (:imie,:nazwisko,:pesel,:pensja,:stanowisko,:miejscowosc,:ulica,:nrlokalu,:nrmieszkania,:data)');
		$dodanie ->bindParam(':imie',$Imie);
		$dodanie ->bindParam(':nazwisko',$Nazwisko);
		$dodanie ->bindParam(':pesel',$Pesel);
		$dodanie ->bindParam(':pensja',$pensja);
		$dodanie ->bindParam(':stanowisko',$Stanowisko);
		$dodanie ->bindParam(':miejscowosc',$Miejscowosc);
		$dodanie ->bindParam(':ulica',$Ulica);
		$dodanie ->bindParam(':nrlokalu',$NrLokalu);
		$dodanie ->bindParam(':nrmieszkania',$NrMieszkania);
		$dodanie ->bindParam(':data',$data);

		$dodanie ->execute();

		//dodanie do tabeli uzytkownicy
		$id = $polaczenie -> lastInsertId();
		$poziom = 3;
		$dodanie1 = $polaczenie->prepare('insert into uzytkownicy (Login,Password,Poziom_uprawnienia,ID_pracownika) values (:login,:haslo,:poziom,:id)');
		$dodanie1 ->bindParam(':login',$Login);
		$dodanie1 ->bindParam(':haslo',$Haslo1);
		$dodanie1 ->bindParam(':poziom',$poziom);	
		$dodanie1 ->bindParam(':id',$id);
		$dodanie1 ->execute();

		$polaczenie = null;
}

/* Sekcja dotyczaca karnetu */
function dodajKarnet($nazwa,$cena)
{

$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');

$dodanie = $polaczenie->prepare('insert into karnet (Nazwa_karnetu,Cena) values (:nazwa,:cena)');
$dodanie ->bindParam(':nazwa',$nazwa);
$dodanie ->bindParam(':cena',$cena);
$dodanie ->execute();
	echo "Pomyślnie dodano karnet ";

}

/* Sekcja dotyczaca dat */
function sprawdz_data_zajeta($month,$year,$day)
{
	$polaczenie = new mysqli('localhost', 'root','','projekt');
		$data = $year. '-' . $month . '-' . $day ;
	$sql = "Select * from kursy where Data_kursu = '$data' ";


	$wynik = $polaczenie -> query($sql);
	$ilerowsow = $wynik->num_rows;
	if($ilerowsow == 0) 
		return 0;
	else
		return 1;
}


function stworz_kalendarz($month,$year,$day)
{
	if($month == date('m') and $year == date('o'))
		$day = date('d');
	$monthNum  = $month;
$dateObj   = DateTime::createFromFormat('!m', $monthNum);
$monthName = $dateObj->format('F');
	$pomoc = 7;
	$dni_miesiac = Date("t",mktime(0,0,0,$month,1,$year));
	echo "<H2 style = 'font-size:400%; margin-left:30%; '> Wybierz date kursu <H2>";
	echo "<H1 style = 'margin-left:500px; '> $monthName $year</H1>";

	echo "<table style=' border-collapse: collapse; width: 100%; margin:50px; border: 1px solid black;' >";
	for($i = $day + 1;$i <= $dni_miesiac ;$i++)
	{
		if($pomoc == 7)
		{
		echo "<tr>";
		$pomoc = 1;
		}
			if(sprawdz_data_zajeta($month,$year,$i) == 1)
			{
				echo "<td style= ' border: 1px solid black;  text-align: center;  padding: 15px; ' bgcolor = red><font color = black> $i </font></td>";
				$pomoc++;
				
			}
			else
			{
				echo "<td><a style = ' border: 1px solid black;  text-align: center; display:block; padding: 15px; ' href = dodaj_kurs.php?dzien=$year-$month-$i>$i</a></td>";
				$pomoc++;
			}
	
	}
	echo "</table>";
	echo "Czerwone pola oznaczają, że data jest już zajęta";
	
}

function nawigacja_kalendarzem($month,$year)
{
if($month == date('m') and $year == date('o'))
	{
			
			if($month == 12) 
			{	
			$month = 1;
			$year++;
		}
		else
		$month++;
		echo "<a style =  'margin-left: 720px; background-color: #f44336; color: white; padding: 14px 25px;  text-align: center;  text-decoration: none;  display: inline-block;' href = './wybierz_date_kursu.php?dzien=1&miesiac=$month&rok=$year'>Nastepny miesiac</a>";
	}
else
	{
		//Poprzedni miesiac
		if($month == 1) 
		{	
		$month1 = 12;
		$year1 = ($year - 1);
		}
		else
		{
			$year1 = $year;
		$month1 = ($month - 1);
		}
		echo "<a style =  'margin-left:150px; background-color: #f44336; color: white; padding: 14px 25px;  text-align: center;  text-decoration: none;  display: inline-block;'  href = './wybierz_date_kursu.php?dzien=1&miesiac=$month1&rok=$year1'>Poprzedni miesiac</a>";
		
		//Nastepny miesiac
		if($month == 12) 
		{	

		$month2 = 1;
		$year2 = ($year + 1);
		}
		else
		{
			$year2 = $year;
			$month2 = ($month + 1);
		
		}
		echo "<a style =  ' margin-left:400px;background-color: #f44336; color: white; padding: 14px 25px;  text-align: center;  text-decoration: none;  display: inline-block;' href = './wybierz_date_kursu.php?dzien=1&miesiac=$month2&rok=$year2'>Nastepny miesiac</a>";
	}
}

/* Sekcja dotyczaca kursow */

function dodajKurs($nazwa,$prac,$data,$cena)
{
$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');

$dodanie = $polaczenie->prepare('insert into kursy (Nazwa_kursu,ID_pracownika,Data_kursu,Cena_kursu) values (:nazwa,:id,:data,:cena)');
$dodanie ->bindParam(':nazwa',$nazwa);
$dodanie ->bindParam(':id',$prac);
$dodanie ->bindParam(':data',$data);
$dodanie ->bindParam(':cena',$cena);
$dodanie ->execute();

}

		?>

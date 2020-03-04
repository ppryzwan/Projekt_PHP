<?php 
require_once('funkcje.php');
class Klient
{
	private $ID_Usera;
	private $login;
	private $haslo;
	private $poziom = 1;
	private $ID_Klienta;
	
	public function __construct($id,$login,$haslo,$nr)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
		$this->ID_Klienta = $nr;
	}
	public function getid()
	{return $this->ID_Klienta;
	}
	public function WypiszLogin()
	{
	echo "Jesteś zalogowany/a na koncie : " . $this->login;
	}
	
	
	public function Poziom()
	{
		return $this->poziom;
	}
	
	private function ZmienDane($ID,$Imie,$Nazwisko,$Miejscowosc,$Ulica,$NrLokalu,$NrMieszkania)
	{
	 $polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
		$dodanie = $polaczenie->prepare('update klient set Imie = :imie,Nazwisko = :nazwisko,Miejscowosc = :miejscowosc,Ulica = :ulica,NrLokalu = :nrlokalu,NrMieszkania = :nrmieszkania where ID_klienta = :id');
		$dodanie ->bindParam(':id',$ID);
		$dodanie ->bindParam(':imie',$Imie);
		$dodanie ->bindParam(':nazwisko',$Nazwisko);
		$dodanie ->bindParam(':miejscowosc',$Miejscowosc);
		$dodanie ->bindParam(':ulica',$Ulica);
		$dodanie ->bindParam(':nrlokalu',$NrLokalu);
		$dodanie ->bindParam(':nrmieszkania',$NrMieszkania);
		$dodanie ->execute();
	$polaczenie = null;
	}
	private function SprawdzHaslo($haslo)
	{
		
	}
	
		public function Zmien_Haslo()
	{
			$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
			$ID = $this->ID_Usera;
			if(isset($_POST['SubmitButton']))
			{			
			$sql = "select * from uzytkownicy where ID = '$ID'";
				$zapytanie = $polaczenie->query($sql);
				$data = $zapytanie ->fetch(PDO::FETCH_ASSOC);
				$haslo = md5($_POST['Stare_Haslo']);
				if($data['Password'] == $haslo)
				{
					$nowe_haslo = md5($_POST['Nowe_Haslo']);
					$zapytanie = $polaczenie->prepare('update uzytkownicy set Password = :haslo where ID = :id');
					$zapytanie -> bindParam(':haslo',$nowe_haslo);
					$zapytanie -> bindParam(':id',$ID);
					$zapytanie -> execute();
					
				}
				else
				{
				header("Location:  logout.php");
				exit;
					
				}
			}
		$zapytanie = $polaczenie->prepare('select * from klient where ID_klienta = :id');
		$zapytanie -> bindParam(':id',$ID);
		$zapytanie -> execute();
				//formularz do zmiany hasla
				echo "<form action ='' method = 'POST'>";
				echo "Prosze wypełnić pola formularza w celu zmiany hasła <br> <br>";
				echo "Aktualne Haslo <br> <input type = 'password' name = 'Stare_Haslo' required > <br>";	
				echo "Nowe Haslo <br> <input type = 'password' name = 'Nowe_Haslo' required > <br>";	
				echo "<br> <input type = 'submit' value = 'Zmien'  name = 'SubmitButton'>";
				echo '</form>';
		$polaczenie = null;
	}
	
	public function Aktualizacja_Danych()
	{
		//przypisanie numeru klienta
		$ID = $this->ID_Klienta;
		if(isset($_POST['SubmitButton']))
		{
			$this->ZmienDane($ID,$_POST['Imie'],$_POST['Nazwisko'],$_POST['Miejscowosc'],$_POST['Ulica'],$_POST['NrLokalu'],$_POST['NrMieszkania']);
		}
		
		$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
		$zapytanie = $polaczenie->prepare('select * from klient where ID_klienta = :id');
		$zapytanie -> bindParam(':id',$ID);
		$zapytanie -> execute();
				//formularz do zmiany danych
			$data = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "<form action ='' method = 'POST'>";
				echo "Imie <br> <input type = 'Text'  required name = 'Imie' value = '" .$data['Imie'] . "'>" ;
				echo "<br> Nazwisko <br> <input type = 'Text'  required name = 'Nazwisko' value = '" . $data['Nazwisko'] . "'>";
				echo "<br> Miejscowosc <br> <input type = 'Text' required  name = 'Miejscowosc' value ='" . $data['Miejscowosc'] . "'>";
				echo "<br> Ulica <br> <input type = 'Text'  required name = 'Ulica' value = '" .$data['Ulica'] . "'>";
				echo "<br> NrLokalu<br> <input type = 'number' required  min = 0 name = 'NrLokalu' value = '" . $data['NrLokalu'] . "'>";
				echo "<br> NrMieszkania <br> <input type ='number' required min = 0 name = 'NrMieszkania' value = '" . $data['NrMieszkania'] ."'>";
				echo "<br> <button type = 'submit' name = 'SubmitButton'>Zmien </button>";
				echo '</form>';
		$polaczenie = null;
	}	
	private function SprawdzCzyMaTenKarnet($ID_karnetu)
	{
		$data = date('m');
		$id = $this->ID_Klienta;
		$polaczen = new mysqli('localhost', 'root','','projekt');
		$sql = "select * from karnet_klient  where ID_klienta = '$id' and Month(Data_zakupienia) = '$data' and ID_Karnetu = '$ID_karnetu'";
		$wynik = $polaczen -> query($sql);
		$ilerowsow = $wynik->num_rows;
		//1 - ma karnet na ten miesiac , 0  - nie ma
		if($ilerowsow == 0)
			return False;
		else
			return True;
		
		$polaczen = null;
	}
		private function SprawdzCzyMaKarnet()
	{
		$data = date('m');
		$id = $this->ID_Klienta;
		$polaczen = new mysqli('localhost', 'root','','projekt');
		$sql = "select * from karnet_klient  where ID_klienta = '$id' and Month(Data_zakupienia) = '$data'";
		$wynik = $polaczen -> query($sql);
		$ilerowsow = $wynik->num_rows;
		//1 - ma karnet na ten miesiac , 0  - nie ma
		if($ilerowsow == 0)
			return False;
		else
			return True;
		
		$polaczen = null;
	}
	public function PrzypiszKarnet()
	{
	$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');		

			$ID = $this->ID_Klienta;
		if(isset($_POST['ID_karnetu']))
		{
			$data = Date("Y-m-d");
		
		$przypisz = $polaczenie->prepare('insert into karnet_klient(ID_klienta,ID_Karnetu,Data_zakupienia) values(:id_klienta,:id_karnetu,:data)');
			$przypisz->bindParam(':id_klienta',$ID);
			$przypisz->bindParam(':id_karnetu',$_POST['ID_karnetu']);
			$przypisz->bindParam(':data',$data);
			$przypisz -> execute();
		
		}
		
		
		$zapytanie = $polaczenie->prepare('select * from karnet');
		$zapytanie -> execute();
				//kolumny
		
				echo "<table border>";
				echo "<th> Nazwa Karnetu <th> Cena Karnetu";
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					if(!$this->SprawdzCzyMaTenKarnet($data['ID_karnetu']))
					{
						echo "<tr>";
						echo '<td>' . $data['Nazwa_Karnetu'] . '<td>' . $data['Cena'];
						echo "<td>";
						echo "<form action= '' method = 'POST' >";
						echo "<input type = 'text' name = 'ID_karnetu' value = " . $data['ID_karnetu'] . " hidden> ";
						echo "<input type = 'submit' value = 'Kup Karnet'> </form>";
						echo "</td>";
					}
				}					
		$polaczenie = null;
	}


	private function SprawdzCzyJestZapisany($ID_kursu)
	{
		
		$id = $this->ID_Klienta;
		$polaczen = new mysqli('localhost', 'root','','projekt');
		$sql = "select * from kursy_klient  where ID_klienta = $id and ID_kursu = $ID_kursu";
		$wynik = $polaczen -> query($sql);
		$ilerowsow = $wynik->num_rows;
		//1 - ma karnet na ten miesiac , 0  - nie ma
		if($ilerowsow == 0)
			return False;
		else
			return True;
		
		$polaczen = null;
	}
	
	
public function ZapiszNaKurs()
	{
	$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');		

			$ID = $this->ID_Klienta;
		if(isset($_POST['ID_kursu']))
		{
			$znizka = "Nie";
			$data = Date("Y-m-d");
		if($this->SprawdzCzyMaKarnet())
			$znizka = "Tak";
		
		$przypisz = $polaczenie->prepare('insert into kursy_klient(ID_kursu,ID_klienta,Znizka) values(:id_kursu,:id_klienta,:znizka)');
			$przypisz->bindParam(':id_klienta',$ID);
			$przypisz->bindParam(':id_kursu',$_POST['ID_kursu']);
			$przypisz->bindParam(':znizka',$znizka);
			$przypisz -> execute();
		
		}
		
		$data_dzisiejsza = Date("Y-m-d");
		$sql = "select kursy.ID_kursu as ID_kursu, kursy.Nazwa_kursu as Nazwa_kursu, CONCAT(pracownicy.Imie,' ',pracownicy.Nazwisko) as DaneTrenera, kursy.Data_kursu as Data, kursy.Cena_kursu as Cena from kursy join pracownicy on pracownicy.ID_pracownika = kursy.ID_pracownika where kursy.Data_kursu > '$data_dzisiejsza' ";
		$zapytanie = $polaczenie->query($sql);
				//kolumny
		
				echo "<table border>";
				echo "<th> Nazwa Kursu <th> Imie i Nazwisko Trenera <th> Data Kursu <th> Cena Kursu";
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
					
					if(!$this->SprawdzCzyJestZapisany($data['ID_kursu']))
					{
						
						echo "<tr>";
						echo '<td>' . $data['Nazwa_kursu'] . '<td>' . $data['DaneTrenera'] . '<td>' . $data['Data'] . '<td>' . $data['Cena'];
						echo "<td>";
						echo "<form action= '' method = 'POST' >";
						echo "<input type = 'text' name = 'ID_kursu' value = " . $data['ID_kursu'] . " hidden> ";
						echo "<input type = 'submit' value = 'Zapisz'> </form>";
						echo "</td>";
					}
				}					
		$polaczenie = null;
	}


public function ZarzadzajKursami()
	{
	$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');		

			$ID = $this->ID_Klienta;
		if(isset($_POST['ID']))
		{
			
		
		$usun = $polaczenie->prepare('delete from kursy_klient where ID = :id');
			$usun->bindParam(':id',$_POST['ID']);
		
			$usun -> execute();
		
		}
			if(isset($_POST['Zaplac']))
		{
			
		$tak = "Tak";
		$zmien = $polaczenie->prepare('update kursy_klient SET Zaplacone= :tak where ID = :id');
			$zmien->bindParam(':id',$_POST['Zaplac']);
		$zmien->bindParam(':tak',$tak);
			$zmien -> execute();
		
		}
		
			$data_dzisiejsza = Date("Y-m-d");
		$sql = "select kursy_klient.znizka as znizka ,kursy_klient.Zaplacone as Zaplacone, kursy_klient.ID as ID,kursy.ID_kursu as ID_kursu, kursy.Nazwa_kursu as Nazwa_kursu, CONCAT(pracownicy.Imie,' ',pracownicy.Nazwisko) as DaneTrenera, kursy.Data_kursu as Data, kursy.Cena_kursu as Cena from kursy join pracownicy on pracownicy.ID_pracownika = kursy.ID_pracownika join kursy_klient on kursy_klient.ID_kursu = kursy.ID_kursu where kursy_klient.ID_klienta = $ID and kursy_klient.Zaplacone = 'Nie' and kursy.Data_kursu > '$data_dzisiejsza' ";
	
		$zapytanie = $polaczenie->query($sql);
		
				//kolumny
			
				echo "<table border>";
				echo "<th> Nazwa Kursu <th> Imie i Nazwisko Trenera <th> Data Kursu <th> Cena Kursu <th> Zaplacone";
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
						echo "<tr>";
						echo '<td>' . $data['Nazwa_kursu'] . '<td>' . $data['DaneTrenera'] . '<td>' . $data['Data'] . '<td>' . $data['Cena'] . '<td>' . $data['Zaplacone'];
						echo "<td>";
						echo "<form action= '' method = 'POST' >";
						echo "<input type = 'text' name = 'ID' value = " . $data['ID'] . " hidden> ";
						echo "<input type = 'submit' value = 'Usun'> </form>";
						echo "</td>";
							echo "<td>";
						echo "<form action= '' method = 'POST' >";
						echo "<input type = 'text' name = 'Zaplac' value = " . $data['ID'] . " hidden> ";
						echo "<input type = 'submit' value = 'Zaplac'> </form>";
						echo "</td>";
						
						
				
				}		
echo "</table>";
echo "<a href = './spis_kursow_klient.php?' > Zestawienie wszystkich zapisanych kursów </a>";				
		$polaczenie = null;
	}
}



class Pracownik
	{
		private $ID_Usera;
		private $login;
		private $haslo;
		private $poziom = 3;
		private $ID_Pracownika;
		
		public function __construct($id,$login,$haslo,$nr)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
		$this->ID_Pracownika = $nr;
	}
		public function Poziom()
	{
		return $this->poziom;
	}
	public function WypiszLogin()
	{
		echo "Jesteś zalogowany/a na koncie : " . $this->login;
	}
		public function Zmien_Haslo()
	{
			$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
			$ID = $this->ID_Usera;
			if(isset($_POST['SubmitButton']))
			{			
			$sql = "select * from uzytkownicy where ID = '$ID'";
				$zapytanie = $polaczenie->query($sql);
				$data = $zapytanie ->fetch(PDO::FETCH_ASSOC);
				$haslo = md5($_POST['Stare_Haslo']);
				if($data['Password'] == $haslo)
				{
					$nowe_haslo = md5($_POST['Nowe_Haslo']);
					$zapytanie = $polaczenie->prepare('update uzytkownicy set Password = :haslo where ID = :id');
					$zapytanie -> bindParam(':haslo',$nowe_haslo);
					$zapytanie -> bindParam(':id',$ID);
					$zapytanie -> execute();
					
				}
				else
				{
				header("Location:  logout.php");
				exit;
					
				}
			}
		$zapytanie = $polaczenie->prepare('select * from klient where ID_klienta = :id');
		$zapytanie -> bindParam(':id',$ID);
		$zapytanie -> execute();
				//formularz do zmiany hasla
				echo "<form action ='' method = 'POST'>";
				echo "Prosze wypełnić pola formularza w celu zmiany hasła  <br> <br>";
				echo "Aktualne Haslo <br> <input type = 'password' name = 'Stare_Haslo' required > <br>";	
				echo "Nowe Haslo <br> <input type = 'password' name = 'Nowe_Haslo' required > <br>";	
				echo "<br> <input type = 'submit' value = 'Zmien'  name = 'SubmitButton'>";
				echo '</form>';
		$polaczenie = null;
	}
}


class Admin	
	{
		private $ID_Usera;
		private $login;
		private $haslo;
		private $poziom = 5;
		private $ID_Pracownika;
		
		public function __construct($id,$login,$haslo,$nr)
	{
		$this->ID_Usera = $id;
		$this->login = $login;
		$this->haslo = $haslo;
		$this->ID_Pracownika = $nr;
	}
	public function WypiszLogin()
	{
		echo "Jesteś zalogowany/a na koncie : " . $this->login;
	}
		public function Poziom()
	{
		return $this->poziom;
	}
				public function Zmien_Haslo()
	{
			$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
			$ID = $this->ID_Usera;
			if(isset($_POST['SubmitButton']))
			{			
			$sql = "select * from uzytkownicy where ID = '$ID'";
				$zapytanie = $polaczenie->query($sql);
				$data = $zapytanie ->fetch(PDO::FETCH_ASSOC);
				$haslo = md5($_POST['Stare_Haslo']);
				if($data['Password'] == $haslo)
				{
					$nowe_haslo = md5($_POST['Nowe_Haslo']);
					$zapytanie = $polaczenie->prepare('update uzytkownicy set Password = :haslo where ID = :id');
					$zapytanie -> bindParam(':haslo',$nowe_haslo);
					$zapytanie -> bindParam(':id',$ID);
					$zapytanie -> execute();
					
				}
				else
				{
				header("Location:  logout.php");
				exit;
					
				}
			}
		$zapytanie = $polaczenie->prepare('select * from klient where ID_klienta = :id');
		$zapytanie -> bindParam(':id',$ID);
		$zapytanie -> execute();
				//formularz do zmiany hasla
				echo "<form action ='' method = 'POST'>";
				echo "Prosze wypełnić pola formularza w celu zmiany hasła <br> <br>";
				echo "Aktualne Haslo <br> <input type = 'password' name = 'Stare_Haslo' required > <br>";	
				echo "Nowe Haslo <br> <input type = 'password' name = 'Nowe_Haslo' required > <br>";	
				echo "<br> <input type = 'submit' value = 'Zmien'  name = 'SubmitButton'>";
				echo '</form>';
		$polaczenie = null;
	}
	public function ZarzadzajPracownikami()
	{
	$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');		

		
		if(isset($_POST['ID']))
		{
			$data_dzisiejsza = Date("Y-m-d");
			$zwolnij = $polaczenie->prepare('update pracownicy set Data_skonczenia_zatrudnienia = :data where ID_pracownika = :id');
			$zwolnij->bindParam(':data',$data_dzisiejsza);
		$zwolnij->bindParam(':id',$_POST['ID']);
		
			$zwolnij -> execute();
		
		}
		
		
		$sql = "select * from pracownicy where Data_skonczenia_zatrudnienia is null";
		$zapytanie = $polaczenie->query($sql);
		
				//kolumny
				echo "<a href = './spis_pracownikow.php'>Drukuj zestawienie pracowników pracujących oraz pracowników zwolnionych</a><br><br>";
				echo "Pracownicy zatrudnieni:<br>";
				echo "<table border>";
				echo "<th> Imie <th> Nazwisko <th> Pesel <th> Pensja <th> Stanowisko <th> Miejscowosc <th> Ulica <th> NrLokalu <th> NrMieszkania <th> Data Zatrudnienia";
				while($data = $zapytanie->fetch(PDO::FETCH_ASSOC))
				{
						echo "<tr>";
						echo '<td>' . $data['Imie'] . '<td>' . $data['Nazwisko'] . '<td>' . $data['Pesel'] . '<td>' . $data['Pensja'] . '<td>' . $data['Stanowisko'] .  '<td>' . $data['Miejscowosc'] . '<td>' . $data['Ulica'] . '<td>' . $data['NrLokalu'] . '<td>' . $data['NrMieszkania'] . '<td>' . $data['Data_zatrudnienia'];
						echo "<td>";
						echo "<form action= '' method = 'POST' >";
						echo "<input type = 'text' name = 'ID' value = " . $data['ID_pracownika'] . " hidden> ";
						echo "<input type = 'submit' value = 'Zwolnij'> </form>";
						echo "</td>";
						echo "<td>";
						echo "<form action= 'zarzadzanie_pracownikiem.php' method = 'POST' >";
						echo "<input type = 'text' name = 'ID' value = " . $data['ID_pracownika'] . " hidden> ";
						echo "<input type = 'submit' value = 'Edytuj Dane'> </form>";
						echo "</td>";
						
						
				
				}					
		$polaczenie = null;
	}
		public function Aktualizacja_Danych_Pracownika($id)
	{
		
		$ID = $id;
		if(isset($_POST['SubmitButton']))
		{
			
			
			$pensja = pensja($_POST['Stanowisko']);
			
				$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
		$dodanie = $polaczenie->prepare('UPDATE pracownicy set Imie = :imie, Nazwisko = :nazwisko, Pesel = :pesel,Pensja = :pensja, Stanowisko = :stanowisko, Miejscowosc = :miejscowosc, Ulica =:ulica, NrLokalu = :nrlokalu, NrMieszkania = :nrmieszkania where ID_pracownika = :id'); 
		$dodanie ->bindParam(':id',$ID);
		$dodanie ->bindParam(':imie',$_POST['Imie']);
		$dodanie ->bindParam(':nazwisko',$_POST['Nazwisko']);
		$dodanie ->bindParam(':miejscowosc',$_POST['Miejscowosc']);
		$dodanie ->bindParam(':ulica',$_POST['Ulica']);
		$dodanie ->bindParam(':nrlokalu',$_POST['NrLokalu']);
		$dodanie ->bindParam(':nrmieszkania',$_POST['NrMieszkania']);
		$dodanie ->bindParam(':stanowisko',$_POST['Stanowisko']);
		$dodanie ->bindParam(':pensja',$pensja);
		$dodanie ->bindParam(':pesel',$_POST['Pesel']);
		$dodanie ->execute();
		$polaczenie = null;
		
		}
		
		$polaczenie = new PDO('mysql:host=localhost;dbname=projekt','root','');
		$zapytanie = $polaczenie->prepare('select * from pracownicy where ID_pracownika = :id ');
		$zapytanie -> bindParam(':id',$ID);
		$zapytanie -> execute();
				//formularz do zmiany danych
			$data = $zapytanie->fetch(PDO::FETCH_ASSOC);
				echo "<form action = '' method = 'POST'>";
				echo "<input type = text name = 'ID' value = '" . $data['ID_pracownika'] . "'hidden>";
				echo "Imie <br> <input type = 'Text'  required name = 'Imie' value = '" .$data['Imie'] . "'>" ;
				echo "<br> Nazwisko <br> <input type = 'Text'  required name = 'Nazwisko' value = '" . $data['Nazwisko'] . "'>";
				echo "<br> Pesel <br> <input type='text' value = '" . $data['Pesel'] ."' name='Pesel' pattern='[0-9]{11}' title='Podaj 11 cyfrowy pesel' required>";
				echo "<br> Stanowisko <br>";
				echo "<select name='Stanowisko' required >";
				echo "<option value='Szef' >Szef</option>";
				echo "<option value='Trener' selected  >Trener</option>";
				echo "<option value='Normalny'>Biurowy</option>";
				echo "</select>";
				echo "<br>";
				echo "<br> Miejscowosc <br> <input type = 'Text' required  name = 'Miejscowosc' value ='" . $data['Miejscowosc'] . "'>";
				echo "<br> Ulica <br> <input type = 'Text'  required name = 'Ulica' value = '" .$data['Ulica'] . "'>";
				echo "<br> NrLokalu<br> <input type = 'number' required  min = 0 name = 'NrLokalu' value = '" . $data['NrLokalu'] . "'>";
				echo "<br> NrMieszkania <br> <input type ='number' required min = 0 name = 'NrMieszkania' value = '" . $data['NrMieszkania'] ."'>";
				echo "<br> <input type = 'submit' name = 'SubmitButton'>";
				echo "</form>";
		
	}	
}




?>

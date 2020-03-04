-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 05 Sty 2018, 19:25
-- Wersja serwera: 10.1.28-MariaDB
-- Wersja PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `projekt`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `karnet`
--

CREATE TABLE `karnet` (
  `ID_karnetu` int(11) NOT NULL,
  `Nazwa_Karnetu` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Cena` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `karnet`
--

INSERT INTO `karnet` (`ID_karnetu`, `Nazwa_Karnetu`, `Cena`) VALUES
(1, 'Nazwa', 12),
(2, 'nazwa', 21),
(3, '123', 1000000),
(4, 'asdsa', 212);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `karnet_klient`
--

CREATE TABLE `karnet_klient` (
  `ID` int(11) NOT NULL,
  `ID_klienta` int(11) NOT NULL,
  `ID_Karnetu` int(11) NOT NULL,
  `Data_zakupienia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `karnet_klient`
--

INSERT INTO `karnet_klient` (`ID`, `ID_klienta`, `ID_Karnetu`, `Data_zakupienia`) VALUES
(13, 3, 2, '2017-12-27'),
(14, 3, 1, '2017-12-28'),
(15, 4, 1, '2017-12-28'),
(16, 4, 3, '2017-12-28');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klient`
--

CREATE TABLE `klient` (
  `ID_klienta` int(11) NOT NULL,
  `Imie` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Miejscowosc` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Ulica` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `NrLokalu` smallint(6) NOT NULL,
  `NrMieszkania` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `klient`
--

INSERT INTO `klient` (`ID_klienta`, `Imie`, `Nazwisko`, `Miejscowosc`, `Ulica`, `NrLokalu`, `NrMieszkania`) VALUES
(1, 'PaweÅ‚', 'Pryzwan', 'Ruda ÅšlÄ…ska', 'Fojkisa', 2, 22),
(2, 'Cosw', 'Cos', 'Coss', 'Cos', 2, 24),
(3, 'Ktos', 'Ktos', 'Ktos', 'Jakas', 22, 1),
(4, 'Jan', 'Kowalski', 'Ruda Slaska', 'Fojkisa', 2, 22),
(5, 'Maciek', 'Maciek', 'Maciejowsko', 'Maciejska', 4, 32);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kursy`
--

CREATE TABLE `kursy` (
  `ID_kursu` int(11) NOT NULL,
  `Nazwa_kursu` varchar(60) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `ID_pracownika` int(11) NOT NULL,
  `Data_kursu` date NOT NULL,
  `Cena_kursu` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `kursy`
--

INSERT INTO `kursy` (`ID_kursu`, `Nazwa_kursu`, `ID_pracownika`, `Data_kursu`, `Cena_kursu`) VALUES
(1, 'jakas nazwa', 2, '2017-12-25', 500),
(2, 'Jakis Kurs', 4, '2018-11-23', 500.23),
(3, 'Allah Akbra', 4, '2017-12-30', 200.2),
(4, 'Testowy Kurs', 4, '2017-12-31', 5000),
(5, 'Testowy Kurs 2', 4, '2017-12-29', 500),
(6, '22222', 4, '2017-12-28', 0.36),
(7, 'Kurs 2', 5, '2018-01-05', 500),
(8, 'asd', 5, '2018-01-06', 42);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kursy_klient`
--

CREATE TABLE `kursy_klient` (
  `ID` int(11) NOT NULL,
  `ID_kursu` int(11) NOT NULL,
  `ID_klienta` int(11) NOT NULL,
  `Zaplacone` enum('Tak','Nie') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL DEFAULT 'Nie',
  `Znizka` enum('Tak','Nie') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `kursy_klient`
--

INSERT INTO `kursy_klient` (`ID`, `ID_kursu`, `ID_klienta`, `Zaplacone`, `Znizka`) VALUES
(4, 1, 2, 'Nie', 'Tak'),
(5, 2, 2, 'Nie', 'Tak'),
(6, 3, 2, 'Nie', 'Tak'),
(16, 2, 3, 'Nie', 'Tak'),
(17, 3, 3, 'Nie', 'Tak'),
(21, 3, 4, 'Nie', 'Nie'),
(23, 4, 4, 'Nie', 'Tak'),
(25, 2, 4, 'Tak', 'Nie'),
(27, 8, 4, 'Tak', 'Nie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownicy`
--

CREATE TABLE `pracownicy` (
  `ID_pracownika` int(11) NOT NULL,
  `Imie` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Nazwisko` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Pesel` bigint(20) DEFAULT NULL,
  `Pensja` int(11) NOT NULL,
  `Stanowisko` enum('Normalny','Trener','Szef') CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Miejscowosc` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Ulica` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `NrLokalu` smallint(6) NOT NULL,
  `NrMieszkania` smallint(6) NOT NULL,
  `Data_zatrudnienia` date NOT NULL,
  `Data_skonczenia_zatrudnienia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `pracownicy`
--

INSERT INTO `pracownicy` (`ID_pracownika`, `Imie`, `Nazwisko`, `Pesel`, `Pensja`, `Stanowisko`, `Miejscowosc`, `Ulica`, `NrLokalu`, `NrMieszkania`, `Data_zatrudnienia`, `Data_skonczenia_zatrudnienia`) VALUES
(1, 'Admin', 'Admin', 12345678911, 10000, 'Szef', 'Ruda ?l?ska', 'Fojkisa ', 2, 22, '2017-12-01', NULL),
(2, 'Pracownik', 'Pracownik', 12345678022, 10000, 'Szef', 'Ruda', 'USAd', 2, 21, '2017-12-18', '2017-12-28'),
(3, 'Trener', 'Trener', 12345612345, 3000, 'Trener', 'Bytom', 'Bytomska', 2, 32, '2017-12-21', NULL),
(4, 'Andrzej', 'Andrzej', 98765432122, 3500, 'Trener', 'Gdzies', 'jakas', 5, 23, '2017-12-20', '2017-12-28'),
(5, '123', '123', 12345678022, 3500, 'Trener', 'cos', 'cos', 2, 22, '2017-12-28', NULL),
(6, '123', '123', 12345678022, 3500, 'Trener', 'cos', 'cos', 2, 22, '2017-12-28', NULL),
(7, '123', '123', 12345678022, 3500, 'Trener', 'cos', 'cos', 2, 22, '2017-12-28', '2018-01-05'),
(8, 'Test', 'Test', 12312321322, 10000, 'Szef', 'Test', 'Test', 2, 12, '2018-01-05', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID` int(11) NOT NULL,
  `Login` varchar(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Poziom_uprawnienia` int(11) NOT NULL,
  `ID_klienta` int(11) DEFAULT NULL,
  `ID_pracownika` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID`, `Login`, `Password`, `Poziom_uprawnienia`, `ID_klienta`, `ID_pracownika`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 5, NULL, 1),
(2, 'Cos', 'ffca562be079b9e4e41ea9d6a86c582b', 1, 2, NULL),
(6, 'Pracownik', '8b831e3bff7bb365944561809a61d9e6', 3, NULL, 2),
(8, 'Prac', 'aee368e00f749ee01a530db71a49fe24', 3, NULL, 4),
(9, 'Klient', '4c799140a3aa3ea2f499ce191a285c0d', 1, 4, NULL),
(10, '123', '202cb962ac59075b964b07152d234b70', 3, NULL, 5),
(11, '123', '202cb962ac59075b964b07152d234b70', 3, NULL, 6),
(12, '123', '8d4646eb2d7067126eb08adb0672f7bb', 3, NULL, 7),
(13, 'Maciek', 'b20ddd773ae9407bc168f3753698fea6', 1, 5, NULL),
(14, 'test223', '098f6bcd4621d373cade4e832627b4f6', 3, NULL, 8);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `karnet`
--
ALTER TABLE `karnet`
  ADD PRIMARY KEY (`ID_karnetu`);

--
-- Indexes for table `karnet_klient`
--
ALTER TABLE `karnet_klient`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`ID_klienta`);

--
-- Indexes for table `kursy`
--
ALTER TABLE `kursy`
  ADD PRIMARY KEY (`ID_kursu`);

--
-- Indexes for table `kursy_klient`
--
ALTER TABLE `kursy_klient`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pracownicy`
--
ALTER TABLE `pracownicy`
  ADD PRIMARY KEY (`ID_pracownika`);

--
-- Indexes for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `karnet`
--
ALTER TABLE `karnet`
  MODIFY `ID_karnetu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `karnet_klient`
--
ALTER TABLE `karnet_klient`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `klient`
--
ALTER TABLE `klient`
  MODIFY `ID_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `kursy`
--
ALTER TABLE `kursy`
  MODIFY `ID_kursu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `kursy_klient`
--
ALTER TABLE `kursy_klient`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT dla tabeli `pracownicy`
--
ALTER TABLE `pracownicy`
  MODIFY `ID_pracownika` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

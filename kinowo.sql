-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 21 Lis 2020, 20:04
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `kinowo`
--
CREATE DATABASE IF NOT EXISTS `kinowo` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `kinowo`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `login` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `accounts`
--

INSERT INTO `accounts` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2y$10$W.gN8GfYxhxHnV1QpO2isuQ.n5gaEZtrnl/ICU7feXdd88HOtf7by');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_polish_ci NOT NULL,
  `cover` varchar(100) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `movies`
--

INSERT INTO `movies` (`id`, `title`, `description`, `cover`) VALUES
(1, 'Na noże (2019)', 'Słynny autor powieści kryminalnych Harlan Trombley zostaje znaleziony martwy w swej posiadłości dzień po 85-tych urodzinach. Śledztwo prowadzi równie elegancki, co dociekliwy detektyw Benoit Blanc. Dzień przed fatalnym zejściem Trombleya w jego posiadłości odbyła się huczna uroczystość z udziałem jego dość szczególnej rodziny. Detektyw Blanc podejrzewa wszystkich, łącznie z najbardziej oddaną służącą denata. Z determinacją i wprawą przedziera się przez sieć rodzinnych zależności, zawiści, wzajemnych oskarżeń i finansowych oczekiwań. Motyw ma tu każdy, jak to w rodzinie. Okazji podczas urodzin seniora rodu również nie brakowało nikomu, ale sprawca może być tylko jeden. Zamknięci w luksusowej posiadłości, poddani nieszablonowym metodom śledczym Blanca, \"bliscy\" Trombleya zmuszeni są do podjęcia morderczej gry, której wynik do ostatniej chwili pozostanie zagadką.', 'Na noże (2019).jpg'),
(2, 'Księżniczka Mononoke (1997)', 'Wojownik o imieniu Ashitaka broni swej wioski przed złym potworem. Choć zwycięża, radość jego jest krótka. Potwór podczas walki rzucił na niego klątwę, z której oczyścić go może tylko legendarny bóg zwierząt. Ashitaka rusza na jego poszukiwania. Wkrótce staje w środku konfliktu pomiędzy cywilizacją i mitycznymi siłami natury, które zagrożone przez człowieka wypowiedziały mu wojnę. Po stronie dzikiej natury stoi wychowana przez białą wilczycę księżniczka Mononoke. Walczy ona z władczynią potężnej osady, której działalność zagraża egzystencji zwierząt w dzikich lasach. Ashitaka musi opowiedzieć się za jedną ze stron.', 'Księżniczka Mononoke (1997).jpg'),
(3, 'Zawrót głowy (1958)', 'Akcja filmu rozgrywa się w San Francisco. James Stewart w roli cierpiącego na lęk wysokości detektywa, wynajętego by śledzić żonę przyjaciela, która ma skłonności samobójcze (Kim Novak). Kiedy pewnego dnia udaje mu się uratować ją przed skokiem do zatoki, uświadamia sobie, że ta piękna, tajemnicza kobieta stała się obiektem jego obsesyjnego pożądania.', 'Zawrót głowy (1958).jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `seance` int(11) NOT NULL,
  `row` int(2) NOT NULL,
  `seat` int(2) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `number` varchar(9) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `reservations`
--

INSERT INTO `reservations` (`id`, `seance`, `row`, `seat`, `name`, `number`) VALUES
(1, 2, 1, 1, 'Tymek', '795935812'),
(2, 2, 1, 2, 'Tymek', '795935812'),
(3, 2, 8, 9, 'Marek', '123123123'),
(4, 2, 8, 10, 'Marek', '123123123'),
(5, 2, 8, 11, 'Marek', '123123123'),
(6, 1, 8, 10, 'Marek', '123123123'),
(7, 7, 15, 20, 'Marek', '123123123'),
(8, 2, 8, 13, 'Tomasz', '123321321'),
(9, 2, 8, 14, 'Tomasz', '123321321'),
(10, 2, 8, 15, 'Tomasz', '123321321'),
(11, 2, 9, 13, 'Mariusz', '123192821'),
(12, 2, 9, 14, 'Mariusz', '123192821'),
(13, 2, 9, 15, 'Mariusz', '123192821'),
(14, 2, 12, 9, 'Julia', '912312122'),
(15, 2, 12, 10, 'Julia', '912312122'),
(16, 2, 12, 11, 'Julia', '912312122'),
(17, 2, 12, 12, 'Julia', '912312122'),
(18, 2, 6, 10, 'Róża', '815928911'),
(19, 2, 11, 6, 'Maria', '123513231'),
(20, 2, 11, 7, 'Maria', '123513231'),
(21, 1, 8, 12, 'Barbara', '123223234'),
(22, 1, 8, 13, 'Barbara', '123223234'),
(23, 1, 8, 14, 'Barbara', '123223234'),
(24, 1, 8, 8, 'Tomek', '234221231'),
(25, 1, 7, 9, 'Tomek', '123125212'),
(26, 1, 7, 11, 'Marek', '123532123');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `seances`
--

CREATE TABLE `seances` (
  `id` int(11) NOT NULL,
  `movie` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `seances`
--

INSERT INTO `seances` (`id`, `movie`, `date`, `time`) VALUES
(1, 1, '2020-11-13', '12:30:00'),
(2, 1, '2020-11-13', '13:30:00'),
(3, 1, '2020-11-20', '16:00:00'),
(4, 1, '2020-11-20', '18:30:00'),
(5, 1, '2020-11-20', '20:15:00'),
(6, 2, '2020-11-27', '13:15:00'),
(7, 2, '2020-11-30', '12:15:00'),
(8, 2, '2020-12-02', '19:30:00'),
(9, 3, '2020-11-13', '16:19:00'),
(10, 3, '2020-11-13', '17:30:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `seances`
--
ALTER TABLE `seances`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT dla tabeli `seances`
--
ALTER TABLE `seances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

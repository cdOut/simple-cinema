Bazowe konto do panelu administracyjnego w projekcie:
	- l: admin, p: admin

Możliwości:
	- repertuar wyświetlający seanse z bazy
	- możliwość zarezerwowania miejsc i sprawdzenia rezerwacji
	- panel administracyjny umożliwiający dodawanie filmów i seansów
	- podstawowa walidacja uniemożliwiająca dodawanie tych samych danych

PHP:
	- Łączenie z bazą przy pomocy PDO
	- Hashowanie haseł kont panelu administracyjnego
	- Zapisywanie sesji / brak możliwości wejścia na niektóre podstrony
	bez wcześniejszego wprowadzenia danych

Konfiguracja połączenia z bazą danych jest w pliku:
	- src/config.php
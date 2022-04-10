<?php

require_once 'src/database.php';

if(isset($_POST['data-check'])) {
    if(!empty($_POST['data-number'])) {

        $number = filter_input(INPUT_POST, 'data-number');

        $query = $db->query("SELECT * FROM reservations WHERE number = '$number'");
        $reservations = $query->fetchAll();

    } else {
        $checkMsg = '<p class="error">✖ Proszę uzupełnić wszystkie pola</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kinowo | Sprawdź rezerwacje</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="gfx/icon.png">
</head>
<body>
    <header>
        <div class="logo">
            <img src="gfx/icon.png"/>
            <p>Kinowo</p>
        </div>
        <div class="nav">
            <a href="index.php">Repertuar</a>|
            <a href="check.php">Sprawdź rezerwacje</a>|
            <a href="login.php">Panel administracyjny</a>
        </div>
    </header>
    <main>

<?php

    if(!empty($checkMsg)) {
        echo "<div class='message'>$checkMsg</div>";
    }

?>
        
        <form class="formContainer" action="check.php" method="post">
            <h2>Sprawdź swoje rezerwacje</h2>
            <input placeholder="Numer telefonu" type="tel" pattern="[0-9]{9}" name="data-number">
            <input type="submit" name="data-check" value="Sprawdź rezerwacje">
        </form>

<?php

    echo "<div class='container'><h2>Twoje rezerwacje</h2>";
    if(!empty($reservations)) {
        echo "<p class='rwelcome'><b>{$reservations[0]['name']}</b>, oto Twoje rezerwacje:</p>";
        echo "<div class='reservations'>";
        foreach($reservations as $reserv) {

            $query = $db->query("SELECT movies.title, seances.date, seances.time FROM seances INNER JOIN movies ON seances.movie = movies.id WHERE seances.id = '{$reserv['seance']}'");
            $seance = $query->fetchAll();

            $title = $seance[0]['title'];
            $date = $seance[0]['date'];
            $time = substr($seance[0]['time'], 0, -3);

            echo "<div class='reservation'>
                <h3>$title</h3>
                <h4>$date | $time</h4>
                <p>Rząd: <b>{$reserv['row']}</b>, Miejsce: <b>{$reserv['seat']}</b></p>
            </div>";
        }
        echo "</div>";
    } else {
        echo "<p style='text-align: center'>Brak rezerwacji dla podanego numeru telefonu</p>";
    }
    echo "</div>";

?>

    </main>
    <footer>
        <p>Tymoteusz Kałuzieński 4ID1 | All rights reserved 2020 ©</p>
    </footer>
</body>
</html>
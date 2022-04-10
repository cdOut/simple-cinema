<?php

require_once 'src/database.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kinowo | Repertuar</title>
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
        <div class="container">
            <h2>Repertuar kina</h2>

<?php

    $query = $db->query('SELECT * FROM movies');
    $movies = $query->fetchAll();

    foreach($movies as $movie) {
        $squery = $db->query('SELECT * FROM seances WHERE movie = ' . $movie['id']);
        $seances = $squery->fetchAll();

        $mseances = '';
        foreach($seances as $seance) {
            $stime = substr($seance['time'], 0, -3);
            $sdate = date('d/m/Y', strtotime($seance['date']));
            $mseances .= "<form method='POST' action='booking.php'>
                <input type='hidden' name='seance-id' value='{$seance['id']}'/>
                <input type='submit' class='seance' value='{$sdate} | {$stime}'/>
            </form>";
        }

        if(empty($mseances)) {
            $mseances = '<p class="noseances">Aktualnie brak seansów dla tego filmu.</p>';
        }

        $coverDir = 'uploads/' . $movie['cover'];
        echo "<div class='movie'>
            <div class='image'><img src='{$coverDir}'/></div>
            <div class='info'>
                <h3>{$movie['title']}</h3>
                <p>{$movie['description']}</p>
                <h3>Seanse:</h3>
                <div class='seances'>{$mseances}</div>
            </div>
        </div>";
    }

?>

        </div>
    </main>
    <footer>
        <p>Tymoteusz Kałuzieński 4ID1 | All rights reserved 2020 ©</p>
    </footer>
</body>
</html>
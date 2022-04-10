<?php

session_start();

require_once 'src/database.php';

if(!isset($_SESSION['logged'])) {
    header('Location: login.php');
    exit();
}

if(isset($_POST['movie-add'])) {
    if(!empty($_POST['movie-title']) && !empty($_POST['movie-description']) && !empty($_FILES['movie-cover']['name'])) {

        $title = filter_input(INPUT_POST, 'movie-title');
        $description = filter_input(INPUT_POST, 'movie-description');

        $query = $db->query("SELECT * FROM movies WHERE title = '$title'");
        $movieList = $query->fetchAll();

        if(count($movieList) == 0) {
            $targetDir = 'uploads/';
            $cover = $title . '.' . pathinfo($_FILES['movie-cover']['name'], PATHINFO_EXTENSION);
            $targetPath = $targetDir . $cover;

            if(move_uploaded_file($_FILES['movie-cover']['tmp_name'], $targetPath)) {
                $query = $db->prepare('INSERT INTO movies VALUES (NULL, :title, :description, :cover)');
                $query->bindValue(':title', $title, PDO::PARAM_STR);
                $query->bindValue(':description', $description, PDO::PARAM_STR);
                $query->bindValue(':cover', $cover, PDO::PARAM_STR);
                $query->execute();

                $movieMsg = '<p class="success">✔ Pomyślnie dodano nowy film</p>';
            } else {
                $movieMsg = '<p class="error">✖ Błąd podczas wysyłania obrazu</p>';
            }
        } else {
            $movieMsg = '<p class="error">✖ W bazie jest już film o takim tytule</p>';
        }
    } else {
        $movieMsg = '<p class="error">✖ Proszę uzupełnić wszystkie pola</p>';
    }
} else if(isset($_POST['seance-add'])) {
    if(!empty($_POST['seance-movie']) && !empty($_POST['seance-date']) && !empty($_POST['seance-time'])) {

        $movieId = filter_input(INPUT_POST, 'seance-movie');
        $date = filter_input(INPUT_POST, 'seance-date');
        $time = filter_input(INPUT_POST, 'seance-time');

        $tdate = date('Y-m-d', strtotime($date));
        $ttime = $time . ":00";

        $query = $db->query("SELECT * FROM seances WHERE movie = $movieId AND date = '$tdate' AND time = '$ttime'");
        $seances = $query->fetchAll();

        if(count($seances) == 0) {
            $query = $db->prepare('INSERT INTO seances VALUES (NULL, :movie, :date, :time)');
            $query->bindValue(':movie', $movieId, PDO::PARAM_INT);
            $query->bindValue(':date', $date, PDO::PARAM_STR);
            $query->bindValue(':time', $time, PDO::PARAM_STR);
            $query->execute();

            $seanceMsg = '<p class="success">✔ Pomyślnie dodano nowy seans</p>';
        } else {
            $seanceMsg = '<p class="error">✖ Ten seans już istnieje w bazie</p>';
        }
    } else {
        $seanceMsg = '<p class="error">✖ Proszę uzupełnić wszystkie pola</p>';
    }
} else if(isset($_POST['acc-add'])) {
    if(!empty($_POST['acc-login']) && !empty($_POST['acc-pass']) && !empty($_POST['acc-passtwo'])) {

        $login = filter_input(INPUT_POST, 'acc-login');
        $pass = filter_input(INPUT_POST, 'acc-pass');
        $passtwo = filter_input(INPUT_POST, 'acc-passtwo');

        if($pass == $passtwo) {
            $query = $db->query("SELECT * FROM accounts WHERE login = '$login'");
            $accounts = $query->fetchAll();

            if(count($accounts) == 0) {
                $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

                $query = $db->prepare('INSERT INTO accounts VALUES (NULL, :login, :password)');
                $query->bindValue(':login', $login, PDO::PARAM_STR);
                $query->bindValue(':password', $pass_hash, PDO::PARAM_STR);
                $query->execute();

                $accountMsg = '<p class="success">✔ Pomyślnie dodano nowe konto administratora</p>';
            } else {
                $accountMsg = '<p class="error">✖ Konto o tym loginie istnieje już w bazie</p>';
            }
        } else {
            $accountMsg = '<p class="error">✖ Podane hasła muszą być takie same</p>';
        }
    } else {
        $accountMsg = '<p class="error">✖ Proszę uzupełnić wszystkie pola</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kinowo | Panel administracyjny</title>
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
            <a href="logout.php">Wyloguj się</a>
        </div>
    </header>
    <main>

<?php

if(!empty($movieMsg)) {
    echo "<div class='message'>$movieMsg</div>";
}

?>

        <form class="formContainer" action="admin.php" method="post" enctype="multipart/form-data">
            <h2>Dodaj nowy film</h2>
            <input placeholder="Tytuł filmu" type="text" name="movie-title">
            <textarea placeholder="Opis filmu" rows="8" name="movie-description"></textarea>
            <div class="inpCont">
                <p>Obraz:</p><input type="file" name="movie-cover"><p></p>
            </div>
            <input type="submit" name="movie-add" value="Dodaj film">
        </form>

<?php

if(!empty($seanceMsg)) {
    echo "<div class='message'>$seanceMsg</div>";
}

?>

        <form class="formContainer" action="admin.php" method="post">
            <h2>Dodaj nowy seans</h2>
            <div class="inpCont">
                <p>Film:</p><select name="seance-movie">

<?php

$query = $db->query('SELECT * FROM movies');
$movies = $query->fetchAll();

foreach($movies as $movie) {
    echo "<option value='{$movie['id']}'>{$movie['title']}</option>";
}

?>

                </select><p></p>
            </div>
            <div class="inpCont">
                <p>Data:</p><input type="date" name="seance-date"><p></p>
            </div>
            <div class="inpCont">
            <p>Godzina:</p><input type="time" name="seance-time"><p></p>
            </div>
            <input type="submit" name="seance-add" value="Dodaj seans">
        </form>

<?php

if(!empty($accountMsg)) {
    echo "<div class='message'>$accountMsg</div>";
}

?>

        <form class="formContainer" action="admin.php" method="post">
            <h2>Dodaj konto administratora</h2>
            <input placeholder="Login" type="text" name="acc-login">
            <input placeholder="Hasło" type="password" name="acc-pass">
            <input placeholder="Potwierdź hasło" type="password" name="acc-passtwo">
            <input type="submit" name="acc-add" value="Dodaj konto">
        </form>
    </main>
    <footer>
        <p>Tymoteusz Kałuzieński 4ID1 | All rights reserved 2020 ©</p>
    </footer>
</body>
</html>
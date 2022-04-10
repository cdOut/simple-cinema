<?php

session_start();

require_once 'src/database.php';

if(isset($_SESSION['logged'])) {
    header('Location: admin.php');
    exit();
}

if(isset($_POST['acc-log'])) {
    if(!empty($_POST['acc-login']) && !empty($_POST['acc-pass'])) {

        $login = filter_input(INPUT_POST, 'acc-login');
        $pass = filter_input(INPUT_POST, 'acc-pass');

        $query = $db->query("SELECT * FROM accounts WHERE login = '$login'");
        $accounts = $query->fetchAll();
        
        if(count($accounts) != 0 && password_verify($pass, $accounts[0]['password'])) {
            $_SESSION['logged'] = true;
            header('Location: admin.php');
            exit();
        } else {
            $loginMsg = '<p class="error">✖ Podano błędne dane / konto nie istnieje</p>';
        }
    } else {
        $loginMsg = '<p class="error">✖ Proszę uzupełnić wszystkie pola</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kinowo | Logowanie</title>
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

if(!empty($loginMsg)) {
    echo "<div class='message'>$loginMsg</div>";
}

?>

        <form class="formContainer" action="login.php" method="post">
            <h2>Panel administracyjny</h2>
            <input placeholder="Login" type="text" name="acc-login">
            <input placeholder="Hasło" type="password" name="acc-pass">
            <input type="submit" name="acc-log" value="Zaloguj się">
        </form>
    </main>
    <footer>
        <p>Tymoteusz Kałuzieński 4ID1 | All rights reserved 2020 ©</p>
    </footer>
</body>
</html>
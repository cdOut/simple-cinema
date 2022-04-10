<?php

session_start();

require_once 'src/database.php';

if(isset($_POST['seance-id'])) {
    $_SESSION['seance-id'] = $_POST['seance-id'];
}

if(!isset($_SESSION['seance-id'])) {
    header('Location: index.php');
    exit(); 
} else if(isset($_POST['data-book'])) {
    
    if(!empty($_POST['data-selected']) && !empty($_POST['data-name']) && !empty($_POST['data-number'])) {

        $selected = json_decode($_POST['data-selected']);
        $seance = $_SESSION['seance-id'];
        $name = filter_input(INPUT_POST, 'data-name');
        $number = filter_input(INPUT_POST, 'data-number');

        $available = true;
        foreach($selected as $seat) {
            $query = $db->query("SELECT * FROM reservations WHERE seance = $seance AND row = {$seat->x} AND seat={$seat->y}");
            $reservations = $query->fetchAll();

            if(count($reservations) != 0) {
                $available = false;
                break;
            }
        }

        if($available) {
            $success = true;

            $query = $db->prepare('INSERT INTO reservations VALUES (NULL, :seance, :row, :seat, :name, :number)');
            $query->bindValue(':seance', $seance, PDO::PARAM_INT);
            $query->bindValue(':name', $name, PDO::PARAM_STR);
            $query->bindValue(':number', $number, PDO::PARAM_STR);
            foreach($selected as $seat) {
                $query->bindValue(':row', $seat->x, PDO::PARAM_INT);
                $query->bindValue(':seat', $seat->y, PDO::PARAM_INT);
                $query->execute();
            }
        } else {
            $bookingMsg = '<p class="error">✖ Jedno z miejsc zostało właśnie zarezerwowane, proszę wybrać inne</p>';
        }
    } else {
        $bookingMsg = '<p class="error">✖ Proszę wybrać miejsce i uzupełnić wszystkie dane</p>';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kinowo | Rezerwacja</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="gfx/icon.png">
    <script type="text/javascript" src="libs/jquery.js"></script>
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

    if(!empty($bookingMsg)) {
        echo "<div class='message'>$bookingMsg</div>";
    } else if (!empty($success)) {
        echo "<div class='container' style='text-align: center;'>
            <h2>Rezerwacja zakończona</h2>
            <p>Pomyślnie zarezerwowano wybrane miejsca. Do zobaczenia w kinie!</p>
            <p>Aby odebrać rezerwacje prosimy o przyjście do kina <b>pół godziny przed rozpoczęciem seansu</b>.
            <br/>W przeciwnym wypadku zarezerwowane miejsca zostaną udostępnione dla wszystkich.</p>
        </div>
        <div class='container' style='text-align: center;'>
            <h2>Co dalej?</h2>
            <p>Zarezerwowane miejsca można sprawdzić w panelu <a class='infoLink' href='check.php'>Sprawdź rezerwacje</a></p>
            <p>Możesz także <a class='infoLink' href='index.php'>powrócić do repertuaru kina</a> aby zarezerwować nowe miejsca.</p>
        </div>
        </main>
        <footer>
            <p>Tymoteusz Kałuzieński 4ID1 | All rights reserved 2020 ©</p>
        </footer>";

        session_unset();

        exit();
    }

?>

        <div class="container">
            <h2>Wybierz miejsca do rezerwacji</h2>
            <p class="seatInfo">Ilość wybranych miejsc: <span id="seat-count">0</span></p>
            <table id="seat-table"></table>
            <div class="seatTypes">
                <p>Wolne</p>
                <p class="taken">Zarezerwowane</p>
                <p class="selected">Wybrane</p>
            </div>
        </div> 
        <form method="POST" action="booking.php" class="formContainer">
            <h2>Podaj swoje dane</h2>
            <input id="form-selected" type="hidden" name="data-selected" value=""/>
            <input placeholder="Imię" type="text" name="data-name">
            <input placeholder="Numer telefonu" type="tel" pattern="[0-9]{9}" name="data-number">
            <input type="submit" name="data-book" value="Zarezerwuj wybrane miejsca">
        </form>
    </main>
    <footer>
        <p>Tymoteusz Kałuzieński 4ID1 | All rights reserved 2020 ©</p>
    </footer>

    <script>

    let selected = [];
    let taken = <?php 

        $query = $db->query("SELECT * FROM reservations WHERE seance = '{$_SESSION['seance-id']}'");
        $seats = $query->fetchAll();

        $taken = array();
        foreach($seats as $seat) {
            $seatObj = new stdClass();
            $seatObj->x = $seat['row'];
            $seatObj->y = $seat['seat'];
            array_push($taken, $seatObj);
        }

        echo json_encode($taken);

    ?>

    for(let x = 1; x <= 16; x++) {
        let tr = $("<tr>");
        if(x < 16) {
            tr.append("<td class='seatLabel'>" + x + "</td>")
        } else {
            tr.append("<td></td>")
        }
        for(let y = 1; y <= 20; y++) {
            let td = $("<td>");
            if(x < 16) {
                td.addClass("seat");
                td.data("x", x);
                td.data("y", y);

                if(taken.filter(seat => { return seat.x == x && seat.y == y; }).length > 0) {
                    td.addClass("taken");
                } else {
                    td.click(function() {
                        if(!$(this).hasClass("taken")) {
                            if($(this).hasClass("selected")) {
                                $(this).removeClass("selected")
                                selected = selected.filter(el => {
                                    return (el.x != $(this).data("x") ||
                                            el.y != $(this).data("y"));
                                });
                            } else {
                                $(this).addClass("selected")
                                selected.push({
                                    x: $(this).data("x"),
                                    y: $(this).data("y"),
                                });
                            }
                            $("#seat-count").text(selected.length)
                            $("#form-selected").val(JSON.stringify(selected));
                        }
                    });
                }
            } else {
                td.addClass("seatLabel");
                td.text(y);
            }
            tr.append(td);
        }
        $("#seat-table").append(tr);
    }

    </script>
</body>
</html>
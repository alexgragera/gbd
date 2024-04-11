<?php
session_start();

echo "<!DOCTYPE html>
     <html>
    <body>";

if (!isset($_SESSION['Film'])) {
    Init_Game();
}

// Main program
// ...
if (Still_Alive() && FilmnotDone()) {
    // ...
    $Char = isset($_POST['letter']) ? strtoupper($_POST['letter']) : null; // Obtener la letra ingresada por el usuario
    if ($Char !== null && strlen($Char) === 1 && ctype_alpha($Char)) {
        if (null !== ($pos = Letter_in_Film($Char, $_SESSION['Film']))) {
            Show_Letter($pos, $Char);
        } else {
            Substract_Life(); // Restar una vida cuando el usuario falla
            Show_Lifes(); // Mostrar las vidas restantes
        }
    } else {
        echo "Por favor, ingrese una única letra del alfabeto.";
    }
} else if (Still_Alive() == false) {
    echo "No quedan vidas. Has perdido el juego.";
    End_game();
} else {
    echo "¡Has adivinado la película! ¡Felicidades!";
    End_game();
}

function Substract_Life() {
    $_SESSION['Lifes'] -= 1; // Restar una vida al jugador
}

function Show_Lifes() {
    echo "<br>";
    echo "Vidas restantes: " . $_SESSION['Lifes'];
}

function Show_Letter($pos, $Letter){
    $hiddenFilmArray = $_SESSION['Hidden_Film'];
    foreach ($pos as $position) {
        $hiddenFilmArray[$position] = $Letter;
    }
    $_SESSION['Hidden_Film'] = $hiddenFilmArray;
    echo "<br><br>";
    echo implode('', $hiddenFilmArray);
}

function Letter_in_Film($Letter, $Film) {
    $pos = [];
    for ($i = 0; $i < strlen($Film); $i++) {
        if (strtoupper($Letter) == strtoupper($Film[$i])) {
            $pos[] = $i;
        }
    }
    return $pos;
}

function Still_Alive() {
    return $_SESSION['Lifes'] > 0;
}

function FilmnotDone() {
    return isset($_SESSION['Hidden_Film']) && in_array('_', $_SESSION['Hidden_Film']);
}

function Init_Game() {
    DEFINE('HOST', "gbd_mysql_A");
    DEFINE('DBNAME', 'ahorcado');
    DEFINE('USERNAME', 'root');
    DEFINE('PASS', '');
    DEFINE('QUERY', 'SELECT titulo FROM pelicula ORDER BY RAND() LIMIT 1');

    $_SESSION['Lifes'] = 6;
    $_SESSION['Letters_used'] = '';
    $_SESSION['Conn'] = new mysqli(HOST, USERNAME, PASS, DBNAME);
    $table = mysqli_query($_SESSION['Conn'], QUERY);

    foreach ($table as $row) {
        foreach ($row as $_SESSION['Film']) {
            $_SESSION['Hidden_Film'] = Hide_Film($_SESSION['Film']);
        }
    }
}

function End_game() {
    session_unset();
    session_destroy();
}

function Hide_Film($film) {
    $hiddenFilm = [];
    for ($i = 0; $i < strlen($film); $i++) {
        if ($film[$i] == ' ') {
            $hiddenFilm[] = ' ';
        } else {
            $hiddenFilm[] = '_';
        }
    }
    echo "<br><br>Película oculta:<br>";
    echo implode('', $hiddenFilm);
    $_SESSION['Hidden_Film'] = implode('', $hiddenFilm); // Guardamos la cadena en la sesión
    return $hiddenFilm;
}
?>

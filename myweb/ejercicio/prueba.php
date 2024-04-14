<?php
session_start();

if (isset($_POST['test'])) {
    // Destruir la sesión actual
    session_destroy();
    // Redirigir al usuario de vuelta a la página del juego
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

initGame();

// Insert your code below here to implement the game logic
if (!isGameOver()) {
    // Display the game status

    // Check if a letter has been submitted

    letraEnPeli();
    peliCompletada();
    displayGameStatus();

    // HTML form to submit a letter
    echo '<form method="post" action="">
        Introduce una letra: <input type="text" name="letter" maxlength="1" pattern="[a-zA-Z]" required>
        <input type="submit" value="Enviar">
        </form>';

    //Boton para reiniciar partida
    echo '<form method="post">
    <button name="test">Reiniciar partida</button>
    </form>';

} else {
    // Game over message
    echo "Juego terminado. La película era: " . $_SESSION['movie'] . "<br><br><br><br>";
    echo '<form method="post">
    <button name="test">Reiniciar partida</button>
    </form>';
}

echo "</body>
      </html>";
// End HTML code

//funciones
function initGame()
{


    // HTML code below
    echo "<!DOCTYPE html>
      <html>
      <body>";
    // End HTML code

    // Constants
    DEFINE('HOST', "gbd_mysql_A");
    DEFINE('DBNAME', 'ahorcado');
    DEFINE('USERNAME', 'root');
    DEFINE('PASS', '');
    DEFINE('QUERY', 'SELECT titulo FROM pelicula ORDER BY RAND() LIMIT 1');

    // Initialize session variables
    if (!isset($_SESSION['Lifes'])) {
        $_SESSION['Done'] = 0; // Check if the movie has been completed: 0 no, 1 yes
        $_SESSION['Lifes'] = 6; // Number of lifes
        $_SESSION['Characters_used'] = ''; // Characters used to discover the film

        // Database connection
        $_SESSION['Conn'] = mysqli_connect(HOST, USERNAME, PASS, DBNAME);


        // Execute the query to get a random movie
        if (!isset($_SESSION['movie'])) {
            $table = mysqli_query($_SESSION['Conn'], QUERY);
            $row = mysqli_fetch_assoc($table);
            $_SESSION['movie'] = $row['titulo'];
        }

    }
}

function esconderPalabra()
{

    echo "Película: ";
    $characters = str_split($_SESSION['movie']);
    foreach ($characters as $char) {
        if (in_array(($char == " "), str_split($_SESSION['Characters_used']))) {
            echo "&nbsp&nbsp&nbsp";
        } else
            echo "_ ";
    }
}

function checkLetter($letter, $movie)
{
    return stripos($movie, $letter) !== false;
}

function displayGameStatus()
{

    $characters = str_split($_SESSION['movie']);
    $characters_used = str_split($_SESSION['Characters_used']);
    foreach ($characters as $char) {
        if (in_array(($char == " "), str_split($_SESSION['Characters_used']))) {
            echo "&nbsp&nbsp&nbsp";
        } else if (in_array(strtolower($char), str_split($_SESSION['Characters_used']))) {
            echo $char . " ";
        } else {
            echo "_ ";
        }
    }
    echo "<br>";
    echo "Letras usadas: " . $_SESSION['Characters_used'] . "<br>"; // Show guessed letters
    echo "Vidas restantes: " . $_SESSION['Lifes'] . "<br>";
}

function letraEnPeli()
{
    if (isset($_POST['letter'])) {

        $letter = strtolower($_POST['letter']);
        $_SESSION['Characters_used'] .= " ";
        //crear array nuevo


        if (checkLetter($letter, $_SESSION['Characters_used'])) {
            echo "Ya has usado esta letra.<br>";
        } else if (checkLetter($letter, $_SESSION['movie'])) {
            echo "¡Buena elección! La letra '$letter' está en la película.<br>";
            $_SESSION['Characters_used'] .= $letter;
        } else {
            echo "La letra '$letter' no está en la película. Pierdes una vida.<br>";
            $_SESSION['Lifes']--;
            $_SESSION['Characters_used'] .= $letter;
        }
    }
}

function peliCompletada()
{
    $completed = true;
    foreach (str_split($_SESSION['movie']) as $char) {
        if (!in_array(strtolower($char), str_split($_SESSION['Characters_used']))) {
            $completed = false;
            break;
        }
    }
    if ($completed) {
        echo "¡Felicidades! Has adivinado la película: ";
        $_SESSION['Done'] = 1;
    }
}

function isGameOver()
{
    return $_SESSION['Lifes'] === 1 || $_SESSION['Done'] === 1;
}

//reiniciar partida


?>
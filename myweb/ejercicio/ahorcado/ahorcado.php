<?php
session_start();

if (isset($_POST['test'])) {
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

initGame();

if (!isGameOver()) {
    
    letraEnPeli();
    peliCompletada();
    displayGameStatus();
    input();
    btnReset();

} else {
    hasPerdido();
    btnReset();
}

echo "</body>
      </html>";


//funciones
function initGame(){

    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Juego del ahorcado</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f0f0f0;
                text-align: center;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            form {
                margin-top: 20px;
            }
            button {
                padding: 10px 20px;
                background-color: #4caf50;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            button:hover {
                background-color: #45a049;
            }
            input[type='text'] {
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ccc;
            }
            input[type='submit'] {
                padding: 10px 20px;
                background-color: #007bff;
                color: #fff;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            input[type='submit']:hover {
                background-color: #0056b3;
            }
        </style>";
 
    DEFINE('HOST', "gbd_mysql_A");
    DEFINE('DBNAME', 'ahorcado');
    DEFINE('USERNAME', 'root');
    DEFINE('PASS', '');
    DEFINE('QUERY', 'SELECT titulo FROM pelicula ORDER BY RAND() LIMIT 1');

   
    if (!isset($_SESSION['Lifes'])) {
        $_SESSION['Done'] = 0; 
        $_SESSION['Lifes'] = 6;
        $_SESSION['Characters_used'] = ''; 
        
        $_SESSION['Conn'] = mysqli_connect(HOST, USERNAME, PASS, DBNAME);

        if (!isset($_SESSION['movie'])) {
            $table = mysqli_query($_SESSION['Conn'], QUERY);
            $row = mysqli_fetch_assoc($table);
            $_SESSION['movie'] = $row['titulo'];
        }

    }
}

function checkLetter($letter, $movie){
    return stripos($movie, $letter) !== false;
}

function displayGameStatus(){

    $characters = str_split($_SESSION['movie']);
    
    foreach ($characters as $char) {
        if ($char == " ") {
            echo "&nbsp;&nbsp;&nbsp;"; // Mostrar espacio en blanco
        } else if (in_array(strtolower($char), str_split($_SESSION['Characters_used']))) {
            echo $char . " ";
        } else {
            echo "<strong>_ ";
        }
    }
    echo "<br>";
    echo "<strong>Letras usadas: " . $_SESSION['Characters_used'] . "<br>";
    echo "<strong>Vidas restantes: " . $_SESSION['Lifes'] . "<br>"; 
}


function letraEnPeli(){
    if (isset($_POST['letter'])) {

        $letter = strtolower($_POST['letter']);
        $_SESSION['Characters_used'] .= " ";
   
        if (checkLetter($letter, $_SESSION['Characters_used'])) {
            echo "<strong>Ya has usado la letra '$letter'<br>";
        } else if (checkLetter($letter, $_SESSION['movie'])) {
            echo "<strong> La letra '$letter' está en la película.<br>";
            $_SESSION['Characters_used'] .= $letter;
        } else {
            echo "<strong>La letra '$letter' no está en la película.<br>";
            $_SESSION['Lifes']--;
            $_SESSION['Characters_used'] .= $letter;
        }
    }
}

function peliCompletada(){

    $completed = true;
    foreach (str_split($_SESSION['movie']) as $char) {
        if (!in_array(strtolower($char), str_split($_SESSION['Characters_used']))) {
            $completed = false;
            break;
        }
    }
    if ($completed) {
        echo "<h1><strong>Enhorabuena!!!</h1><br> La película era : ";
        $_SESSION['Done'] = 1;
    }
}

function isGameOver(){
    return $_SESSION['Lifes'] === 1 || $_SESSION['Done'] === 1;
}

function input(){
    echo '<form method="post" action="">
    Introduce una letra: <input type="text" name="letter" maxlength="1" pattern="[a-zA-Z]" required>
    <input type="submit" value="Enviar">
    </form>';
}

function btnReset(){
    echo '<form method="post">
    <button name="test">Reiniciar partida</button>
    </form>';

    muestraImagen();
}

function hasPerdido(){
    echo "<h1>¡Has perdido!</h1> <br>
      <h3>La película era: " . $_SESSION['movie'] . "</h3><br>";
    $_SESSION['Lifes'] = 0;
}

function muestraImagen(){
    if($_SESSION['Lifes'] < 6){

        echo '<img style="width:300px;height:300px;object-fit:contain;margin-top:25px" src="./img/ahorcado' .  $_SESSION['Lifes'] +1 . '.png">';
    }
}
?>
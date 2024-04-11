<?php
session_start();
// Datos de conexión a la base de datos
$servername = "gbd_mysql_A"; // El nombre del servidor para Docker es el nombre del contenedor
$username = "root"; // El usuario por defecto es "root"
$password = ""; // La contraseña que estableciste al ejecutar el contenedor
$database = "ahorcado"; // El nombre de la base de datos que creaste

// Crear conexión
if (!isset($_SESSION['titulo'])) {
    $conn = new mysqli($servername, $username, $password, $database);
    $query = "select titulo from pelicula order by rand() limit 1";
    $table = mysqli_query($conn, $query);

    // Captura de la película recuperada de la BD
    foreach ($table as $row) {
        foreach ($row as $_SESSION['titulo']) {
            echo $_SESSION['titulo']; // Remove esta línea después de verificar
        }
    }
}

echo $_SESSION['titulo'];
ocultarTitulo($_SESSION['titulo']);
if (isset($_GET["letra"])) {
    revelarLetra($_GET['letra']);
}

function ocultarTitulo($pelicula){
    $_SESSION['peliculaOculta'] = "";
    for ($i = 0; $i < strlen($pelicula); $i++){
        if($pelicula[$i] == " "){
            $_SESSION["peliculaOculta"] .= "&nbsp;"; // Agregar espacios en blanco para los espacios en el título
        } else {
            $_SESSION["peliculaOculta"] .= "_ "; // Agregar guiones bajos para ocultar las letras
        }
    }
    echo $_SESSION['peliculaOculta'];
}

function revelarLetra($letra) {
    // Convertimos ambas cadenas a minúsculas para comparar sin distinción entre mayúsculas y minúsculas
    $titulo = strtolower($_SESSION['titulo']);
    $letra = strtolower($letra);
    
    // Inicializamos la versión oculta del título si aún no está definida
    if (!isset($_SESSION['peliculaOculta'])) {
        ocultarTitulo($_SESSION['titulo']);
    }

    // Obtenemos la versión oculta del título
    $peliculaOculta = $_SESSION['peliculaOculta'];

    // Creamos una bandera para indicar si la letra se encontró en el título
    $letraEncontrada = false;

    // Recorremos cada letra del título
    for ($i = 0; $i < strlen($titulo); $i++) {
        // Si la letra ingresada coincide con alguna letra del título y la letra no está revelada aún
        if ($letra === $titulo[$i] && $peliculaOculta[2 * $i] === "_") {
            // Mostramos la letra en la versión oculta del título
            $peliculaOculta[2 * $i] = $letra; // Multiplicamos por 2 para tener en cuenta los espacios entre letras
            $letraEncontrada = true;
        }
    }

    // Si la letra no se encontró en el título, restamos una vida al usuario
    if (!$letraEncontrada) {
        $_SESSION['vidas'] = isset($_SESSION['vidas']) ? $_SESSION['vidas'] - 1 : 5; // Restamos una vida si la variable ya está inicializada, de lo contrario la establecemos en 5
    }

    // Actualizamos la versión oculta del título en la sesión
    $_SESSION['peliculaOculta'] = $peliculaOculta;

    // Mostramos la versión oculta del título actualizada
    echo $peliculaOculta;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="ahorcado.php" method="get">
        <input type="text" placeholder="Dime una letra" name="letra">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>

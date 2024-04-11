<?php
session_start();

// Datos de conexión a la base de datos
$servername = "gbd_mysql_A"; // El nombre del servidor para Docker es el nombre del contenedor
$username = "root"; // El usuario por defecto es "root"
$password = ""; // La contraseña que estableciste al ejecutar el contenedor
$database = "ahorcado"; // El nombre de la base de datos que creaste

// Verificar si se ha hecho clic en el enlace "Nueva película"
if (isset($_GET['nueva_pelicula'])) {
    unset($_SESSION['titulo']); // Eliminar la variable de sesión para que se seleccione una nueva película
    header('Location: ' . $_SERVER['PHP_SELF']); // Redireccionar para cargar la página nuevamente
    exit;
}

// Verificar si la variable de sesión ya está establecida
if (!isset($_SESSION['titulo'])) {
    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $database);


    $query = "SELECT titulo FROM pelicula ORDER BY RAND() LIMIT 1";
    $result = mysqli_query($conn, $query);

    // Obtener el resultado de la consulta y almacenarlo en la sesión
    $row = mysqli_fetch_assoc($result);
    $_SESSION['titulo'] = $row['titulo'];

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

}

Hide_film($_SESSION['titulo']);

function Hide_film($film){
    $Hide_Film = '';
    for ($i = 0; $i < strlen($film); $i++) {
        if ($film[$i] <> ' ') {
            $Hide_Film = $Hide_Film . " _ ";
        } else {
            $Hide_Film = $Hide_Film . "&nbsp" . "&nbsp" . "&nbsp";
        }
    }
    return $Hide_Film;
}
// Mostrar el título de la película almacenada en la sesión
echo $_SESSION['titulo'];
?>

<!-- Enlace para seleccionar una nueva película -->
<a href="?nueva_pelicula=1">Seleccionar nueva película</a>
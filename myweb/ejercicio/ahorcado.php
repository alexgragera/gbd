<?php
// Datos de conexión a la base de datos
$servername = "gbd_mysql_A"; // El nombre del servidor para Docker es el nombre del contenedor
$username = "root"; // El usuario por defecto es "root"
$password = ""; // La contraseña que estableciste al ejecutar el contenedor
$database = "ahorcado"; // El nombre de la base de datos que creaste

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    //echo "Conexión exitosa";
}

if(isset ($_GET["letra"])){
echo $_GET["letra"];
}


// Si has terminado de trabajar con la conexión, ciérrala
$conn->close();
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



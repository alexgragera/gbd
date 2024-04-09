<?php
session_start();

// Inicializar la variable de sesión 'frase' si no existe
if (!isset($_SESSION['frase'])) {
    $_SESSION['frase'] = '';
}

// Procesar la entrada del formulario
if(isset($_POST["letras"])) {
    // Agregar la nueva palabra a la frase existente
    $_SESSION['frase'] .= $_POST["letras"] . ' '; // Agregamos un espacio entre palabras
}

// Procesar la solicitud para borrar la variable de sesión
if(isset($_POST["borrar"])) {
    // Borra la variable de sesión 'frase'
    unset($_SESSION['frase']);
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
    <form method="POST">
        <input type="text" name="letras">
        <button type="submit">Imprimir</button>
        <!-- Agregar un botón para borrar la variable de sesión -->
        <input type="submit" name="borrar" value="Borrar Frase">
    </form>

    <?php
    // Mostrar la frase completa
     if(isset($_SESSION['frase'])){
        echo "<p>{$_SESSION['frase']}</p>";
    }
    ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
</head>
<body>
    
</body>
</html>

<?php
    $conn = new mysqli("gbd_mysql_A","root", "","gbd");

    if ($conn->connect_error) {
        echo "La conexion no va";
    }

    $query = 'SELECT employee_id,first_name,last_name
                FROM employees;';
    $resultado = mysqli_query( $conn, $query );
    
    
    echo "<table> 
                <tr>
                    <th>Employee Id</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Longitud</th>
                </tr>";

    foreach($resultado as $row){
        $nombre = "$row[first_name]" . "$row[last_name]";
        $letras = 0;
        for ($i = 0 ; $i < strlen($nombre); $i++){
            if ($nombre[$i] != " "){
                $letras++;
            }
        }

        echo "<tr>
                   <td> $row[employee_id]</td>
                   <td> $row[first_name]</td>
                   <td> $row[last_name]</td>
                   <td> $letras</td>
                </tr>";
    }
    echo "</table>";
?>


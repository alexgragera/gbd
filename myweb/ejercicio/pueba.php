<?php
DEFINE('HOST', "gbd_mysql_A");
DEFINE('DBNAME','ahorcado');
DEFINE('USERNAME', 'root');
DEFINE('PASS', '');
DEFINE('QUERY', 'select titulo from pelicula order by rand() limit 1');

//Session Variables
$_SESSION['FilmnotDone'] = false; #Used to check if the film has been completed
$_SESSION['Lifes'] = 6; #Number of lives
$_SESSION['Letters_used'] = null; #Character used to discover the film
$_SESSION['Conn'] = mysqli_connect(HOST,USERNAME,PASS,DBNAME);
$table = mysqli_query($_SESSION['Conn'],QUERY);




//Catching the film retrieved by the DB
foreach ($table as $row){
    foreach ($row as $_SESSION['Film']){
        echo $_SESSION['Film']; //remove this line after checks
    }
}

?>
<?php
// Start the session always at the beginning
session_start();
#echo var_dump($_SESSION);

//HTML code below
echo "<!DOCTYPE html>
	  <html>
	  <body>";
//End HTML code

//Insert your code below here to set the initial values
//Constants
DEFINE('HOST', "gbd_mysql_A");
DEFINE('DBNAME', 'ahorcado');
DEFINE('USERNAME', 'root');
DEFINE('PASS', '');
DEFINE('QUERY', 'select titulo from pelicula order by rand() limit 1');

//Session Variables
$_SESSION['Done'] = 1; #Check if the filme has been completed: 0 no, 1 yes
$_SESSION['Lifes'] = 6; #Number of lives
$_SESSION['Characters_used'] = ''; #Character used to discover the film
$_SESSION['Conn'] = mysqli_connect(HOST, USERNAME, PASS, DBNAME);
$table = mysqli_query($_SESSION['Conn'], QUERY);

//Catching the film retrieved by the DB
foreach ($table as $row) {
	foreach ($row as $_SESSION['Film']) {
		//echo $_SESSION['Film'];   //remove this line after checks
	}
}

//Hidden the film
$_SESSION['Hidden_film'] = Hide_Film($_SESSION['Film']);
echo "<br>";
echo $_SESSION['Hidden_film'];

//********* end of definition of initial values ***********

while (Still_Alive()) {
	$Char = Input_Char();
	echo "<br>";
	echo $Char;
}



/*
// remove all session variables
session_unset();

// destroy the session
session_destroy();
*/

//**********************************//
//     Definition of Functions      //
//**********************************//

//Function to check if the user has lifes
function Still_Alive()
{
	if ($_SESSION['Lifes'] > 0) {
		return true;
	} else {
		return false;
	}
}

//Function to check if the film is done
function Is_Done()
{
	return false;
}

//Function to Hide the film
function Hide_film($film)
{
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

function Input_Char()
{
	echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">
    Name: <input type="text" name="fname">
    <input type="submit">
    </form>';

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = htmlspecialchars($_POST['fname']);
		if (empty($name)) {
			echo "Please enter a Char";
		} else {
			echo $name;
		}
		return $name;
	}
}

// Otro código ...


?>
Ahorcado.php
El tauler de detalls s'ha reduït.
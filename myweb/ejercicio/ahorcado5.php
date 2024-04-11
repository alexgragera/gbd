<?php
// Start the session always at the begining
	session_start();
	
//HTML code below
echo "<!DOCTYPE html>
     <html>
	<body>";
//End HTML code
	
/***********************************/
/******* Main program **************/
/***********************************/

//Checking if the game is starting	
if (!isset($_SESSION['Film'])){
	Init_Game();  #Variables must be set for first time
}

//The game start
if (Still_Alive() == true & FilmnotDone() == true){
	echo $_SESSION['Film'];  #Remove after checks.
	$Char = Input_Letter(); #Ask for the letter.
	Add_Letter($Char); #Add the letter to letters used
	Show_Letters_Used(); #Show the letter used
	if (null != ($pos=Letter_in_Film($Char, $_SESSION['Film']))){
		 Show_Letter($pos, $Char);
	}else{
		Substract_Life(); #Substract one life when user fails
#		Show_Lifes(); #To Be Defined -> function that show the lifes remaining
	}
}else if (Still_Alive() == false){
#	No lifes left -> show message showing that user has lost, clear variables and exit
}else{
#	Film was completed with existing lifes -> show message showing that user win an exit
}
?>

<?php
/******* End Main program **********/


//**********************************//
//     Definition of Functions      //
//**********************************//

function Show_Letters_Used(){
	echo "<br><br>";
	echo $_SESSION['Letters_used'];
}

function Add_Letter($Char){
	$_SESSION['Letters_used'] = $_SESSION['Letters_used'] . $Char;
}

function Substract_Life(){
	$_SESSION['Lifes'];
}

function Show_Letter($pos, $Letter){
	for ($i=0;$i<count($pos);$i++){
		$_SESSION['Hidden_Film'][$pos[$i]] = $Letter;
	}
	echo "<br><br>";
#	print_r($_SESSION['Hidden_Film']);
#	echo implode( $_SESSION['Hidden_Film'] );
#   var_dump($_SESSION['Hidden_Film']);
}

//Function to check if letter is into the Film
//Return the posicion of the Letter, '' otherwise
function Letter_in_Film($Letter, $Film){
	$pos=[];
	$aux=0;
	for ($i=0;$i<strlen($Film) ;$i++){ 
		if ($Letter == $Film[$i]){
			$pos[$aux] = $i;
			$aux++;
		}		
	}
	return $pos;
} #Letter_in_Film

//Function to check if the user has lifes
function Still_Alive(){
	if ($_SESSION['Lifes'] > 0){
	  return true; 	
	}else {
	  return false;
	}
} #Still_Alive

//Function to check if the film is done
function FilmnotDone(){
	if ($_SESSION['Num_letters'] > 0){
	  return true; 	
	}else {
	  return false;
	}
} #FilmnotDone

//Function to Hide the film
function Hide_Film($film){
	$Hide_Film = null;
	for ($i=0;$i<strlen($film) ;$i++){
		if ($film[$i] <> ' '){
		$Hide_Film = $Hide_Film . "_";
		}else{
			$Hide_Film = $Hide_Film . "&nbsp";
		}
	}
	echo "<br>";
	echo "Peli oculta";
	echo "<br>";
	echo $Hide_Film;
	echo "<br><br><br><br><br>";
	return $Hide_Film;
} #Hide_Film

function Input_Letter(){
	?>
	<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
    Name: <input type="text" name="fname">
    <input type="submit">
    </form>
	
	<?php
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
       $name = htmlspecialchars($_REQUEST['fname']);
	   if (empty($name)) {
		echo "Please enter a letter";
	   }else{
	   return $name;
	   }
	}
} #Input_Letter

function Init_Game(){
	//Set the initial values
	//Constants
	DEFINE('HOST', "gbd_mysql_A");
	DEFINE('DBNAME','Peliculas');
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
#			echo $_SESSION['Film']; //remove this line after checks
		}
	}

	//Hidden the film
	$_SESSION['Hidden_Film'] = Hide_Film($_SESSION['Film']);
	$_SESSION['Init'] = False;
	
	//Counting the number of letter of the film
	$_SESSION['Num_letters'] = 0;
	for ($i=0; $i<strlen($_SESSION['Film']); $i++){
		if ($_SESSION['Film'][$i] <> ' '){
			$_SESSION['Num_letters']++;
		}
	}

	//********* end of definition of initial values ***********
} #Init_Game

function End_game(){
	// remove all session variables
	session_unset();
	// destroy the session
	session_destroy();
} #End_Game

?>
Ahorcado.php
Ahorcado.php s'està mostrant.
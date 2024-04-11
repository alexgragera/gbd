<?php
// Start the session always at the beginning
session_start();

//Constants
define('HOST', "gbd_mysql_A");
define('DBNAME', 'ahorcado');
define('USERNAME', 'root');
define('PASS', '');
define('QUERY', 'select titulo from pelicula order by rand() limit 1');

//Session Variables
if (!isset($_SESSION['Done'])) {
    $_SESSION['Done'] = 0; // Check if the film has been completed: 0 no, 1 yes
}
if (!isset($_SESSION['Lifes'])) {
    $_SESSION['Lifes'] = 6; // Number of lives
}
if (!isset($_SESSION['Characters_used'])) {
    $_SESSION['Characters_used'] = ''; // Characters used to discover the film
}
if (!isset($_SESSION['Conn'])) {
    $_SESSION['Conn'] = mysqli_connect(HOST, USERNAME, PASS, DBNAME);
}

//Catching the film retrieved by the DB
if ($_SESSION['Done'] == 0 || !isset($_SESSION['Film'])) {
    $table = mysqli_query($_SESSION['Conn'], QUERY);
    foreach ($table as $row) {
        foreach ($row as $_SESSION['Film']) {
            //echo $_SESSION['Film']; //remove this line after checks
        }
    }
}

//Hidden the film
if (!isset($_SESSION['Hidden_film'])) {
    $_SESSION['Hidden_film'] = Hide_film($_SESSION['Film']);
}

//********* end of definition of initial values ***********

// Verifying if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Char = Input_Char();

    // Verifying if the input is valid
    if ($Char === false) {
        echo "Please enter a letter.";
    } elseif ($Char === null) {
        echo "Please enter a single valid letter.";
    } else {
        // Checking if the letter was already used
        if (strpos($_SESSION['Characters_used'], $Char) !== false) {
            echo "The letter '$Char' has already been used. Try another one.";
        } else {
            // Adding the letter to the used characters
            $_SESSION['Characters_used'] .= $Char;

            // Checking if the letter is in the film title
            if (strpos($_SESSION['Film'], $Char) !== false) {
                // Updating the game progress with the correct letter
                $_SESSION['Hidden_film'] = Update_Hidden_Film($_SESSION['Film'], $_SESSION['Hidden_film'], $Char);
                echo "Well done! The letter '$Char' is in the word.";
            } else {
                // Reducing the number of lives
                $_SESSION['Lifes']--;
                echo "The letter '$Char' is not in the word. You lost a life.";
            }
        }
    }
}

// Showing the current game status
echo $_SESSION['Hidden_film'] . "<br>";
echo "Lives: " . $_SESSION['Lifes'] . "<br>";

// Checking if the game is over
if ($_SESSION['Lifes'] <= 0) {
    echo "Oh no! You ran out of lives. The word was: " . $_SESSION['Film'];
    $_SESSION['Done'] = 1;
} elseif (Is_Done()) {
    echo "Congratulations! You guessed the word correctly.";
    $_SESSION['Done'] = 1;
} else {
    // Displaying the input form
    echo '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">
        Name: <input type="text" name="fname">
        <input type="submit" value="Submit">
        </form>';
}

//**********************************//
//     Definition of Functions      //
//**********************************//

//Function to check if the user has lives
function Is_Done()
{
    // If there are no hidden letters left in the word, the game is over
    return (strpos($_SESSION['Hidden_film'], '_') === false);
}

//Function to Hide the film
function Hide_film($film)
{
    $Hide_Film = '';
    foreach (str_split($film) as $char) {
        if ($char != ' ') {
            $Hide_Film .= "_ ";
        } else {
            $Hide_Film .= "&nbsp;&nbsp;&nbsp;";
        }
    }
    return $Hide_Film;
}



function Input_Char()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : '';
        if (empty($name)) {
            return false; // Return false if no letter was entered
        } elseif (strlen($name) !== 1 || !ctype_alpha($name)) {
            return null; // Return null if more than one letter or non-alphabetic characters were entered
        } else {
            return $name; // Return the entered letter
        }
    }
    return '';
}

function Update_Hidden_Film($film, $hidden_film, $char)
{
    $updated_hidden_film = '';
    for ($i = 0; $i < strlen($film); $i++) {
        if ($film[$i] == $char) {
            $updated_hidden_film .= $char . ' ';
        } else {
            $updated_hidden_film .= $hidden_film[$i * 2] == '_' ? '_ ' : $hidden_film[$i * 2] . ' ';
        }
    }
    return $updated_hidden_film;
}
?>

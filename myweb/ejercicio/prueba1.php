<html>
<body>

<form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
  
  Valor de X: <input type="text" name="X">
  <br>
  Valor de Y: <input type="text" name="Y">
  <input type="submit">
 
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $X = htmlspecialchars($_REQUEST['X']);
  $Y = htmlspecialchars($_REQUEST['Y']);
  if ($X > $Y){
      echo "$X es mayor que $Y";
  }elseif ($X < $Y){
      echo "$X es menor que $Y";
  } else {
      echo "$X es igual a $Y";
  }
 
}

?>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="letras">
        <button type="submit">Imprimir</button>
    </form>
</body>
</html>

<?php
/* 3.- Create an "echo" program. Design a screen where user introduces a word in a cell and after the user press de button "Send", the word is showed in the screen. */
if(isset ($_POST["letras"])){
    echo $_POST["letras"];
    }else{
    echo " ";
}
?>
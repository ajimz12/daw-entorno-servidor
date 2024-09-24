<?php

$servername = "localhost";
$database = "prueba";
$username = "root";

$conn = mysqli_connect($servername, $username, '', $database);

session_start();

    if (!isset($_SESSION["number"])) {
        $_SESSION['number'] = 0;
    }

    if (isset($_GET['sum'])) {
        $_SESSION['number'] += $_GET['sum'];

        header('location: ejercicio.php');
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <a href="?sumar=1">Sumar</a>&nbsp;
    <a href="?login=2">Login</a>

    <p>
        <?php
        echo $_SESSION['number'];
        ?>
    </p>

    <a href="?sum=2">+2</a>&nbsp;
    <a href="?sum=3">+3</a>

</body>

</html>
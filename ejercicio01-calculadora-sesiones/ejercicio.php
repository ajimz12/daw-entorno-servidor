<?php

$hostname = "localhost";
$database = "prueba";
$username = "root";

$db = new mysqli($hostname, $username, "", $database);

session_start();

if (!isset($_SESSION["number"])) {
    $_SESSION['number'] = 0;
}

if (isset($_GET['op'])) {

    if ($_GET['op'] == 'Sumar')
        $_SESSION['number'] += $_GET['number'];
    else if ($_GET['op'] == "Restar")
        $_SESSION['number'] -= intval($_GET['number']);
    else if ($_GET['op'] == "Multiplicar")
        $_SESSION['number'] *= intval($_GET['number']);
    else if ($_GET['op'] == "Dividir")
        $_SESSION['number'] /= intval($_GET['number']);

    if (isset($_SESSION['username'])) {
        $stmt = $db->prepare(query: "UPDATE users SET number = ? WHERE user_id = ?");
        $stmt->bind_param("ii", $_SESSION["number"], $_SESSION["user_id"]);
        $stmt->execute();
    }

    header(header: 'location: ejercicio.php');
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT user_id, password, number FROM users WHERE username = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['password'] == md5($_POST['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['number'] = $row['number'];
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ejercicio.php');
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

    <nav>
        <a href="?action=sum">Operación</a>&nbsp;
        <a href="?action=login">Login</a>
    </nav>

    <hr>

    <div>
        <?php

        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = "sum";
        }

        if ($action == "sum") {
            echo "<p><b>Operación</b></p>";
            echo "<p>" . $_SESSION['number'] . "</p>";
        ?>

            <form action="ejercicio.php" method="GET">
                <input type="number" name="number" placeholder="Numero" required><br><br>

                <input type="submit" name="op" value="Sumar">
                <input type="submit" name="op" value="Restar">
                <input type="submit" name="op" value="Multiplicar">
                <input type="submit" name="op" value="Dividir">

            </form>

            <?php
        }

        if ($action == "login") {
            if (isset($_SESSION['username'])) {
                echo "<p>Bienvenido, " . $_SESSION['username'] . "</p>";
                echo '<a href="?logout">Cerrar sesión</a>';
            } else {
            ?>
                <p><b>Iniciar sesión</b></p>
                <form action="?action=login" method="POST">
                    <label for="username">Usuario:</label>
                    <input type="text" name="username" required><br><br>

                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" required><br><br>

                    <input type="submit" name="login" value="Iniciar sesión">
                </form>
        <?php

            }
        }
        ?>
    </div>

</body>

</html>
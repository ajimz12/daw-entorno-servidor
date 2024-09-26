<?php

$hostname = "localhost";
$database = "prueba";
$user = "root";

$db = new mysqli($hostname, $user, "", $database);

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ejercicio.php');
}

if (isset($_POST['register'])) {

    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['repeatPassword']) && $_POST['repeatPassword'] == $_POST['password']) {
        $query = "SELECT * FROM users WHERE username = '" . $_POST['username'] . "'";

        $result = $db->query($query);
        if (!$result->num_rows) {
            $query = "INSERT INTO users VALUES (null, '" . $_POST['username'] . "', MD5('" . $_POST['password'] . "'))";
            $result = $db->query($query);

            if ($result) {
                echo "<p>Usuario registrado con éxito.</p>";
            } else {
                echo "<p>Error al registrar el usuario.</p>";
            }
        } else {
            echo "<p>El nombre de usuario ya existe.</p>";
        }
    } else {
        echo "<p>Las contraseñas no coinciden.</p>";
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $queryUser = "SELECT user_id, password FROM users WHERE username = ?";

    $stmtUser = $db->prepare($queryUser);
    $stmtUser->bind_param('s', $username);
    $stmtUser->execute();
    $result = $stmtUser->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['password'] == md5($_POST['password'])) {
            $_SESSION['username'] = $username;
        }
    }
}

$query = "SELECT * FROM peliculas";

if (isset($_POST['saveMovie'])) {
    if (isset($_POST['title']) && isset($_POST['director']) && isset($_POST['date']) && isset($_POST['cartel'])) {
        $q = "INSERT INTO peliculas VALUES (null, '" . $_POST['title'] . "','" . $_POST['date'] . "','" . $_POST['director'] . "','" . $_POST['cartel'] . "')";
        $db->query($q);
    }
}

if (isset($_GET['deleteMovie']) ) {
    $queryDelete = "DELETE FROM peliculas WHERE id = " . $_GET['id'];
    $db->query($queryDelete);
}

$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_SESSION['username'])) {

    echo "<p>Bienvenido, " . $_SESSION['username'] . "</p>";

    echo '<a href="?addMovie=1">Subir pelicula</a><br/><br>';

    if (isset($_GET['addMovie'])) {

?>
        <p><b>Subir pelicula</b></p>
        <form action="ejercicio.php" method="POST">
            <label for="title">Titulo:</label>
            <input type="text" name="title" required><br><br>

            <label for="date">Fecha:</label>
            <input type="date" name="date" required><br><br>

            <label for="director">Director:</label>
            <input type="text" name="director" required><br><br>

            <label for="cartel">Cartel:</label>
            <input type="text" name="cartel" required><br><br>

            <input type="submit" name="saveMovie" value="Subir Pelicula">
            <a href="ejercicio.php">Volver</a>
        </form>

    <?php
    }

    while ($row = $result->fetch_assoc()) {
        $cartel = "./img/" . $row['cartel'];

        echo $row['titulo'] . " <br> " . $row['fecha'] . " <br> " . $row['director'] . "<br>";
        echo "<img src='" . $cartel . "' alt='" . $row['titulo'] . "' width='200' height='300'><br><br>";
        echo '<a href="ejercicio.php?deleteMovie=1&id=' . $row['id'] . '">Borrar Pelicula</a><br><br>';
    }

    echo '<a href="?logout=1">Cerrar sesión</a>';
} else if (isset($_GET['register'])) {

    ?>
    <p><b>Registro</b></p>

    <form action="ejercicio.php" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <label for="repeatPassword">Repite tu contraseña:</label>
        <input type="password" name="repeatPassword" required><br><br>

        <input type="submit" name="register" value="Registrarse">
    </form>

<?php
    echo '<a href="ejercicio.php">Volver</a>';
} else {
?>
    <p><b>Iniciar sesión</b></p>

    <form action="ejercicio.php" method="POST">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" name="login" value="Iniciar sesión">
    </form>

    <a href="?register=1">Registrarse</a>
<?php

}

?>
<?php

$hostname = "localhost";
$database = "blog";
$user = "root";

$db = new mysqli($hostname, $user, "", $database);

session_start();

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

    $query = "SELECT id_user, password FROM users WHERE username = '" . $_POST['username'] . "'";
    $result = $db->query($query);

    if ($row = $result->fetch_assoc()) {
        if ($row['password'] == md5($_POST['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['id_user'] = $row['id_user'];
        }
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: blog.php');
}

function showArticles($db)
{
    $query = "SELECT id_article, title, text, image, id_user, date FROM articles";
    $result = $db->query($query);
    $articles = array();

    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }
    return $articles;
}

if (isset($_POST['saveArticle'])) {
    if (isset($_POST['title']) && isset($_POST['text']) && isset($_SESSION['id_user'])) {

        $imageName = "";
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $imageName = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "./img/" . $imageName);
        }

        $userId = $_SESSION['id_user'];

        $date = "NOW()";

        $q = "INSERT INTO articles (title, text, date, image, id_user) 
              VALUES ('" . $_POST['title'] . "','" . $_POST['text'] . "','" . $date . "','" . $imageName . "', '" . $userId . "')";

        if ($db->query($q)) {
            echo "Artículo guardado con éxito";
        } else {
            echo "Error al guardar el artículo: " . $db->error;
        }
    }
}

if (isset($_GET['deleteArticle'])) {
    $query = "DELETE FROM articles WHERE id_article = " . $_GET['deleteArticle'];
    $db->query($query);
}

?>

<html>
<style>
    form,
    body {
        text-align: center;
    }
</style>

<body>

    <?php
    if (isset($_SESSION['username'])) {

        echo "<p>Bienvenido, " . $_SESSION['username'] . "</p>";
        echo '<a href="?logout=1">Cerrar sesión</a>';

        echo '<h1><b>Blog</b></h1><br>';
        echo '<a href="?addArticle=1">Añadir artículo</a><br><br>';

        if (isset($_GET['addArticle'])) {
    ?>
            <form action="blog.php" method="POST" enctype="multipart/form-data">
                <label for="title">Titulo:</label>
                <input type="text" name="title" required><br><br>

                <label for="text">Texto:</label>
                <textarea name="textarea" required></textarea><br><br>

                <label for="image">Imagen:</label>
                <input type="file" accept="image/*" name="image"><br><br>

                <input type="submit" name="saveArticle" value="Subir Articulo">
                <a href="blog.php">Volver</a>
            </form>
        <?php
        }

        $articles = showArticles($db);

        foreach ($articles as $article) {
            $imagen = "./img/" . $article['image'];
            echo '<h2>' . $article['title'] . '</h2>';
            echo '<p>' . $article['text'] . '</p>';
            echo "<img src='" . $imagen . "' alt='" . $article['title'] . "' width='300' height='300'><br><br>";
            echo '<p>Fecha: ' . $article['date'] . '</p>';
            echo '<p>ID Usuario: ' . $article['id_user'] . '</p>';
        }
        
    } else if (isset($_GET['register'])) {
        ?>
        <h2><b>Registro</b></h2><br>

        <form action="blog.php" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" name="username" required><br><br>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required><br><br>

            <label for="repeatPassword">Repite tu contraseña:</label>
            <input type="password" name="repeatPassword" required><br><br>

            <input type="submit" name="register" value="Registrarse">
        </form>

        <a href="blog.php">Volver</a>
    <?php
    } else {
    ?>
        <h2><b>Iniciar sesión</b></h2><br>

        <form action="blog.php" method="POST">
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
</body>

</html>
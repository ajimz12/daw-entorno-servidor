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
    $articles = [];
    $query = "SELECT * FROM articles JOIN users ON articles.id_user = users.id_user";
    $result = $db->query($query);

    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }

    foreach ($articles as $article) {
        if ($article['visible'] || $article['id_user'] == $_SESSION['id_user']) {

            $image = "./img/" . $article['image'];
            echo '<h2><a href="?showUniqueArticle=' . $article['id_article'] . '">' . $article['title'] . '</a></h2>';
            echo '<p>' . $article['text'] . '</p>';
            echo "<img src='" . $image . "' alt='" . $article['title'] . "' width='300' height='300'><br><br>";
            echo '<p>Fecha: ' . $article['date'] . '</p>';
            echo '<p>Autor: ' . $article['username'] . '</p>';
            echo "<p><b>Comentarios</b></p>";
            showComments($db, $article['id_article']);

?>
            <form action="blog.php?id_article=<?php echo $article['id_article']; ?>" method="POST" enctype="multipart/form-data">
                <input type="text" name="comment" placeholder="Escribir comentario..." required><br><br>
                <input type="submit" name="saveComment" value="Subir Comentario">
            </form>

<?php

            if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == $article['id_user']) {
                echo '<a href="?deleteArticle=' . $article['id_article'] . '">Eliminar</a>&nbsp;';
                if ($article['visible']) {
                    echo '<a href="?hideArticle=' . $article['id_article'] . '">Ocultar</a>';
                } else {
                    echo '<a href="?showArticle=' . $article['id_article'] . '">Mostrar</a>';
                }
            }
        }
    }
}


function showUniqueArticle($db, $idArticle)
{
    $query = "SELECT * FROM articles WHERE id_article = " . $idArticle;
    $result = $db->query($query);

    // $image = "./img/" . $article['image'];
    //         echo '<h2><a href="?showUniqueArticle=' . $article['id_article'] . '">' . $article['title'] . '</a></h2>';
    //         echo '<p>' . $article['text'] . '</p>';
    //         echo "<img src='" . $image . "' alt='" . $article['title'] . "' width='300' height='300'><br><br>";
    //         echo '<p>Fecha: ' . $article['date'] . '</p>';
    //         echo '<p>Autor: ' . $article['username'] . '</p>';
    //         echo "<p><b>Comentarios</b></p>";
    //         showComments($db, $article['id_article']);

}

function showComments($db, $idArticle)
{
    $comments = [];
    $query = "SELECT * FROM comments JOIN articles ON comments.id_article = articles.id_article JOIN users ON comments.id_user = users.id_user WHERE comments.id_article = " . $idArticle . "";
    $result = $db->query($query);

    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }

    foreach ($comments as $comment) {
        echo '<p>' . $comment['comment'] . '</p>';
    }
}


if (isset($_POST['saveArticle'])) {
    if (isset($_POST['title']) && isset($_POST['text']) && isset($_SESSION['id_user'])) {
        $imageName = "";
        if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
            $imageName = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "./img/" . $imageName);
        }
        $userId = $_SESSION['id_user'];

        $q = "INSERT INTO articles (title, text, date, image, id_user) 
              VALUES ('" . $_POST['title'] . "','" . $_POST['text'] . "','" . date('Y-m-d') . "','" . $imageName . "', '" . $userId . "')";
        $db->query($q);
        header('Location: blog.php');
    }
}

if (isset($_GET['deleteArticle'])) {
    $query = "DELETE FROM articles WHERE id_article = " . $_GET['deleteArticle'];
    $db->query($query);
    header('Location: blog.php');
}

if (isset($_GET['hideArticle'])) {
    $query = "UPDATE articles SET visible = 0 WHERE id_article = " . $_GET['hideArticle'];
    $db->query($query);
    header('Location: blog.php');
}

if (isset($_GET['showArticle'])) {
    $query = "UPDATE articles SET visible = 1 WHERE id_article = " . $_GET['showArticle'];
    $db->query($query);
    header('Location: blog.php');
}

if (isset($_POST['saveComment'])) {
    if (isset($_POST['comment']) && isset($_GET['id_article'])) {
        $query = "INSERT INTO comments (comment, date, id_user, id_article)
                  VALUES ('" . $_POST['comment'] . "','" . date('Y-m-d') . "', '" . $_SESSION['id_user'] . "', '" . $_GET['id_article'] . "')";
        $db->query($query);
        header('Location: blog.php');
    }
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
                <textarea name="text" required></textarea><br><br>

                <label for="image">Imagen:</label>
                <input type="file" accept="image/*" name="image"><br><br>

                <input type="submit" name="saveArticle" value="Subir Articulo">

                <a href="blog.php">Volver</a>
            </form>

        <?php
        }

        showArticles($db);
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
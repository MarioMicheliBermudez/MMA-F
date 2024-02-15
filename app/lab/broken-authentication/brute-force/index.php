<?php
require_once("../../../lang/lang.php");
require_once("brute.php");

// Función para limpiar y validar datos de entrada
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$html = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Limpiar y validar datos de entrada
    $username = clean_input($_POST["username"]);
    $password = clean_input($_POST["password"]);

    // Establecer la conexión con la base de datos utilizando PDO
    $db = new PDO('sqlite:users.db');

    // Preparar la consulta SQL utilizando consultas preparadas
    $q = $db->prepare("SELECT * FROM users_ WHERE username=:user");
    $q->execute(array(
        'user' => $username
    ));

    // Obtener el resultado de la consulta
    $user = $q->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró un usuario con el nombre de usuario proporcionado
    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sesión de forma segura
        session_start();
        $_SESSION['username'] = $username;
        // Redireccionar al usuario a una página segura
        header("Location: index.php");
        exit; // Finalizar la ejecución del script después de redireccionar
    } else {
        $html = "Credenciales incorrectas.";
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">

    <title><?= htmlspecialchars($strings["title"]); ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h3><?= htmlspecialchars($strings["login"]); ?></h3>

            <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="justify-content-center" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="justify-content-center row mb-3">
                    <label for="inputUsername3" class=" text-center col-form-label"><?= htmlspecialchars($strings["username"]); ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="justify-content-center form-control" name="username" id="inputUsername3" required>
                    </div>
                </div>
                <div class="justify-content-center row mb-3">
                    <label for="inputPassword3" class="text-center col-form-label"><?= htmlspecialchars($strings["password"]); ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="justify-content-center form-control" name="password" id="inputPassword3" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= htmlspecialchars($strings["submit"]); ?></button>
                <p class="mt-3"><?= htmlspecialchars($strings["hint"]); ?></p>
                <?php
                echo '<h1> ' . htmlspecialchars($html) . ' </h1>';
                ?>
            </form>
        </div>
    </div>
    <script id="VLBar" title="<?= htmlspecialchars($strings["title"]); ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>

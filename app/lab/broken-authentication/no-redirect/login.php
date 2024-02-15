<?php
require("../../../lang/lang.php");
$strings = tr();

// Simulación de conexión a la base de datos (reemplaza con tu lógica real)
$db_host = "localhost";
$db_user = "tu_usuario";
$db_pass = "tu_contraseña";
$db_name = "nombre_de_la_base_de_datos";

// Conexión a la base de datos
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_POST['uname']) && isset($_POST['passwd'])) {
    $username = $_POST['uname'];
    $password = $_POST['passwd'];

    // Consulta para verificar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user_data = $result->fetch_assoc();
        $stored_password = $user_data['contrasena']; // Contraseña almacenada en la base de datos

        // Verificar la contraseña hasheada
        if (password_verify($password, $stored_password)) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Redirigir al usuario autenticado
            exit;
        } else {
            header("Location: login.php?error=1"); // Redirigir al formulario de inicio de sesión con un mensaje de error
            exit;
        }
    } else {
        header("Location: login.php?error=2"); // Usuario no encontrado
        exit;
    }
}

?>

<!doctype html>
<html lang="en">

<head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $strings['title']; ?></title>
    <!-- Incluye tus archivos CSS y otras dependencias -->
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px; margin-top: 15vh;">
            <h4>VULNLAB</h4>
            <form action="#" method="POST" style="text-align: center; margin-top: 20px; padding: 30px;">
                <!-- Campos del formulario de inicio de sesión -->
                <input type="text" class="form-control" name="uname" id="inputEmail3" placeholder="Nombre de usuario" required>
                <input type="password" class="form-control" name="passwd" id="inputPassword3" placeholder="Contraseña" required>
                <button type="submit" class="btn btn-primary"><?php echo $strings['submit']; ?></button>
                <p><?php echo $strings['text']; ?></p>
            </form>
        </div>
    </div>
    <!-- Incluye tus dependencias de JavaScript -->
</body>

</html>

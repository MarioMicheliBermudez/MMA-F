<?php
// Incluir las funciones de validación necesarias
require_once("../../../lang/lang.php");

// Función para escapar la salida HTML
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Obtener las cadenas traducidas
$strings = tr();

// Definir una lista blanca de comandos permitidos
$allowed_commands = array("ping");

// Inicializar la variable para almacenar el resultado del ping
$ping_result = '';

// Procesar el formulario si se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener la IP del formulario y validarla
    $input_ip = $_POST["ip"];
    if (filter_var($input_ip, FILTER_VALIDATE_IP)) {
        // Ejecutar el comando ping si la IP es válida y está en la lista blanca
        if (in_array("ping", $allowed_commands)) {
            exec("ping -n 3 " . escapeshellarg($input_ip), $ping_output);
            $ping_result = implode("<br>", $ping_output);
        } else {
            $ping_result = "El comando ping no está permitido.";
        }
    } else {
        $ping_result = "Dirección IP no válida.";
    }
}
?>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($strings['title']) ?></title>
    <link rel="stylesheet" href="./../bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row pt-5 mt-2" style="margin-left: 390px">
        <h2><?= h($strings['title']) ?></h2>
    </div>
    <div class="row pt-3 mt-2">
        <form method="POST">
            <input class="form-control" type="text" name="ip" aria-label="ip" style="margin-top: 30px; margin-left: 400px; width: 500px; ">
            <button type="submit" class="btn btn-primary" style="margin-top: 30px; margin-left: 400px; width: 500px;">Ping</button>
        </form>
    </div>
    <div class="row pt-5 mt-2" style="margin-left: 400px">
        <?php if (!empty($ping_result)): ?>
            <div class="alert alert-primary" role="alert" style=" width:500px;">
                <strong><p style="text-align:center;"><?= h($ping_result) ?></p></strong>
            </div>
        <?php endif; ?>
    </div>
</div>
<script id="VLBar" title="Title" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>

<?php
ob_start();
session_start();

require("../../../lang/lang.php");
$strings = tr();

if ($_SESSION['authority'] === "user") {
    $_SESSION['authority'] = "user"; // Asegúrate de que esta asignación sea válida para tu lógica de autoridad.
} elseif ($_SESSION['authority'] === "admin") {
    $_SESSION['authority'] = "admin"; // Asegúrate de que esta asignación sea válida para tu lógica de autoridad.
} else {
    // Manejo de sesión no válida, redirige a la página de inicio de sesión o realiza alguna acción adecuada.
    header("Location: index.php");
    exit;
}

if (isset($_POST['chat-input'])) {
    $message = htmlspecialchars($_POST['chat-input']); // Evitar XSS

    $db = new PDO('sqlite:database.db');

    // ADMIN PAGE LOGIC
    if ($_SESSION['authority'] === "admin") {
        // Handle admin-specific logic here
        if (filter_var($message, FILTER_VALIDATE_URL)) {
            // Handle URL logic if needed
        }

        // ... (otros casos específicos de admin)

    }

    // INSERT MESSAGE INTO DATABASE
    $insert_s = $db->prepare('INSERT INTO csrf_chat (authority, message) VALUES (?, ?)');
    $insert_send = $insert_s->execute([$_SESSION['authority'], $message]);

    $message_reply = $strings['message_reply'];
    $insert_r = $db->prepare('INSERT INTO csrf_chat (authority, message) VALUES (?, ?)');
    $insert_reply = $insert_r->execute(['admin', $message_reply]);

    // SELECT AND DISPLAY MESSAGES
    $select = $db->prepare("SELECT * FROM csrf_chat ORDER BY id DESC");
    $select->execute();
    $db_messages = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($db_messages as $db_message) {
        if ($db_message['authority'] === "user") {
            echo '<div class="messages__item messages__item--operator">' . $db_message['message'] . '</div>';
        }
        if ($db_message['authority'] === "admin") {
            echo '<div class="messages__item messages__item--visitor">' . $db_message['message'] . '<pre class="m-0 mt-1 text-danger">admin</pre></div>';
        }
    }
} else {
    // No se recibió la entrada del chat, redirige a la página de inicio o realiza alguna acción adecuada.
    header("Location: index.php");
    exit;
}
?>

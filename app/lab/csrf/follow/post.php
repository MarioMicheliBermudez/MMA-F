<?php
session_start();

if (isset($_POST['chat-input'])) {

    $message = $_POST['chat-input'];

    $db = new PDO('sqlite:database.db');

    // Manejo de sesiones
    $_SESSION['authority'] = "admin";

    require("../../../lang/lang.php");
    $strings = tr();

    ////////////////////////////////    ADMIN PAGE START    ////////////////////////////////////

    // Validar la URL
    if (filter_var($message, FILTER_VALIDATE_URL)) {

        $url = $message;
        $parts = parse_url($url);
        $query = array();

        // No suprimir los errores durante el desarrollo
        parse_str($parts['query'], $query);

        if (isset($query['follow'])) {

            // Utilizar consultas preparadas y validar/sanitizar la entrada del usuario
            $selectUser = $db->prepare("SELECT * FROM csrf_follow WHERE authority=:authority");
            $selectUser->execute(array('authority' => $_SESSION['authority']));
            $selectUser_Info = $selectUser->fetch();

            if ($selectUser_Info && $selectUser_Info['follow_status'] == "false") {

                // Utilizar consultas preparadas para la actualización
                $follow_update = $db->prepare("UPDATE csrf_follow SET follow_status=:follow_status WHERE authority=:authority");
                $status_follow_update = $follow_update->execute(array(
                    'authority' => $_SESSION['authority'],
                    'follow_status' => 'true'
                ));
            }
        }
    }
    ////////////////////////////////    ADMIN PAGE END  ////////////////////////////////////

    // Utilizar consultas preparadas y validar/sanitizar la entrada del usuario
    $insert_s = $db->prepare('INSERT INTO csrf_chat (authority, message) VALUES (?, ?)');
    $insert_send = $insert_s->execute(array("user", $message));

    $message_reply = $strings['message_reply'];
    // Utilizar consultas preparadas y validar/sanitizar la entrada del usuario
    $insert_r = $db->prepare('INSERT INTO csrf_chat (authority, message) VALUES (?, ?)');
    $insert_reply = $insert_r->execute(array("admin", $message_reply));

    // Utilizar consultas preparadas y ordenar por ID
    $select = $db->prepare("SELECT * FROM csrf_chat ORDER BY id DESC");
    $select->execute();
    $db_messages = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($db_messages as $db_message) {
        // Escapar datos de salida para prevenir ataques XSS
        $escaped_message = htmlspecialchars($db_message['message'], ENT_QUOTES, 'UTF-8');

        if ($db_message['authority'] == "user") {
            echo '<div class="messages__item messages__item--operator">' . $escaped_message . '</div>';
        }
        if ($db_message['authority'] == "admin") {
            echo '<div class="messages__item messages__item--visitor">' . $escaped_message . '<pre class="m-0 mt-1 text-danger">admin</pre> </div> ';
        }
    }

} else {
    header("Location: index.php");
    exit;
}
?>

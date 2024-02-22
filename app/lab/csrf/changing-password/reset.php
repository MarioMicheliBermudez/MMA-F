<?php

$db = new PDO('sqlite:database.db');

for ($id = 1; $id <= 2; $id++) {

    switch ($id) {
        case 1:
            $password = password_hash("3cc22e4367e2d2525ea28a7d33731c12", PASSWORD_DEFAULT);
            break;
        case 2:
            $password = password_hash("user", PASSWORD_DEFAULT);
            break;
    }

    // Utilizando consultas preparadas y vinculación de parámetros
    $query = $db->prepare("UPDATE csrf_changing_password SET password=:password WHERE id=:id");
    $query->execute(array(
        'id' => $id,
        'password' => $password
    ));

    // Validar antes de ejecutar DROP TABLE
    if ($id == 1) {
        $query2 = $db->prepare("DROP TABLE IF EXISTS csrf_chat");
        $query2->execute();
    }

    // Utilizando consultas preparadas para CREATE TABLE
    $query3 = $db->prepare('CREATE TABLE IF NOT EXISTS "csrf_chat" (
        "id"	INTEGER,
        "authority"	TEXT,
        "message"	TEXT,
        PRIMARY KEY("id" AUTOINCREMENT)
    )');
    $query3->execute();
}

// Manejo de errores y redirección segura
if ($query && $query3) {
    header("Location: index.php");
    exit;
} else {
    echo "Error en la operación. Consulta la información de error y toma medidas apropiadas.";
    exit;
}

?>

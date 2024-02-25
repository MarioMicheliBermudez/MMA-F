<?php
try {
    $db = new PDO('sqlite:database.db');

    // Actualización de follow_status en csrf_follow
    $query = $db->prepare("UPDATE csrf_follow SET follow_status=:follow_status");
    $query->execute(array('follow_status' => 'false'));

    // Eliminación de la tabla csrf_chat
    $query2 = $db->prepare("DROP TABLE IF EXISTS csrf_chat");
    $query2->execute();

    // Creación de la tabla csrf_chat
    $query3 = $db->prepare('CREATE TABLE IF NOT EXISTS "csrf_chat" (
        "id"	INTEGER,
        "authority"	TEXT,
        "message"	TEXT,
        PRIMARY KEY("id" AUTOINCREMENT)
    )');
    $query3->execute();

    header("Location: index.php");
    exit;
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo "Error: " . $e->getMessage();
    exit;
}
?>

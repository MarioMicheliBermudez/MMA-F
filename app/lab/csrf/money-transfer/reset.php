<?php

try {
    $db = new PDO('sqlite:database.db');

    for ($id = 1; $id <= 2; $id++) {
        switch ($id) {
            case 1: // admin
                $money = "999999999999";
                break;
            case 2: // user
                $money = "1000";
                break;
        }

        $query = $db->prepare("UPDATE csrf_money_transfer SET money=:money WHERE id=:id");
        $query->execute(array(
            'id' => $id,
            'money' => $money
        ));
    }

    $query2 = $db->prepare("DROP TABLE IF EXISTS csrf_chat");
    $query2->execute();

    $query3 = $db->prepare('CREATE TABLE IF NOT EXISTS "csrf_chat" (
        "id" INTEGER PRIMARY KEY AUTOINCREMENT,
        "authority" TEXT,
        "message" TEXT
    )');
    $query3->execute();

    header("Location: index.php");
    exit;
} catch (PDOException $e) {
    // Manejar excepciones de la base de datos, si es necesario
    echo "Error de la base de datos: " . $e->getMessage();
} catch (Exception $e) {
    // Manejar otras excepciones, si es necesario
    echo "Error: " . $e->getMessage();
}
?>

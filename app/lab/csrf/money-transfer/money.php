<?php
ob_start();
session_start();

try {
    if (!isset($_SESSION['authority'])) {
        // Redirigir si la sesión no está configurada
        header("Location: login.php");
        exit;
    }

    $authority = $_SESSION['authority'];

    $db = new PDO('sqlite:database.db');
    
    require("../../../lang/lang.php");
    $strings = tr();
    
    $selectUser = $db->prepare("SELECT * FROM csrf_money_transfer WHERE authority=:authority");
    $selectUser->execute(array('authority' => $authority));
    $selectUser_Info = $selectUser->fetch();

    sleep(1);

    echo $strings['card_money'] . "  <b>" . $selectUser_Info['money'] . " " . $strings['card_money_symbol'] . "</b>";
} catch (PDOException $e) {
    // Manejar excepciones de la base de datos, si es necesario
    echo "Error de la base de datos: " . $e->getMessage();
} catch (Exception $e) {
    // Manejar otras excepciones, si es necesario
    echo "Error: " . $e->getMessage();
}
?>

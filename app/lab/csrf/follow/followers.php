<?php
ob_start();
session_start();

// Validar y establecer la autoridad de manera más segura
$allowedAuthorities = ["user", "admin"]; // Lista de autoridades permitidas
$defaultAuthority = "user"; // Establecer una autoridad predeterminada

if (isset($_SESSION['authority']) && in_array($_SESSION['authority'], $allowedAuthorities)) {
    $authority = $_SESSION['authority'];
} else {
    $authority = $defaultAuthority;
}

$db = new PDO('sqlite:database.db');

require("../../../lang/lang.php");
$strings = tr();

$selectFollowers = $db->prepare("SELECT * FROM csrf_follow WHERE follow_status=:follow_status");
$selectFollowers->execute(array('follow_status' => 'true'));
$selectFollowers_Infos = $selectFollowers->fetchAll(PDO::FETCH_ASSOC);

// No es necesario sleep(1) en este contexto

$id = 1;
foreach ($selectFollowers_Infos as $selectFollowers_Info) {
    echo '<tr class="text-center">
    <th scope="row">' . $id . '</th>
    <td>' . htmlspecialchars($selectFollowers_Info['authority'], ENT_QUOTES, 'UTF-8') . '</td>
    </tr>';
    $id++;
}
?>

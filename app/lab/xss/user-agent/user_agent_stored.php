<?php
require("../../../lang/lang.php");
$strings = tr();

$db = new PDO('sqlite:database.db');
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: chat-room-login.php");
    exit;
}

$uname = $_SESSION['username'];
$UserAgent = htmlspecialchars($_SERVER['HTTP_USER_AGENT']); // Escapar el User-Agent

$q = $db->prepare("INSERT INTO user_agent (username, useragent) VALUES (:user, :usragent)");
$q->execute(array(
    'user' => $uname,
    'usragent' => $UserAgent
));
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

    <title><?php echo htmlspecialchars($strings['title']); ?></title>
</head>

<body>
    <div class="container">
        <div class=" d-flex justify-content-center " style="flex-direction: column;align-items:center;margin-top:20vh;">
            <div class="alert alert-info col-md-6  " role="alert" style="text-align:center;">
                <h5><?= htmlspecialchars($strings["agent-text"]); ?></h5>
            </div>

            <form action="#" method="post" class="col-md-6" style="text-align:center;">
                <button type="submit" class="btn btn-success" name="a"><?= htmlspecialchars($strings["click-here"]); ?></button>
            </form>
        </div>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="tbl" style="margin-top: 30px;">

            <?php
            if (isset($_POST['a'])) {
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $q = $db->query("SELECT * FROM user_agent");
                $i = 1;
                if ($q) {
                    echo '<table class="table table-striped" style="max-width: 1000px;">
        <tr>
            <td>
                Username
            </td>
            <td>
                User Agent
            </td>
        </tr>';

                    while ($cikti = $q->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($cikti['username']) . '</td>'; // Escapar la salida de la base de datos
                        echo '<td>' . htmlspecialchars($cikti['useragent']) . '</td>'; // Escapar la salida de la base de datos
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '<form action="#" method="POST">';
                    echo '<button type="submit" class="btn btn-danger" name="del">' . htmlspecialchars($strings['delete-all']) . '</button>';
                    echo '</form>';
                }
            }

            if (isset($_POST['del'])) {
                $q = $db->prepare("DELETE FROM user_agent");
                $q->execute();
            }
            ?>
        </div>
    </div>
    <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>

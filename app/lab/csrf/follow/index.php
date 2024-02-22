<?php
ob_start();
session_start();

// Establecer la autoridad después de la autenticación, esto es solo un ejemplo
$_SESSION['authority'] = "user";

$db = new PDO('sqlite:database.db');

require("../../../lang/lang.php");
$strings = tr();

// Utilizar consultas preparadas y validar/sanitizar la entrada del usuario
$selectUser = $db->prepare("SELECT * FROM csrf_follow WHERE authority=:authority");
$selectUser->execute(array('authority' => $_SESSION['authority']));
$selectUser_Info = $selectUser->fetch();

$selectFollowers = $db->prepare("SELECT * FROM csrf_follow WHERE follow_status=:follow_status");
$selectFollowers->execute(array('follow_status' => 'true'));
$selectFollowers_Infos = $selectFollowers->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['follow'])) {
    if ($selectUser_Info && $selectUser_Info['follow_status'] == "false") {
        $follow_update = $db->prepare("UPDATE csrf_follow SET follow_status=:follow_status WHERE authority=:authority");
        $status_follow_update = $follow_update->execute(array(
            'authority' => $_SESSION['authority'],
            'follow_status' => 'true'
        ));

        if ($status_follow_update) {
            header("Location: index.php?status=success");
            exit;
        } else {
            header("Location: index.php?status=unsuccess");
            exit;
        }
    } else {
        header("Location: index.php?status=following");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">

<head>
    <!-- ... tus meta tags y enlaces a CSS ... -->
</head>

<body>

    <div class="container">
        <!-- ... tu contenido HTML ... -->
    </div>

    <script type="text/javascript">
        function Post() {
            $.ajax({
                type: 'POST',
                url: 'post.php',
                data: $('form#form').serialize(),
                success: function (incoming) {
                    $('#chatbox__messages').html(incoming);
                    document.getElementById("form").reset();
                    Money();
                }
            });
        }

        function Money() {
            $.ajax({
                type: 'POST',
                url: 'followers.php',
                success: function (incoming) {
                    $('#tbody').html(incoming);
                }
            });
        }
    </script>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/Chat.js"></script>
    <script src="assets/js/app.js"></script>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="8" src="/public/assets/js/vlnav.min.js"></script>

</body>

</html>


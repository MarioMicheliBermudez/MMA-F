<?php
ob_start();
session_start();

if (!isset($_SESSION['authority'])) {
    header("Location: login.php");
    exit;
}

$db = new PDO('sqlite:database.db');

require("../../../lang/lang.php");
$strings = tr();

$selectUser = $db->prepare("SELECT * FROM csrf_changing_password WHERE authority=:authority");
$selectUser->execute(array('authority' => "user"));
$selectUser_Password = $selectUser->fetch();

$selectAdmin = $db->prepare("SELECT * FROM csrf_changing_password WHERE authority=:authority");
$selectAdmin->execute(array('authority' => "admin"));
$selectAdmin_Password = $selectAdmin->fetch();

if (isset($_GET['new_password']) && isset($_GET['confirm_password'])) {
    if ($_GET['new_password'] == $_GET['confirm_password']) {
        $insert = $db->prepare("UPDATE csrf_changing_password SET password=:password WHERE authority=:authority");
        $status_insert = $insert->execute(array(
            'authority' => $_SESSION['authority'],
            'password' => $_GET['new_password']
        ));

        if ($status_insert) {
            header("Location: index.php?status=success");
            exit;
        } else {
            header("Location: index.php?status=unsuccess");
            exit;
        }
    } else {
        header("Location: index.php?status=not_the_same");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings['title']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/chat.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/typing.css">
</head>

<body>

    <div class="container">

        <div class="container-wrapper">

            <div class="row pt-4 mt-5 mb-3">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <h1><?= $strings['title']; ?></h1>

                    <a href="reset.php"><button type="button" class="btn btn-secondary btn-sm"><?= $strings['reset_button']; ?></button></a>
                    <a href="logout.php"><button type="button" class="btn btn-danger btn-sm"><?= $strings['logout_button']; ?></button></a>

                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="row pt-2">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <?php
                    if (isset($_GET['status'])) {
                        $status = $_GET['status'];
                        $alert_message = '';

                        switch ($status) {
                            case 'success':
                                $alert_message = $strings['alert_success'];
                                $alert_class = 'alert-success';
                                break;
                            case 'unsuccess':
                                $alert_message = $strings['alert_unsuccess'];
                                $alert_class = 'alert-danger';
                                break;
                            case 'not_the_same':
                                $alert_message = $strings['alert_not_the_same'];
                                $alert_class = 'alert-danger';
                                break;
                            default:
                                $alert_class = '';
                        }

                        if ($alert_message) {
                            echo '<div class="alert ' . $alert_class . ' mt-2" role="alert">' . $alert_message . '</div>';
                        }
                    }
                    ?>

                    <h3 class="mb-3"><?= $strings['middle_title']; ?> <?= $_SESSION['authority']; ?></h3>

                    <form action="index.php" method="post">
                        <div class="mb-3">
                            <label for="new_password" class="form-label"><?= $strings['new_password_input']; ?></label>
                            <input class="form-control" type="password" name="new_password" id="new_password"
                                placeholder="<?= $strings['new_password_input_placeholder']; ?>" required>

                            <label for="confirm_password" class="form-label mt-2"><?= $strings['confirm_password_input']; ?></label>
                            <input class="form-control" type="password" name="confirm_password" id="confirm_password"
                                placeholder="<?= $strings['confirm_password_input_placeholder']; ?>" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary mb-5" type="submit"><?= $strings['confirm_button']; ?></button>
                        </div>
                    </form>

                </div>
                <div class="col-md-3"></div>
            </div>

        </div>

        <div class="chatbox">
            <!-- Rest of your chatbox code -->
        </div>

    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/Chat.js"></script>
    <script src="assets/js/app.js"></script>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="8" src="/public/assets/js/vlnav.min.js"></script>

</body>

</html>
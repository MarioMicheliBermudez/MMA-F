<?php
require("../../../lang/lang.php");
$strings = tr();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

    <title><?php echo $strings['title']; ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center flex-column" style="text-align:center;">
        <div class="name">
            <?php
            if (isset($_GET['name'])) {
                $name = $_GET['name'];
                // Validar el nombre para asegurar que solo contenga caracteres seguros
                if (preg_match("/^[a-zA-Z ]*$/", $name)) {
                    echo '<h2>' . htmlspecialchars($name) . '\'s</h2>';
                } else {
                    echo '<h2>Invalid Name</h2>';
                }
            }
            
            ?>
        </div>
        <div class="img">
            <img src="poster2.jpg" alt="" style="max-height: 90vh;" class="shadow-lg  p-1 bg-body rounded">
        </div>
    </div>
    <a href="index.php" style="margin: 0px 0px 15px 15px;"><button type="button" class="btn btn-success " style="margin-top: 10px;"><?php echo $strings['back']; ?></button></a>
    <script id="VLBar" title="<?= $strings['title'] ?>" category-id="1" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
<?php
    error_reporting(E_ALL);

    require("../../../lang/lang.php");
    $strings = tr();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <style>
        p {
            margin-top: 15px;
        }
    </style>
    <title><?= $strings['title']; ?></title>
</head>
<body>
    <div class="container">
        <div class="container-wrapper">
            <div class="row pt-5">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="index.php" method="GET">
                        <div class="mb-3">
                            <label for="country" class="form-label"><?= $strings['label']; ?></label>
                            <select name="country" id="country" class="form-select">
                                <option value="france.php"><?= $strings['paris']; ?></option>
                                <option value="germany.php"><?= $strings['berlin']; ?></option>
                                <option value="north_korea.php"><?= $strings['pyongyang']; ?></option>
                                <option value="turkey.php"><?= $strings['ankara']; ?></option>
                                <option value="england.php"><?= $strings['london']; ?></option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit"><?= $strings['button']; ?></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <p>
                            <?php 
                                if(isset($_GET['country'])){
                                    $page = $_GET['country'];
                                    // Implement more secure input validation and sanitization here if needed
                                    $page = str_replace( array( "http://", "https://" ), "", $page ); 
                                    $page = str_replace( array( "../", "..\"" ), "", $page );
                                    // Validate the page variable before including
                                    if (in_array($page, array('france.php', 'germany.php', 'north_korea.php', 'turkey.php', 'england.php'))) {
                                        include($page);
                                    } else {
                                        // Handle invalid input, perhaps redirect or display an error message
                                        echo "Invalid input!";
                                    }
                                }
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
    <script id="VLBar" title="<?= $strings['title'] ?>" category-id="6" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
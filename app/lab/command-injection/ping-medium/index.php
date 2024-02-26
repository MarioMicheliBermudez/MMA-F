<?php
require("../../../lang/lang.php");

$strings = tr();

?>

<html lang="en-US">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= htmlspecialchars($strings['title']) ?></title>
    <link rel="stylesheet" href="./../bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row pt-5 mt-2" style="margin-left: 390px">
            <h2><?= htmlspecialchars($strings['title']) ?></h2>
        </div>
        <div class="row pt-3 mt-2">
            <form method="POST">
                <input class="form-control" type="text" name="ip" aria-label="ip" style="margin-top: 30px; margin-left: 400px; width: 500px; ">
                <button type="submit" class="btn btn-primary" style="margin-top: 30px; margin-left: 400px; width: 500px;">Ping</button>
            </form>
        </div>
        <div class="row pt-5 mt-2" style="margin-left: 400px">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ip"])) {
                $input = $_POST["ip"];
                $blacklists = array("ls", "cat", "less", "tail", "more", "whoami", "pwd", "echo", "ps");
                $status = 0;

                foreach ($blacklists as $blacklist) {
                    if (stripos($input, $blacklist) !== false) {
                        $status++;
                    }
                }

                if ($status === 0) {
                    exec("ping -n 3 $input", $out);
                    if (!empty($out)) {
                        echo '<div class="alert alert-primary" role="alert" style="width:500px;"> <strong> <p style="text-align:center;">';
                        foreach ($out as $line) {
                            echo htmlspecialchars($line) . "<br>";
                        }
                        echo ' </p></strong></div>';
                    }
                } else {
                    echo '<div class="alert alert-danger" role="alert" style="width:500px;"> <strong> <p style="text-align:center;">ERROR</p></strong></div>';
                }
            }
            ?>
        </div>
    </div>
    <script id="VLBar" title="Title" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>

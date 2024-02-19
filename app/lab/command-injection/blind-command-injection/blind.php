<?php
require_once("../../../lang/lang.php");
$strings = tr();

session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Log the user agent to a file (Ensure proper permissions are set on /tmp/userAgent.log)
$userAgent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
file_put_contents('/tmp/userAgent.log', $userAgent . PHP_EOL, FILE_APPEND | LOCK_EX);

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($strings['title']); ?></title>
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-center" style="flex-direction: column;align-items:center;margin-top:20vh;">
            <div class="alert alert-info col-md-6" role="alert" style="text-align:center;">
                <h5><?= htmlspecialchars($strings["text"]); ?></h5>
            </div>
        </div>
    </div>

    <div class="container d-flex justify-content-center">
        <div class="tbl" style="margin-top: 30px;"></div>
    </div>

    <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>

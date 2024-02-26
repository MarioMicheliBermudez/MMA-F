<?php
// Include necessary validation functions
require_once("../../../lang/lang.php");

// Function to escape HTML output
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Get translated strings
$strings = tr();

// Define a whitelist of allowed commands
$allowed_commands = array("ping");

// Initialize variable to store ping result
$ping_result = '';

// Process the form if submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and validate the IP from the form
    $input_ip = $_POST["ip"];
    if (filter_var($input_ip, FILTER_VALIDATE_IP)) {
        // Execute the ping command if IP is valid and in whitelist
        if (in_array("ping", $allowed_commands)) {
            // Escaping the input before using in the command
            $escaped_ip = escapeshellarg($input_ip);
            // Using command safely
            exec("ping -c 3 " . $escaped_ip, $ping_output);
            $ping_result = implode("<br>", $ping_output);
        } else {
            $ping_result = "Ping command is not allowed.";
        }
    } else {
        $ping_result = "Invalid IP address.";
    }
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($strings['title']) ?></title>
    <link rel="stylesheet" href="./../bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row pt-5 mt-2" style="margin-left: 390px">
        <h2><?= h($strings['title']) ?></h2>
    </div>
    <div class="row pt-3 mt-2">
        <form method="POST">
            <input class="form-control" type="text" name="ip" aria-label="ip" style="margin-top: 30px; margin-left: 400px; width: 500px; ">
            <button type="submit" class="btn btn-primary" style="margin-top: 30px; margin-left: 400px; width: 500px;">Ping</button>
        </form>
    </div>
    <div class="row pt-5 mt-2" style="margin-left: 400px">
        <?php if (!empty($ping_result)): ?>
            <div class="alert alert-primary" role="alert" style=" width:500px;">
                <strong><p style="text-align:center;"><?= h($ping_result) ?></p></strong>
            </div>
        <?php endif; ?>
    </div>
</div>
<script id="VLBar" title="Title" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>


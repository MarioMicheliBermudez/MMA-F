<?php
require("../../../lang/lang.php");

$strings = tr();

// Function to sanitize input
function sanitize_input($input) {
    return intval($input); // Assuming product_id is an integer
}

?>

<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($strings['title']) ?></title>
    <link rel="stylesheet" href="./../bootstrap.min.css">
</head>

<body>
    <div class="container">
        <!-- Your HTML content -->
        <?php
        if (isset($_GET['product_id'])) {
            $product_id = sanitize_input($_GET['product_id']);
            // Execute your business logic here instead of directly executing shell commands
            // For example, interact with a database or perform some safe operations
            // Avoid shell_exec or similar functions
            
            // Example of displaying sanitized product id
            echo "<p>Product ID: $product_id</p>";
        }
        ?>
    </div>
    <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>


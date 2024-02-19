<?php
require_once("../../../lang/lang.php");
$strings = tr();

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['uname']) && isset($_POST['passwd'])) {
    // Sanitize user input
    $uname = htmlspecialchars($_POST['uname']);
    $passwd = htmlspecialchars($_POST['passwd']);

    // Connect to the database securely using PDO
    try {
        $db = new PDO('sqlite:database.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Use prepared statements to prevent SQL injection
        $stmt = $db->prepare("SELECT * FROM users WHERE username=:uname AND password=:passwd");
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':passwd', $passwd);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            
            $_SESSION['username'] = $user['username'];

            // Redirect to the authenticated page
            header("Location: blind.php");
            exit;
        } else {
            // Invalid credentials
            echo '<h1>wrong username or password</h1>';
        }
    } catch (PDOException $e) {
        // Handle database connection errors securely
        echo "Database Error: " . $e->getMessage();
    }
}
?>

<!doctype html>
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
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h4>VULNLAB</h4>

            <form action="#" method="POST" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">User</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="uname" id="inputEmail3">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Pass</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="passwd" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo $strings['submit']; ?></button>
                <p>mandalorian / mandalorian </p>
            </form>
        </div>
    </div>

    <script id="VLBar" title="<?= $strings['title'] ?>" category-id="4" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
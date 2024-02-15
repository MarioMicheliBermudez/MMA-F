<?php
// Initialize the database connection (SQLite in this case)
$db = new PDO('sqlite:users.db');
// Handle form submission
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Use prepared statements to prevent SQL injection
    $q = $db->prepare("SELECT * FROM users_ WHERE username = :user AND password = :pass");
    $q->execute([
        'user' => $_POST['username'],
        'pass' => $_POST['password']
    ]);

    // Fetch the result
    $_select = $q->fetch();

    if (isset($_select['id'])) {
        // Start a session upon successful login
        session_start();
        $_SESSION['username'] = $_POST['username'];
        $html = "Congratulations! You are logged in."; // Replace with your desired message
        // Redirect to another page if needed: header("Location: index.php");
    } else {
        $html = "Incorrect username or password. Please try again."; // Replace with an appropriate error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Log In">
    </form>
    <!-- Display login status -->
    <p><?php echo $html; ?></p>
</body>
</html>
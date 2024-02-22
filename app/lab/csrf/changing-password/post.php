<?php
ob_start();
session_start();

if (isset($_POST['chat-input'])) {
    $message = $_POST['chat-input'];

    // Establish a database connection
    require("../../../lang/lang.php");
    require("database.php"); // Include a separate file for database connection
    $strings = tr();

    // Constants for table names
    define('CHANGING_PASSWORD_TABLE', 'csrf_changing_password');
    define('CHAT_TABLE', 'csrf_chat');

    try {
        // Admin Page Logic
        if ($_SESSION['authority'] == "user") {
            $session = "admin";
        } elseif ($_SESSION['authority'] == "admin") {
            $session = "user";
        }

        if (filter_var($message, FILTER_VALIDATE_URL)) {
            // URL parsing logic for changing password
            // ...

            if (isset($query['new_password']) && isset($query['confirm_password'])) {
                if ($query['new_password'] == $query['confirm_password']) {
                    $updatePassword = $db->prepare("UPDATE " . CHANGING_PASSWORD_TABLE . " SET password=:password WHERE authority=:authority");
                    $status_update = $updatePassword->execute([
                        'authority' => $session,
                        'password' => $query['new_password']
                    ]);

                    if (!$status_update) {
                        throw new Exception("Failed to update password");
                    }
                }
            }
        }

        // Message Handling Logic
        $insertMessage = $db->prepare('INSERT INTO ' . CHAT_TABLE . ' (authority, message) VALUES (:authority, :message)');
        $insertMessage->bindParam(':authority', $authority);
        $insertMessage->bindParam(':message', $message);

        if ($_SESSION['authority'] == "user") {
            $authority = "user";
            $status_insert = $insertMessage->execute();

            if (!$status_insert) {
                throw new Exception("Failed to insert user message");
            }

            // Insert reply for admin
            $authority = "admin";
            $message_reply = $strings['message_reply'];
            $status_reply = $insertMessage->execute();

            if (!$status_reply) {
                throw new Exception("Failed to insert admin reply");
            }
        }

        if ($_SESSION['authority'] == "admin") {
            $authority = "admin";
            $status_insert = $insertMessage->execute();

            if (!$status_insert) {
                throw new Exception("Failed to insert admin message");
            }

            // Insert reply for user
            $authority = "user";
            $message_reply = $strings['message_reply'];
            $status_reply = $insertMessage->execute();

            if (!$status_reply) {
                throw new Exception("Failed to insert user reply");
            }
        }

        // Display Messages
        $select = $db->prepare("SELECT * FROM " . CHAT_TABLE . " ORDER BY id DESC");
        $status_select = $select->execute();

        if (!$status_select) {
            throw new Exception("Failed to fetch messages");
        }

        $db_messages = $select->fetchAll(PDO::FETCH_ASSOC);

        foreach ($db_messages as $db_message) {
            // Display messages logic
            // ...
        }

    } catch (Exception $e) {
        // Handle exceptions and errors
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
    exit;
}
?>

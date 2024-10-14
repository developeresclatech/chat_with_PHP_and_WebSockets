<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        
        // Check if the user already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND username = :username");
        $stmt->execute([':email' => $email, ':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) { // User already exists
            // Set session data
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];

            // Fetch the existing conversation_id for the user
            $stmt = $pdo->prepare("SELECT conversation_id FROM messages WHERE sender_id = :sender_id LIMIT 1");
            $stmt->execute([':sender_id' => $user['id']]);
            $messages = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($messages) {
                // Use the existing conversation_id
                $_SESSION['conversation_id'] = $messages['conversation_id'];
            } else {
                // No existing messages, create a new conversation
                $stmt = $pdo->prepare("INSERT INTO conversations (created_at) VALUES (:created_at)");
                $stmt->execute([':created_at' => date('Y-m-d H:i:s')]);
                $_SESSION['conversation_id'] = $pdo->lastInsertId();
            }

            echo "Login successful!";
            // Redirect to the index page
            header('Location: index.php');
            exit();

        } else { // User does not exist, register new user
            // Insert new user
            $stmt = $pdo->prepare("INSERT INTO users (username, email) VALUES (:username, :email)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email
            ]);
            
            // Fetch the newly created user details
            $user_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("SELECT role_id FROM users WHERE id = :id");
            $stmt->execute([':id' => $user_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set session for the newly registered user
            $_SESSION['user_id'] = $user_id;
            $_SESSION['role_id'] = $row['role_id'];
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            // Create a new conversation for the new user
            $stmt = $pdo->prepare("INSERT INTO conversations (created_at) VALUES (:created_at)");
            $stmt->execute([':created_at' => date('Y-m-d H:i:s')]);
            $_SESSION['conversation_id'] = $pdo->lastInsertId();

            echo "Registration successful!";
            // Redirect to the index page
            header('Location: index.php');
            exit();
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

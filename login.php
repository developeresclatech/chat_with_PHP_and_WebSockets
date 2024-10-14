<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT id, username FROM users WHERE email = :email AND password = :password");
        $stmt->execute([':email' => $email, ':password' => md5($password)]); // Use a hash for the password

        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: chat.php');
        } else {
            echo "Invalid email or password!";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>

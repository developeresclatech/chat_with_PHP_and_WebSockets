<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Chat Application</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2>Chat Application</h2>
    <div id="chat"></div>
    <input type="text" id="message" placeholder="Enter your message">
    <button id="send">Send</button>
    <a href="logout"></a>
    <!-- <button id="logout">Logout</button> -->
</div>

<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

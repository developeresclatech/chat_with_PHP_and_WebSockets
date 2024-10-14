<?php
session_start();
require '../vendor/autoload.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=chat_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

$conversation_id = $_GET['conversation_id'] ?? null; // Make sure 'conversation_id' is set
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat Room</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa; /* Light background color */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .form-container, .chat-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            margin-top: 20px;
        }
        .form-container:hover, .chat-container:hover {
            box-shadow: 0px 0px 25px rgba(0, 0, 0, 0.3);
        }
        input {
            display: block;
            margin-bottom: 15px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
        }
        input:focus {
            border-color: #007bff;
            outline: none;
        }
        button {
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        #response {
            margin-top: 15px;
            font-size: 14px;
            color: #e74c3c; /* Error message color */
        }
        #chat-box {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php if (!isset($_SESSION['user_id'])) { ?>
        <div class="form-container">
            <h2 class="text-center mb-4">Login Form</h2>
            <form id="login-user">
                <div class="mb-3">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="mb-3">
                    <label for="email">Your Email:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit">Send</button>
            </form>
            <div id="response" class="mt-3"></div>
        </div>
    <?php } else { ?>
        <div class="chat-container">
            <h2 class="text-center mb-4">( <?php echo $_SESSION['username']; ?> ) Admin w Chat Room</h2>
            <div id="chat-box" style="color: red;">
                <!-- Messages will be appended here via JavaScript -->
            </div>
            <form id="message-form" class="d-flex">
                <input type="text" id="message" class="form-control me-2" placeholder="Type your message..." required>
                <button type="submit">Send</button>
            </form>
            <a href="../logout.php">Logout</a>
        </div>
    <?php } ?>

    <script>
        $(document).ready(function() {
            let conn;
            const chatBox = document.getElementById('chat-box');
            const messageInput = document.getElementById('message');
            const senderId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
            const conversationId = <?php echo json_encode($conversation_id); ?>;
            const username = <?php echo json_encode($_SESSION['username'] ?? ''); ?>;

            if (username) {
                connectToChat(username);
            } else {
                alert('No username provided. Please log in again.');
            }

            $('#message-form').on('submit', function(e) {
                e.preventDefault();
                const message = $('#message').val();
                if (senderId !== null && conversationId !== null) {
                    $.ajax({
                        url: 'send_message.php',
                        type: 'POST',
                        data: {
                            message: message,
                            conversation_id: conversationId,
                            sender_id: senderId
                        },
                        success: function() {
                            loadOldMessages(); // Reload the messages
                            $('#message').val(''); // Clear input field
                        },
                        error: function(xhr, status, error) {
                            $('#chat-box').append(`<div>Error sending message: ${error}</div>`);
                        }
                    });
                } else {
                    alert('You must be logged in to send a message.');
                }
            });

            $('#login-user').submit(function(e) {
                e.preventDefault();
                const formData = {
                    username: $('#name').val(),
                    email: $('#email').val()
                };

                $.ajax({
                    type: 'POST',
                    url: '../register.php',
                    data: formData,
                    success: function(response) {
                        $('#response').html('<p>' + response + '</p>');
                        $('#login-user')[0].reset();
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#response').html('<p>Error occurred. Please try again later.</p>');
                    }
                });
            });

            function loadOldMessages() {
                fetch('get_messages.php?conversation_id=' + conversationId)
                    .then(response => response.json())
                    .then(messages => {
                        chatBox.innerHTML = ''; // Clear chat box
                        messages.forEach(msg => {
                            chatBox.innerHTML += `<p><strong>${msg.username}:</strong> ${msg.message} (at ${msg.created_at})</p>`;
                        });
                        chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to bottom
                    })
                    .catch(error => console.error("Error loading messages:", error));
            }

            function connectToChat(username) {
                if (conn && (conn.readyState === 1 || conn.readyState === 0)) {
                    console.warn("WebSocket already open or connecting. Not re-establishing.");
                    return;
                }

                conn = new WebSocket('ws://localhost:8080');
                conn.onopen = function() {
                    console.log("Connection established!");
                    loadOldMessages(); // Load previous messages after connection is open
                };

                conn.onmessage = function(e) {
                    const data = JSON.parse(e.data);
                    chatBox.innerHTML += `<p><strong>${data.username}:</strong> ${data.message}</p>`;
                    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to bottom
                };

                conn.onclose = function() {
                    console.log("Connection closed!");
                };

                conn.onerror = function(e) {
                    console.error("WebSocket error:", e);
                };
            }

            // Fetch messages when the page loads
            window.onload = loadOldMessages;
        });
    </script>
</body>
</html>

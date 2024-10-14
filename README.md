# chat_application_with_WebSockets
chat_application_with_WebSockets



This code provides a functional chat application using PHP and WebSockets to enable real-time messaging. Here's a breakdown of how it works and the key components involved:

Frontend:
The frontend consists of an HTML document that manages the user interface and WebSocket connections to handle the chat functionality.

1. HTML Structure:
The layout includes two main sections:
A usernameDiv where users enter their username.
A chatDiv that contains the chatbox for messages and an input field for new messages. This div is hidden until a username is entered.
The #chat div is styled to allow messages to be displayed with auto-scrolling, and messages can be sent from the message input field or by pressing the Enter key.


2. JavaScript for WebSocket & Chat Interaction:
Username Setup: Once a user enters their username and clicks "Set Username," the input div is hidden, and the chat div is shown. The chatbox also loads old messages from the server using the fetch() API.
WebSocket Connection: The chat connects to a WebSocket server using new WebSocket('ws://localhost:8080'). When the connection is established, it logs a message to the console.
Sending Messages: When the "Send" button is clicked (or Enter is pressed), the message is sent to the WebSocket server as a JSON object that includes both the username and the message.
Receiving Messages: Incoming messages from the WebSocket server are displayed in the chatbox. It dynamically updates with each new message, and the chatbox scrolls automatically to the bottom.
Loading Old Messages: The function loadOldMessages() fetches past messages from the server (via a PHP endpoint get_messages.php) when the user enters the chat, and displays them in the chatbox.
Backend:
The backend consists of two key parts:

PHP Script for WebSocket Server.
PHP Script for Retrieving Old Messages.

1. WebSocket Server with Ratchet Library:
WebSocket Setup: The server uses the Ratchet PHP library to handle WebSocket connections.
MessageComponentInterface: This interface provides methods to manage WebSocket events like opening/closing connections, sending/receiving messages, and error handling.
onOpen(): Attaches new connections to the clients storage.
onMessage(): Handles messages received from clients. It parses the message, logs it, and sends it to all connected clients (broadcasting). It also saves the message to the database.
onClose(): Detaches connections when a client disconnects.
onError(): Logs any errors and closes the problematic connection.
Database Connection: The WebSocket server connects to a MySQL database where it stores all messages sent in the chat. This uses PHP's PDO extension to interact with the MySQL database (chat_db). The messages are saved in the messages table.
Saving Messages: Each message sent by a client is inserted into the database with the associated username.
2. PHP Script for Fetching Old Messages:
This script connects to the same MySQL database and retrieves all previous messages from the messages table. It outputs the messages in JSON format, which the frontend uses to display in the chat upon entering.
WebSocket Server Initialization:
The WebSocket server is started using IoServer::factory(), which wraps the WsServer and HttpServer from Ratchet.
It listens on port 8080 (ws://localhost:8080), allowing the WebSocket connection to communicate between the clients and the server in real time.
Summary of Flow:
A user enters their username, which initializes the WebSocket connection.
The frontend fetches old messages from the server to display in the chatbox.
When a user sends a message, it is sent via the WebSocket to the backend server, where it is broadcasted to all connected clients and saved in the database.
Messages received from other clients are displayed in the chatbox in real-time for all users connected to the WebSocket.
This setup creates a lightweight real-time chat application leveraging PHP, WebSockets, and MySQL.
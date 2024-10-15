const messageInput2 = document.getElementById("message");
const sendButton2 = document.getElementById("send");
const chatDiv = document.getElementById("chat-box");
const logoutButton = document.getElementById("logout");

const username2 = "<?php echo $_SESSION['username']; ?>"; // Pass the username from PHP

const socket = new WebSocket("ws://localhost:8080");

socket.onopen = function() {
    console.log("Connected to WebSocket server");
};

socket.onmessage = function(event) {
    const data = JSON.parse(event.data);
    const messageElement = document.createElement("div");
    messageElement.innerHTML = `<strong>${data.username}:</strong> ${data.message}`;
    chatDiv.appendChild(messageElement);
    chatDiv.scrollTop = chatDiv.scrollHeight; // Scroll to the bottom
};

sendButton2.onclick = function() {
    const message = messageInput2.value;
    socket.send(JSON.stringify({ username: username2, message: message }));
    // messageInput2.value = ""; // Clear input
};

// logoutButton.onclick = function() {
//     window.location.href = 'logout.php'; // Create logout.php for logging out
// };

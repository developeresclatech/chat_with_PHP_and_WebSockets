const messageInput = document.getElementById("message");
const sendButton = document.getElementById("send");
const chatDiv = document.getElementById("chat");
const logoutButton = document.getElementById("logout");

const username = "<?php echo $_SESSION['username']; ?>"; // Pass the username from PHP

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

sendButton.onclick = function() {
    const message = messageInput.value;
    socket.send(JSON.stringify({ username: username, message: message }));
    messageInput.value = ""; // Clear input
};

// logoutButton.onclick = function() {
//     window.location.href = 'logout.php'; // Create logout.php for logging out
// };

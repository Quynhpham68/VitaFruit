const chatIcon = document.getElementById("chat-icon");
const chatBox = document.getElementById("chat-box");
const chatMessages = document.getElementById("chat-messages");
const chatInput = document.getElementById("chat-input");
const sendBtn = document.getElementById("chat-send-btn");

// Toggle hiện/ẩn chatbox khi click icon
chatIcon.addEventListener("click", () => {
    if (chatBox.style.display === "flex") {
        chatBox.style.display = "none";
    } else {
        chatBox.style.display = "flex";
        chatInput.focus(); // tự động focus input khi mở
    }
});

// Gửi tin nhắn
sendBtn.addEventListener("click", async () => {
    const userMessage = chatInput.value.trim();
    if (!userMessage) return;

    appendMessage(userMessage, "user");
    chatInput.value = "";

    try {
        const response = await fetch("scr/user/api/chat.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ message: userMessage })
        });

        const data = await response.json();
        appendMessage(data.reply, "bot");

    } catch (error) {
        appendMessage("Xin lỗi, có lỗi xảy ra!", "bot");
    }
});

function appendMessage(text, sender) {
    const messageEl = document.createElement("div");
    messageEl.className = `message ${sender}`;
    messageEl.textContent = text;
    chatMessages.appendChild(messageEl);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

document.addEventListener("DOMContentLoaded", function () {
    const chatbotButton = document.getElementById("chatbot-button");
    const chatbotContainer = document.getElementById("chatbot-container");
    const closeChatbot = document.getElementById("close-chatbot");
    const sendMessageButton = document.getElementById("send-message");
    const chatbotInput = document.getElementById("chatbot-input");
    const chatbotMessages = document.getElementById("chatbot-messages");

    // Toggle chatbot visibility
    chatbotButton.addEventListener("click", function () {
        chatbotContainer.style.display = "flex";
    });

    closeChatbot.addEventListener("click", function () {
        chatbotContainer.style.display = "none";
    });

    // Handle message sending
    sendMessageButton.addEventListener("click", sendMessage);
    chatbotInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") sendMessage();
    });

    function sendMessage() {
        const userMessage = chatbotInput.value.trim();
        if (!userMessage) return;

        // Display user message
        chatbotMessages.innerHTML += `<div><strong>You:</strong> ${userMessage}</div>`;
        chatbotInput.value = "";

        // Fetch response from OpenAI API
        fetchChatGPTResponse(userMessage);
    }

    async function fetchChatGPTResponse(userMessage) {
        const apiKey = "YOUR_OPENAI_API_KEY";  // Replace with your OpenAI API key
        const apiUrl = "https://api.openai.com/v1/chat/completions";

        const response = await fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${apiKey}`
            },
            body: JSON.stringify({
                model: "gpt-3.5-turbo",
                messages: [{ role: "user", content: userMessage }]
            })
        });

        const data = await response.json();
        const botMessage = data.choices[0].message.content;

        // Display bot response
        chatbotMessages.innerHTML += `<div><strong>Bot:</strong> ${botMessage}</div>`;
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }
});

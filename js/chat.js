document.addEventListener('DOMContentLoaded', () => {
    const chatButton = document.getElementById('chat-widget-button');
    const chatContainer = document.getElementById('chat-widget-container');
    const closeChat = document.getElementById('close-chat');
    const chatInput = document.getElementById('chat-input');
    const chatSend = document.getElementById('chat-send');
    const chatMessages = document.getElementById('chat-messages');

    if (!chatButton || !chatContainer) return;

    chatButton.addEventListener('click', () => {
        chatContainer.classList.toggle('hidden');
    });

    closeChat.addEventListener('click', () => {
        chatContainer.classList.add('hidden');
    });

    chatSend.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') sendMessage();
    });

    async function sendMessage() {
        const text = chatInput.value.trim();
        if (!text) return;

        addMessage(text, 'user');
        chatInput.value = '';

        const typingIndicator = addMessage('...', 'bot');

        try {
            const endpoint = new URL('chat_endpoint.php', window.location.href).toString();
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    contents: [{
                        parts: [{
                            text: "You are a helpful space exploration guide for this website. Respond to the user: " + text
                        }]
                    }]
                })
            });

            let data;
            try {
                data = await response.json();
            } catch (parseError) {
                data = {
                    error: 'Invalid response from chat endpoint.',
                    details: await response.text()
                };
            }

            typingIndicator.remove();

            if (!response.ok || data.error) {
                console.error('Gemini API error:', data);
                addMessage(data.details || data.error || 'Unable to reach Gemini API.', 'bot');
            } else if (data.candidates && data.candidates[0]?.content?.parts?.[0]?.text) {
                addMessage(data.candidates[0].content.parts[0].text, 'bot');
            } else {
                addMessage("I'm sorry, I couldn't process that request.", 'bot');
            }

        } catch (error) {
            console.error("Chat Error:", error);
            typingIndicator.remove();
            addMessage(error instanceof Error ? error.message : "Error connecting to Gemini API.", 'bot');
        }
    }

    function addMessage(text, sender) {
        const msgDiv = document.createElement('div');
        msgDiv.classList.add('chat-message', `${sender}-message`);
        
        // Parse markdown if it's from the bot
        if (sender === 'bot') {
            msgDiv.innerHTML = marked.parse(text);
        } else {
            msgDiv.textContent = text; // Secure user input
        }
        
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return msgDiv;
    }
});

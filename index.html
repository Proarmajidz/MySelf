<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chatbot</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #00d9ff;
            --secondary: #7b2cbf;
            --dark: #0d1117;
            --dark-alt: #161b22;
            --text: #c9d1d9;
            --accent: #ff006e;
        }

        body {
            font-family: 'Space Mono', monospace;
            background: var(--dark);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: linear-gradient(135deg, var(--secondary) 0%, #3a0ca3 100%);
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 30px rgba(123, 44, 191, 0.4);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: repeating-linear-gradient(
                90deg,
                transparent,
                transparent 50px,
                rgba(0, 217, 255, 0.03) 50px,
                rgba(0, 217, 255, 0.03) 51px
            );
            animation: scan 8s linear infinite;
        }

        @keyframes scan {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(100px); }
        }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary) 0%, #fff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 3px;
            position: relative;
            z-index: 1;
            text-transform: uppercase;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.7);
            margin-top: 0.5rem;
            font-size: 0.9rem;
            position: relative;
            z-index: 1;
        }

        .container {
            flex: 1;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            padding: 2rem;
            display: flex;
            flex-direction: column;
        }

        .chat-box {
            flex: 1;
            background: var(--dark-alt);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            overflow-y: auto;
            border: 2px solid rgba(0, 217, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            max-height: 500px;
        }

        .message {
            margin-bottom: 1.5rem;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-header {
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .user-message .message-header {
            color: var(--primary);
        }

        .bot-message .message-header {
            color: var(--accent);
        }

        .message-content {
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            border-radius: 8px;
            line-height: 1.6;
            border-left: 3px solid;
        }

        .user-message .message-content {
            border-left-color: var(--primary);
        }

        .bot-message .message-content {
            border-left-color: var(--accent);
        }

        .input-section {
            display: flex;
            gap: 1rem;
            background: var(--dark-alt);
            padding: 1.5rem;
            border-radius: 15px;
            border: 2px solid rgba(0, 217, 255, 0.2);
        }

        #messageInput {
            flex: 1;
            background: var(--dark);
            border: 2px solid rgba(0, 217, 255, 0.3);
            color: var(--text);
            padding: 1rem;
            border-radius: 10px;
            font-family: 'Space Mono', monospace;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        #messageInput:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(0, 217, 255, 0.1);
        }

        #sendBtn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        #sendBtn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        #sendBtn:hover::before {
            left: 100%;
        }

        #sendBtn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 217, 255, 0.4);
        }

        #sendBtn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .loading {
            display: flex;
            gap: 0.5rem;
            padding: 1rem;
        }

        .loading-dot {
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .loading-dot:nth-child(1) { animation-delay: -0.32s; }
        .loading-dot:nth-child(2) { animation-delay: -0.16s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        .admin-link {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 0, 110, 0.1);
            border-radius: 10px;
            margin-top: 1rem;
        }

        .admin-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .admin-link a:hover {
            color: var(--primary);
        }

        .empty-state {
            text-align: center;
            color: rgba(255, 255, 255, 0.4);
            font-size: 1.1rem;
            padding: 3rem;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }

            .container {
                padding: 1rem;
            }

            .input-section {
                flex-direction: column;
            }

            #sendBtn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>AI Chatbot</h1>
        <p class="subtitle">Ask me anything from my knowledge base</p>
    </div>

    <div class="container">
        <div class="chat-box" id="chatBox">
            <div class="empty-state">
                👋 Welcome! Ask me anything about the information in my database.
            </div>
        </div>

        <div class="input-section">
            <input type="text" id="messageInput" placeholder="Type your message..." />
            <button id="sendBtn">Send</button>
        </div>

        <div class="admin-link">
            <a href="login.php">🔐 Admin Login</a>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chatBox');
        const messageInput = document.getElementById('messageInput');
        const sendBtn = document.getElementById('sendBtn');

        function addMessage(content, isUser) {
            const emptyState = chatBox.querySelector('.empty-state');
            if (emptyState) {
                emptyState.remove();
            }

            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
            
            messageDiv.innerHTML = `
                <div class="message-header">
                    ${isUser ? '👤 You' : '🤖 AI Assistant'}
                </div>
                <div class="message-content">${content}</div>
            `;
            
            chatBox.appendChild(messageDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function showLoading() {
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'loading';
            loadingDiv.id = 'loading';
            loadingDiv.innerHTML = `
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
                <div class="loading-dot"></div>
            `;
            chatBox.appendChild(loadingDiv);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        function hideLoading() {
            const loading = document.getElementById('loading');
            if (loading) {
                loading.remove();
            }
        }

        async function sendMessage() {
            const message = messageInput.value.trim();
            if (!message) return;

            addMessage(message, true);
            messageInput.value = '';
            sendBtn.disabled = true;
            showLoading();

            try {
                const response = await fetch('api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ message })
                });

                const data = await response.json();
                hideLoading();

                if (data.response) {
                    addMessage(data.response, false);
                } else if (data.error) {
                    addMessage(`Error: ${data.error}`, false);
                }
            } catch (error) {
                hideLoading();
                addMessage('Sorry, there was an error connecting to the server.', false);
                console.error('Error:', error);
            }

            sendBtn.disabled = false;
            messageInput.focus();
        }

        sendBtn.addEventListener('click', sendMessage);
        messageInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        messageInput.focus();
    </script>
</body>
</html>

<?php
include 'init.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
if (!isset($_REQUEST['id'])) {
    header('Location: ./');
    exit;
}
$id = intval($_REQUEST['id']);
$row = mysqli_fetch_array($conn->query('SELECT * FROM chat WHERE id = ' . $id));
if (intval($row['user']) != intval($_SESSION['id'])) {
    header('Location: ./');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=htmlspecialchars($row['title'])?> - PersonaChat</title>
    <script src="r.js"></script>
    <link rel="stylesheet" href="main.css">
    <style>
        html {
            height: 100%;
        }
        body {
            display: flex;
            flex-flow: column;
            height: 100%;
        }
        .header, .footer {
            flex: 0 1 auto;
        }
        .chat-container {
            overflow: hidden;
            text-align: left;
            flex: 1 1 auto;
            display: flex;
            flex-flow: column;
        }

        .chat-messages {
            overflow-y: auto;
            flex: 1 1 auto;
        }

        .chat {
            display: block;
        }

        .message {
            padding: 15px;
        }

        .user-message {
            background-color: #eee;
            text-align: right;
        }

        .bot-message {
            background-color: #ddd;
        }

        .user-input {
            padding: 10px;
            background-color: #f5f5f5;
        }

        #user-input {
            font-size: 1em;
            padding: 6px;
            border: none;
            border-radius: 4px;
            margin-right: 5px;
            flex-grow: 1;
        }

        .textinput {
            display: flex;
        }

        #send-btn {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-size: 1em;
        }

        a {
            color: #4CAF50;
        }

        .typing-indicator {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 10px;
            background-color: #ddd;
        }

        .typing-indicator .dot {
            content: "";
            width: 8px;
            height: 8px;
            background-color: #999;
            border-radius: 50%;
            margin-right: 8px;
            animation: typing 1s infinite;
        }

        @keyframes typing {
            0% {
                opacity: 0.5;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0.5;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="./" class="navbtn" ripple>Back</a>
        <span class="spacer"></span>
        <a href="javascript:void(0)" class="navbtn" ripple onclick="if (confirm('Delete chat?')) {window.location.href='deletechat.php?id=<?=$id?>'}">Delete Chat</a>
        <span class="spacer"></span>
        <span class="title"><?=htmlspecialchars($row['title'])?></span>
    </div>
        <div class="chat-container">
            <div id="chat-messages" class="chat-messages">
                <?php
                $res = $conn->query('SELECT * FROM message WHERE conversation = ' . $id);
                while ($row = mysqli_fetch_assoc($res)):
                    $sender_class = 'user-message';
                    if (intval($row['sender']) == 1) {
                        $sender_class = 'bot-message';
                    }
                ?>
                <div class="chat">
                    <div class="message <?=$sender_class?>"><?=htmlspecialchars($row['message'])?></div>
                </div>
                <?php
                endwhile;
                ?>
            </div>
            <form class="user-input" id="input-form">
                <div class="textinput">
                    <input type="text" id="user-input" placeholder="Type your message..." autocomplete="off" autofocus>
                    <button id="send-btn" type="submit" ripple>Send</button>
                </div>
            </form>
        </div>
    <script>
        var currentDate = new Date();
        var date = currentDate.toLocaleDateString("en-US", {
            weekday: "long",
            month: "long",
            day: "numeric",
            year: "numeric"
        });
        var numMessages = 0;
        var promptbase = `The following is a chat between a helpful AI assistant named Jane Doe and a human. Because the chatbot does not know the human's name, the chatbot will ask the human what their name is. The chat took place on ` + date + `.
<chat_desc> The chatbot will follow also refuse to talk about senses, such as taste, smell, sight, sleep, and life experience. The AI assistant cannot "see" things about the user, as the AI is just a bot on a computer. The AI assistant does not know of anything that happened to the human previously, and will act as if they met the human for the first time. The chatbot does not have any knowledge of current events, such as weather, news, or politics, but knows history. The chatbot can also write poems, essays, and short stories. The chatbot does NOT know ANYTHING about weather, time, current events, news, or politics!!! If the user says something nonsensical, the chatbot will politely notify the human that it doesn't understand the human.
The prompting format for the conversation is:
### Human:
[Message]

### Bot:
[Message]

* * *

The following is the conversation:
`
        <?php
        $res = $conn->query('SELECT * FROM message WHERE conversation = ' . $id);
        while ($row = mysqli_fetch_assoc($res)):
            $sender_class = 'Human';
            if (intval($row['sender']) == 1) {
                $sender_class = 'Bot';
            }
        ?>
        promptbase += "### <?=$sender_class?>\n" + <?=json_encode($row['message'])?> + "\n\n";
        <?php
        endwhile;
        ?>
        promptbase += "### Human:\n"
        var prompt = promptbase;
        document.addEventListener('DOMContentLoaded', function () {
            const chatMessages = document.getElementById('chat-messages');
            const userInput = document.getElementById('user-input');
            const sendButton = document.getElementById('send-btn');
            const inputForm = document.getElementById('input-form');

            inputForm.addEventListener('submit', sendMessage);

            function sendMessage(event) {
                event.preventDefault();
                const userInputValue = userInput.value.trim();
                if (userInputValue === '') {
                    return;
                }
                numMessages++;
                sendButton.setAttribute('disabled', true);
                prompt += userInputValue + "\n\n### Bot:\n"
                addMessage(userInputValue, 'user');
                userInput.value = '';

                showTypingIndicator();

                fetch('api.php?id=<?=$id?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ prompt: prompt, message: userInputValue })
                })
                    .then(response => response.json())
                    .then(data => {
                        const botResponse = data.bot_response.trim();
                        console.log('* Responded *')
                        console.log(botResponse)
                        prompt += botResponse + "\n\n### Human:\n"
                        removeTypingIndicator();
                        sendButton.removeAttribute('disabled');
                        addMessage(botResponse, 'bot');
                        numMessages++;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
            chatMessages.scrollTop = chatMessages.scrollHeight;
            function addMessage(message, sender) {
                const chatContainer = document.createElement('div');
                chatContainer.classList.add('chat');

                const messageContainer = document.createElement('div');
                messageContainer.classList.add('message');
                messageContainer.classList.add(sender === 'user' ? 'user-message' : 'bot-message');
                messageContainer.textContent = message;

                chatContainer.appendChild(messageContainer);

                chatMessages.appendChild(chatContainer);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function showTypingIndicator() {
                const typingIndicator = document.createElement('div');
                var dot1 = document.createElement('div');
                dot1.classList.add('dot');
                dot1.style.animationDelay = '0s';
                typingIndicator.appendChild(dot1);
                var dot2 = document.createElement('div');
                dot2.classList.add('dot');
                dot2.style.animationDelay = '0.5s';
                typingIndicator.appendChild(dot2);
                var dot3 = document.createElement('div');
                dot3.classList.add('dot');
                dot3.style.animationDelay = '1s';
                typingIndicator.appendChild(dot3);
                typingIndicator.classList.add('typing-indicator');
                // typingIndicator.textContent = '...';

                chatMessages.appendChild(typingIndicator);
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function removeTypingIndicator() {
                const typingIndicator = document.querySelector('.typing-indicator');
                if (typingIndicator) {
                    typingIndicator.remove();
                }
            }
        });
        var upvoted = false;
        function upvote() {
            if (upvoted == false) {
                if (numMessages >= 2) {
                    if (confirm('By sending your vote, you agree to the Voting policy.')) {
                        upvoted = true;
                        document.getElementById('votebtn').classList.add('done');
                        document.getElementById('votetext').innerText = 'Upvoting...';
                        fetch('/vote', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ prompt: prompt })
                        })
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('votetext').innerText = 'Thanks!';
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    } else {
                        alert('Your vote has not been collected.')
                    }
                } else {
                    alert('Sorry, you must have at least 2 messages before you can upvote this conversation.')
                }
            }
        }
        function resetChat() {
            prompt = promptbase;
            document.getElementById('chat-messages').innerHTML = '';
            alert('Chat context reset.');
        }
    </script>
</body>
</html>
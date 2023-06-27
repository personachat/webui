<?php
include 'init.php';
if (!isset($_SESSION['loggedin'])):
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PersonaChat</title>
    <script src="r.js"></script>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="header">
        <span class="title">PersonaChat</span>
        <span class="spacer"></span>
        <a href="login.php" class="navbtn" ripple>Login</a>
    </div>
    <div class="hero">
        <h1>PersonaChat</h1>
        <h2>Chat with your own <span class="em">personalized</span> AI persona!</h2>
        <a href="login.php" class="button" ripple>Get Started</a>
    </div>
    <div class="footer">
        <p>&copy; 2023 PersonaChat. All rights reserved. PersonaChat is an <a href="https://github.com/personachat/PersonaChat" target="_blank">open-sourced project</a>!</p>
    </div>
</body>
</html>
<?php
else:
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversations - PersonaChat</title>
    <script src="r.js"></script>
    <link rel="stylesheet" href="main.css">
    <style>
        .main {
            padding: 10px 25px;
        }
        .conversation {
            display: block;
            padding: 10px 25px;
            background: #0073ff;
            color: white;
            text-decoration: none;
            border-radius: 15px;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <span class="title">PersonaChat</span>
        <span class="spacer"></span>
        <a href="logout.php" class="navbtn" ripple>Logout</a>
    </div>
    <?php
    $res = $conn->query("SELECT * FROM chat WHERE user = " . intval($_SESSION['id']));
    if (mysqli_num_rows($res) == 0):
    ?>
    <div class="hero">
        <h1>Welcome to PersonaChat!</h1>
        <h2>You don't seem to have any conversations yet.</h2>
        <a href="new.php" class="button" ripple>Start Chatting</a>
    </div>
    <?php
    else:
    ?>
    <div class="main">
        <h1>Conversations</h1>
        <a href="new.php" class="button" ripple>+ New Chat</a>
        <?php
        while ($row = mysqli_fetch_assoc($res)):
        ?>
        <a href="chat.php?id=<?=intval($row['id'])?>" class="conversation" ripple><?=htmlspecialchars($row['title'])?></a>
        <?php
        endwhile;
        ?>
    </div>
    <?php
    endif;
    ?>
    <div class="footer">
        <p>&copy; 2023 PersonaChat. All rights reserved. PersonaChat is an <a href="https://github.com/personachat/PersonaChat" target="_blank">open-sourced project</a>!</p>
    </div>
</body>
</html>
<?php
endif;
<?php
include 'init.php';
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}
if (!empty($_POST['name']) && isset($_POST['personality'])) {
    $name = $_POST['name'];
    $personality = intval($_POST['personality']);
    $uid = intval($_SESSION['id']);
    # check if personality exists
    if (mysqli_num_rows($conn->query("SELECT * FROM bot WHERE id = $personality")) > 0) {
        $stmt = $conn->prepare("INSERT INTO chat (title, user, bot) VALUES (?, $uid, $personality)");
        $stmt->bind_param('s', $name);
        $stmt->execute();
        header('Location: chat.php?id=' . $conn->insert_id);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Chat - PersonaChat</title>
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
        <a href="./" class="navbtn" ripple>Back</a>
        <span class="spacer"></span>
        <span class="title">New Chat</span>
    </div>
    <div class="hero">
        <h1>New Chat</h1>
        <form method="post">
            <p>Name this chat</p>
            <p><input type="text" required placeholder="You can't change this later" autofocus name="name"></p>
            <p>Select a personality</p>
            <p><select required name="personality">
                <?php
                $res = $conn->query('SELECT * FROM bot');
                while ($row = mysqli_fetch_assoc($res)):
                    $s = '';
                    if (intval($row['id']) == 1) {
                        $s = ' selected';
                    }
                ?>
                <option value="<?=intval($row['id'])?>"<?=$s?>><?=htmlspecialchars($row['name'])?></option>
                <?php
                endwhile;
                ?>
            </select></p>
            <button type="submit" class="button" ripple>Create</button>
        </form>
    </div>
    <div class="footer">
        <p>&copy; 2023 PersonaChat. All rights reserved. PersonaChat is an <a href="https://github.com/personachat/PersonaChat" target="_blank">open-sourced project</a>!</p>
    </div>
</body>
</html>
<?php
include 'init.php';
if (isset($_SESSION['loggedin'])) {
    header('Location: ./');
    exit;
}
$wrong = false;
if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = trim(strtolower($_POST['email']));
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT * FROM user WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if (mysqli_num_rows($res) == 0) {
        $wrong = true;
    } else {
        while ($row = mysqli_fetch_assoc($res)) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = intval($row['id']);
                $_SESSION['email'] = $email;
                header('Location: ./');
                exit;
            } else {
                $wrong = true;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="r.js"></script>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="header">
        <a href="./" class="navbtn" ripple>Back</a>
    </div>
    <?php
    if ($wrong):
    ?>
    <div class="error">
        <p>Sorry, your email or password was wrong. Please try again.</p>
    </div>
    <?php
    endif;
    ?>
    <div class="hero">
        <h1>Login to PersonaChat</h1>
        <form method="post">
            <p>What's your email address?</p>
            <p><input type="email" required placeholder="Email address..." autofocus name="email"></p>
            <p>What's your password?</p>
            <p><input type="password" required placeholder="Password..." name="password"></p>
            <button type="submit" class="button" ripple>Login</button>
        </form>
    </div>
    <div class="footer">
        <p>&copy; 2023 PersonaChat. All rights reserved. PersonaChat is an <a href="https://github.com/personachat/PersonaChat" target="_blank">open-sourced project</a>!</p>
    </div>
</body>
</html>
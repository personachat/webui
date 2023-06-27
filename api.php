<?php
include 'init.php';
if (!isset($_SESSION['loggedin'])) {
    die('NOT_LOGGED_IN');
}
if (!isset($_REQUEST['id'])) {
    die('NO_ID');
}
$id = intval($_REQUEST['id']);
$row = mysqli_fetch_array($conn->query('SELECT * FROM chat WHERE id = ' . $id));
if (intval($row['user']) != intval($_SESSION['id'])) {
    exit;
}
$_POST = json_decode(file_get_contents('php://input'), true);
if (empty($_POST['prompt']) || empty($_POST['message'])) {
    die('NO_PROMPT or NO_MESSAGE');
}
$uid = intval($_SESSION['id']);
session_write_close();
header('Content-Type: text/json');
$data = array('prompt' => $_POST['prompt']);
$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($api_endpoint, false, $context);
if ($result === false) {
    die('Error');
}
$stmt = $conn->prepare("INSERT INTO message (conversation, message, sender) VALUES ($id, ?, 0)");
$stmt->bind_param('s', $_POST['message']);
$stmt->execute();
$message = json_decode($result, true)['bot_response'];
$stmt = $conn->prepare("INSERT INTO message (conversation, message, sender) VALUES ($id, ?, 1)");
$stmt->bind_param('s', $message);
$stmt->execute();
echo $result;
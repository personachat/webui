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
$conn->query("DELETE FROM chat WHERE id = $id");
$conn->query("DELETE FROM message WHERE conversation = $id");
header('Location: ./');
exit;
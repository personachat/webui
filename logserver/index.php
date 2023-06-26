<?php
include '../config.php';
if (!$conn) {
    die('mysql error');
}
if (!empty($_REQUEST['log'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $confidence = 1;
    if (!$ip) {
        // $ip = $_SERVER['HTTP_CLIENT_IP'];
        // $confidence = 0;
        die('unable to acquire ip');
    }
    $log = trim($_REQUEST['log']);
    $stmt = $conn->prepare('INSERT INTO logs (ip, ipconfidence, log) VALUES (?, ?, ?)');
    $stmt->bind_param('sis', $ip, $confidence, $log);
    $stmt->execute();
    die('ok');
} else {
    die('parameter "log" is empty');
}
die('unexpected error');
<?php
include '../config.php';
$file = fopen('dump.csv', 'w');
fputcsv($file, ['data']);
$res = $conn->query('SELECT * FROM logs');
while ($row = mysqli_fetch_assoc($res)) {
    fputcsv($file, [$row['log']]);
}
fclose($file);
header('Content-Type: text/csv');
header("Content-Transfer-Encoding: utf-8"); 
header("Content-disposition: attachment; filename=dump.csv"); 
readfile('dump.csv');
unlink('dump.csv');
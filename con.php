<?php
$host = 'COMPLETE';
$username1 = 'COMPLETE';
$database = 'initial_db';
$password1 = 'COMPLETE';
$conn = new mysqli($host, $username1, $password1, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$conn->set_charset("utf8");
?>

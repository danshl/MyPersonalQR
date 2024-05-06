<?php
require '../conf1.php';

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    $username = $data->username;

    $query = "SELECT username FROM info WHERE username = '$username'";
    $result = $conn->query($query);

    
    if ($result->num_rows === 1) {
        $available = false;
    } else {
        $available = true;
    }

    $response = [
        'available' => $available,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>



<?php

require '../conf1.php'; 
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $facebook = $_POST['facebook'];
    $username = $_POST['username'];

    $query = "SELECT session_id FROM info WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$username]);
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $dbSessionId = $row['session_id'];
        if ($_SESSION['aut'] === $dbSessionId) {
            $updateQuery = "UPDATE info SET name = ?, email = ?, phone = ?, address = ?, country = ?, facebook = ? WHERE username = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->execute([$name, $email, $phone, $address, $country, $facebook, $username]);
            echo json_encode("Your data has been successfully updated! Please log out and log in again to see the changes.");
        } else {
            echo json_encode('Session ID mismatch. Data not saved.');
        }
        
    } else {
        echo json_encode(['error' => 'User not found.']);
    }
} else {
    http_response_code(400);
    echo 'Invalid request';
}

?>

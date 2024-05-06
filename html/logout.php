<?php
session_start();

if (isset($_SESSION['user_full_name'])) {
    require '../conf1.php';
    $stmt = $conn->prepare("UPDATE info SET session_id = NULL WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user_username']);
    $stmt->execute();
    session_unset();
    session_destroy();
}

header("Location: Home.php");
?>


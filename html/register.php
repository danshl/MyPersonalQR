<?php
session_start();
$sessionTimeout = 1800;

require '../conf1.php';

$name = $_POST['new-name'];
$email = $_POST['new-email'];
$new_username = $_POST['new-username'];
$new_password = $_POST['new-password'];
$phone = $_POST['new-phone'];
$country = $_POST['new-country'];
$address = $_POST['new-address'];
$facebook = $_POST['new-facebook'];
$session_id = bin2hex(random_bytes(16));

$hashedPassword = md5($new_password);

$query = "INSERT INTO info (name, email, username, password, phone, country, address, facebook, session_id) VALUES ('$name', '$email', '$new_username', '$hashedPassword', '$phone', '$country', '$address', '$facebook', '$session_id')";
$qu = "UPDATE info SET session_id = '$session_id' WHERE username = '$new_username'";
$conn->query($qu);
$_SESSION['aut'] = $session_id;
if ($conn->query($query) === TRUE) {
    $_SESSION['user_username'] = $new_username;
    $_SESSION['user_full_name'] = $name;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_phone'] = $phone;
    $_SESSION['user_address'] = $address;
    $_SESSION['user_country'] = $country;
    $_SESSION['user_facebook'] = $facebook;
    $_SESSION['LAST_ACTIVITY'] = time();
    $conn->close();
    header("Location: Home.php");
    exit;
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}


$conn->close();
?>

<?php
ini_set('session.gc_maxlifetime', 1800);
session_start();
require '../conf1.php';

$attemptsLimit = 3; 
$blockTime = 60; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (isset($_SESSION['blocked_until']) && $_SESSION['blocked_until'] > time()) {
        $errorMessage = "You are blocked. Please try again later.";
        echo '<script>';
        echo 'alert("' . $errorMessage . '");';
        echo 'window.location.href = "Home.php?response=error&message=' . urlencode($errorMessage) . '";';
        echo '</script>';
        exit();
    }
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM info WHERE username = ? AND password = ?");
    $hashedPassword = md5($password);
    $stmt->bind_param("ss", $username, $hashedPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user_data = $result->fetch_assoc();
        $randomString = bin2hex(random_bytes(16));
        $_SESSION['aut'] = $randomString;
        $stmt1 = $conn->prepare("UPDATE info SET session_id = ? WHERE username = ?");
        $stmt1->bind_param("ss", $randomString, $username);
        $stmt1->execute();

        $_SESSION['user_username'] = $user_data['username'];
        $_SESSION['user_full_name'] = $user_data['name'];
        $_SESSION['user_email'] = $user_data['email'];
        $_SESSION['user_phone'] = $user_data['phone'];
        $_SESSION['user_address'] = $user_data['address'];
        $_SESSION['user_country'] = $user_data['country'];
        $_SESSION['user_facebook'] = $user_data['facebook'];
        $_SESSION['LAST_ACTIVITY'] = time();
        //Problem_2 - fix;
        $_SESSION['login_attempts'] = 0;  
        unset($_SESSION['blocked_until']);
        $conn->close();
        header("Location: pattern_details.php?name=" . urlencode($user_data['name']) . "&email=" . urlencode($user_data['email']) . "&phone=" . urlencode($user_data['phone']) . "&country=" . urlencode($user_data['country']) . "&address=" . urlencode($user_data['address']) . "&facebook=" . urlencode($user_data['facebook']));
        exit();
    } 
    else {
        $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1; 
        if ($_SESSION['login_attempts'] >= $attemptsLimit) {
            $_SESSION['blocked_until'] = time() + $blockTime;
            header("Location: Home.php?remainingTime=" . $blockTime);
            exit();
        } else {
            $errorMessage = "Login failed. Please check your credentials.";
            echo '<script>';
            echo 'alert("' . $errorMessage. '");';
            echo 'window.location.href = "Home.php?response=error&message=' . urlencode($errorMessage) . '";';
            echo '</script>';
            exit();
        }
    }

    $stmt->close();
    $conn->close();
}
?>

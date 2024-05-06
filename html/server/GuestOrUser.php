<?php
  require '/var/www/con.php';
  session_start();
  $sessionTimeout = 1800; 
  // Check if the session is active
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $sessionTimeout) {
    $stmt = $conn->prepare("UPDATE info SET session_id = NULL WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user_username']);
    $stmt->execute();
      session_unset();
      session_destroy();
  }
  $_SESSION['LAST_ACTIVITY'] = time();
  //Check block state
  //problem_1
  if (isset($_GET['remainingTime'])) {
      $remainingTime = $_GET['remainingTime'];
      echo '<script>';
      echo 'alert("You are currently blocked. Please try again after ' . $remainingTime . ' seconds.");';
      echo '</script>';
  }
  ?>
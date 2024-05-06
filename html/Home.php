<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/x-icon" href="fav.ico">
  <link rel="stylesheet" type="text/css" href="cssFiles/Homedesign2.css">
  <meta charset="UTF-8">
  <title> #Helpfindmyitem</title>
</head>

<body>
<!-- Button guest or user -->
<?php
  require '/var/www/conf1.php';
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

<!-- defines buttons - 'Back', 'Logout' ,'Scan me' and 'Hello guest' -->
<span class="welcome-message">Welcome, <?php echo isset($_SESSION['user_full_name']) ? $_SESSION['user_full_name'] . '!' : 'Guest!'; ?></span>
<div class="title" id="title" style="bottom: 100px;  font-family: 'Serif Font', serif;">Create your own QR!</div>
  <button class="circle" id="scanButton" style="left:-290px;" >Found a item ? Scan me</button>
  <a href="logout.php" id="Logout">Logout</a>
  <a href="Home.php" id="backButton">Back ></a>
  <?php
  if (isset($_SESSION['user_full_name'])) {
    $email = $_SESSION['user_email'];
    $phone = $_SESSION['user_phone'];
    $address = $_SESSION['user_address'];
    $country = $_SESSION['user_country'];
    $facebook = $_SESSION['user_facebook'];
    $name = $_SESSION['user_full_name'];
    $url = "pattern_details.php?name=$name&email=$email&phone=$phone&address=$address&country=$country&facebook=$facebook"; 
  }
  ?>
  <?php if (isset($url)) : ?>
      <a href="<?php echo $url; ?>" id="Myd">My Details</a>
  <?php endif; ?>

<!-- show and dont show - 'logout' button -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    if (<?php echo isset($_SESSION['user_full_name']) ? 'true' : 'false'; ?>) {
        // If the session variable 'user_full_name' is set, show the Logout button and hide other elements.
        document.getElementById('Logout').style.display = 'inline-block';
        document.getElementById('join_button').style.display = 'none';
        document.getElementById('title').style.left = '240px';
    }
});
</script>


<!-- defines button 'Join' -->
<div> <button class="circle" id="join_button">New here ? Let's join</button>  </div>

<script>
  // "Back" button to visible 
  const triggerElement = document.getElementById('join_button'); 
  const backButton = document.getElementById('backButton');
  triggerElement.addEventListener('click', function() {
      backButton.style.display = 'inline-block';
  });
  // "Back" button to hide it when clicked
  backButton.addEventListener('click', function() {
      titleElement.textContent =''; //prevent the side afffect after the Back pressed;
      backButton.style.display = 'none';
  });
</script>

<!-- define login-box !-->
<div class="login-box" id="login-box">
  <h2 style="text-align: center; margin: 0 auto; font-family: 'Serif Font', serif;">Login</h2>
  <br> </br>
  <form action="login.php" method="post" id="login-form">

    <div style="display: flex; flex-direction: column;">
      <div style="display: flex; align-items: center;">
        <label for="username" style="flex: 1;">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div style="display: flex; align-items: center;">
        <label for="password" style="flex: 1;">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
    </div>
    <br> </br>
    <button type="submit" id="login-button">Log In</button>
    <button id="register">New here? Sign up</button>
    
  </form>
</div>

<!-- define sign-up button !-->
<div class="signup-modal" id="signup-modal">
<h2 style="text-align: center; margin: 0 auto;">Sign Up</h2>
<br></br>
<br></br>

<!-- define available username !-->
<div id="availability-message" style="text-align: center; color: red; position:absolute; top:60px; left:150px;"></div>

<!-- define register-box !-->
<form action="register.php" method="post" accept-charset="UTF-8" id="registration-form">
  <div style="display: flex; flex-direction: column;">
    <div style="display: flex; align-items: center;">
      <label for="new-name" style="flex: 1;">Full Name:</label>
      <input type="text" id="new-name" name="new-name" >
    </div>

    <div style="display: flex; align-items: center;">
      <label for="new-email" style="flex: 1;">Email:</label>
      <input type="text" id="new-email" name="new-email" >
    </div>

    <div style="display: flex; align-items: center;">
    <label for="new-username" style="flex: 1;">Username:</label>
    <input type="text" id="new-username" name="new-username" required>
    <span id="availability-message"></span>
    </div>

    <div style="display: flex; align-items: center;">
      <label for="new-password" style="flex: 1;">Password:</label>
      <input type="password" id="new-password" name="new-password" required>
      <span id="password-validation-message" style="color: red;"></span>
    </div>

    <div style="display: flex; align-items: center;">
      <label for="new-phone" style="flex: 1;">Phone:</label>
      <input type="phone" id="new-phone" name="new-phone">
    </div>

    <div style="display: flex; align-items: center;">
      <label for="new-country" style="flex: 1;">Country:</label>
      <input type="country" id="new-country" name="new-country">
    </div>

    <div style="display: flex; align-items: center;">
      <label for="new-address" style="flex: 1;">Full Address:</label>
      <input type="address" id="new-address" name="new-address" >
    </div>

    <div style="display: flex; align-items: center;">
      <label for="new-facebook" style="flex: 1;">Facebook:</label>
      <input type="facebook" id="new-facebook" name="new-facebook" >
      <br></br>
    </div>
  </div>
  <button type="submit" id="reg" class="register-button">Register</button>
</form>
  </div>

<!-- alert created account !-->
<div id="custom-alert" class="custom-alert">
    <span>Your account has been created. Please log in.</span>
</div>

<!-- Check two conditions - username is valid and password is strong -->
<script>
  //min fill - username and password
  document.addEventListener('DOMContentLoaded', function () {
  const usernameInput = document.getElementById('new-username');
  const passwordInput = document.getElementById('new-password');
  const registerButton = document.getElementById('reg');
  registerButton.disabled = true;
  usernameInput.addEventListener('input', checkFields);
  passwordInput.addEventListener('input', checkFields);
  function checkFields() {
      const username = usernameInput.value.trim();
      const password = passwordInput.value.trim();
  }
});

  $check1 = false;
  $check2 = false;
  //Check if the username is free and password is strong
  function checkConditions() {
    if ($check1 && $check2) {
      const registerButton = document.getElementById('reg');
      registerButton.disabled = false;
      registerButton.classList.remove('disabled');
    } 
    else {
      const registerButton = document.getElementById('reg');
      registerButton.disabled = true;
      registerButton.classList.add('disabled');
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    const usernameInput = document.getElementById('new-username');
    const passwordInput = document.getElementById('new-password');

    //Check the username
    usernameInput.addEventListener('input', function () {
      const username = usernameInput.value.trim();
      if (username) {
          checkUsernameAvailability(username);
      } else {
          availabilityMessage.textContent = '';
      }
    })
    
    function checkUsernameAvailability(username) {
    const availabilityMessage = document.getElementById('availability-message');
    const endpoint = 'check-username-availability.php';
    fetch(endpoint, {
        method: 'POST',
        body: JSON.stringify({ username }),
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.available) {
            availabilityMessage.textContent = '·Username is available!';
            availabilityMessage.style.color = 'green';
            availabilityMessage.style.top = 20;
            availabilityMessage.style.fontSize = '16px';
            $check2 = true;
            checkConditions();

        } else {
            availabilityMessage.textContent = '·Username is already taken.';
            availabilityMessage.style.color = 'red';
            $check2 = false;
            checkConditions();

        }
    })
    .catch((error) => {
        console.error('Error checking username availability:', error);
        availabilityMessage.textContent = 'Error checking availability';
        availabilityMessage.style.color = 'red';
    });
  }

    //Check the password
    passwordInput.addEventListener('input', function () {
    const password = passwordInput.value.trim();
    const isValidPassword = validatePassword(password);
    const passwordValidationMessage = document.getElementById('password-validation-message');

    if (!isValidPassword) {
      passwordValidationMessage.textContent = 'Password must include 8 characters with a mix of uppercase, lowercase, numbers, and special characters.';
      passwordValidationMessage.style.color = 'red';
      passwordValidationMessage.style.fontSize = '14px'; 
      passwordValidationMessage.style.position = 'absolute'; 
      passwordValidationMessage.style.top = '80px'; 
      passwordValidationMessage.style.left = '10px'; 
      $check1 = false;
      checkConditions();
    }
    else {
      passwordValidationMessage.textContent = '·Good! Strong password.';
      passwordValidationMessage.style.color = 'green';
      passwordValidationMessage.style.fontSize = '16px';
      passwordValidationMessage.style.left = '150px';
      $check1 = true;
      checkConditions();
    }
  });
        
  function validatePassword(password) {
    const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?=.{8,})/;
    return passwordRegex.test(password);
  }

    });
</script>

<script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>

<!-- define qrcode-image !-->
<div id="qrcode" style="display: none;"></div> 

<!-- For create and save a QR  !-->
<script>
    const generateQRCodeAndSave = function () {
      const username = document.getElementById('new-username').value;
      const email = document.getElementById('new-email').value;
      const url = `https://www.helpfindmyitem.com/info.php?user=${username}`;

      // Generate the QR code for the URL
      const qrcode = new QRCode(document.getElementById('qrcode'), {
          text: url,
          width: 128,
          height: 128,
      });
      // Convert the QR code to an image
      const qrCodeImage = qrcode._el.childNodes[0];
      const canvas = document.createElement('canvas');
      canvas.width = qrCodeImage.width;
      canvas.height = qrCodeImage.height;
      const context = canvas.getContext('2d');
      context.drawImage(qrCodeImage, 0, 0, qrCodeImage.width, qrCodeImage.height);
      const dataURL = canvas.toDataURL('image/png');
      saveQRCodeImageOnServer(dataURL,username);
  };

    // Function to send the QR code image data to the server for saving
  const saveQRCodeImageOnServer = function(imageData,username) {
    const formData = new FormData();
    formData.append('username', username);
    formData.append('qrcode_image', imageData);
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_qrcode.php', true);
    xhr.onload = function() {
    if (xhr.status !== 200) {
      alert('QR code image saving failed');
    }
  };
    xhr.send(formData);
  };
</script>

<!-- changes of buttons by specific situation!-->
<script>
document.addEventListener('DOMContentLoaded', function() { 
  const registerButton = document.getElementById('register');
  registerButton.addEventListener('click', function() {
    event.preventDefault();
    const loginBox = document.querySelector('.login-box');
    loginBox.style.display = 'none';

    const signupModal = document.getElementById('signup-modal');
    signupModal.style.display = 'block';

    titleText.style.left = "470px";
    titleText.style.top = "-370px";
});

  const scanButtonElement = document.getElementById('scanButton');
  scanButtonElement.addEventListener('click', function() {
    event.preventDefault();
    const backButton = document.getElementById('backButton');
    backButton.style.display = 'block'; 
    backButton.style.left = '300px'; 
    backButton.style.top = '360px'; 
});

  const regButton = document.getElementById('reg');
  regButton.addEventListener('click', function() {
      generateQRCodeAndSave();
      alert("Your account has been created. You will now be redirected to the Home page.");
  });

});
</script>

<!-- define camera for scan QR !-->
<video id="cameraView" autoplay hidden style="position: fixed; top: 100; left: 600px;"></video>
<script src="jsQR-master/docs/jsQR.js"></script>

<script>
  const titleElement = document.getElementById('title');
  const text = titleElement.textContent;
  titleElement.textContent = '';
  let index = 0;
  const interval = 1000 / text.length; 
  function animateText() {
    if (index < text.length) {
      titleElement.textContent += text[index];
      index++;
      setTimeout(animateText, interval);
    }
}
animateText();
</script>

<!-- calculate login_attempt and block by time !-->
<script>
    <?php
    $isLoginAttemptsSet = isset($_SESSION['login_attempts']);
    ?>

    if (<?php echo $isLoginAttemptsSet ? 'true' : 'false'; ?>) {
      if ( <?php echo  $_SESSION['login_attempts'] >=3  ?>){
        const signupModal = document.querySelector('.login-box');
        signupModal.style.boxShadow = '0 0 10px 2px red';
      }
    }
    <?php
    $blockedUntil = (int)$_SESSION['blocked_until']; 
    $currentTime = time(); 
    $isTimeToReturnToGreen = $blockedUntil < ($currentTime + 60);
    ?>
</script>

<!-- changes of buttons by specific situation!-->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const response = urlParams.get('response');
    const message = urlParams.get('message');
    if (response === 'error' && message) {
      const newItemButton = document.getElementById('join_button');
      newItemButton.click();    
    }
  });

  const c1 = document.getElementById('join_button');
  c1.addEventListener('click', function () {
    moveTextWithAnimation1();
    openModal();
  });
  function moveTextWithAnimation1() {
    colorChangeButton1.style.visibility = 'hidden';
    colorChangeButton2.style.visibility = 'hidden';
    topPosition = -200;
    titleText.style.top = "-280px";
    titleText.style.left = "460px";
  }
  function openModal() {
    const loginBox = document.querySelector(".login-box");
    loginBox.style.display = "block";
  }
</script>


<!-- scan the qr and present the text -->
<script>
  const colorChangeButton1 = document.getElementById('scanButton');
  const colorChangeButton2 = document.getElementById('join_button');
  const titleText = document.getElementById('title');
  let topPosition = 0;
  const initialTop = parseInt(getComputedStyle(titleText).top, 10);
  colorChangeButton1.addEventListener('click', function () {
    moveTextWithAnimation();
    document.getElementById('cameraView').style.display = 'block';
    titleElement.textContent = 'Scan the QR';
    openCameraAndScanQR();
  });

  
  <?php
    $leftStyle = isset($_SESSION['user_full_name']) ? '360px' : '530px';
  ?>
  function moveTextWithAnimation() {
      colorChangeButton1.style.visibility = 'hidden';
      colorChangeButton2.style.visibility = 'hidden';
      topPosition = -220; 
      titleText.style.top = `${initialTop + topPosition}px`;
      titleText.style.left = '<?php echo $leftStyle; ?>';
  }


  

  function openCameraAndScanQR() {
    let continueScanning = true; 
    setTimeout(function () {
      navigator.mediaDevices.getUserMedia({ video: true })
        .then(function (stream) {
          cameraView.srcObject = stream;
          const canvasElement = document.createElement('canvas');
          const canvas = canvasElement.getContext('2d');
          const video = cameraView;
          video.addEventListener('play', function () {
            const videoWidth = video.videoWidth;
            const videoHeight = video.videoHeight;
            const minDimension = Math.min(videoWidth, videoHeight);

            canvasElement.width = minDimension; 
            canvasElement.height = minDimension;
          });

        function scanQRCode() {
          if (!continueScanning) {
            const messageElement = document.createElement('div');
            messageElement.innerText = 'Please wait - creating a secure connection...';
            messageElement.classList.add('loading-message');
            document.body.appendChild(messageElement);
            return;
          }

          canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
          const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
          const code = jsQR(imageData.data, imageData.width, imageData.height);

          if (code) {
            const url = code.data;
            console.log('QR code found');
            console.log(url);
            window.location.href = url;
            continueScanning = false;
          } else {
            console.log('QR code not found');
          }
          requestAnimationFrame(scanQRCode);
        }
        scanQRCode();
      })
      .catch(function (error) {
        console.error('Error accessing camera:', error);
      });
    }, 1000); 
  }

</script>
</body>
</html>

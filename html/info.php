<?php
session_start();

require '../conf1.php';

$username1 = $_GET['user'];

// Fetch user data from the database
$stmt = $conn->prepare("SELECT * FROM info WHERE username = ?");
$stmt->bind_param("s", $username1);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user_data = $result->fetch_assoc();
    $username = $user_data['username'];
    $name = $user_data['name'];
    $email = $user_data['email'];
    $phone = $user_data['phone'];
    $address= $user_data['address'];
    $country = $user_data['country'];
    $facebook = $user_data['facebook'];
}

echo "<img src='../../info/$username1.png' id='m_image' alt='My Image'>";
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/x-icon" href="images/fav.ico">
<link rel="stylesheet" type="text/css" href="cssFiles/infodesign.css">
</head>

<body>

    <div class="title" id="title">#Helpfindmyitem</div>
    <a href="../../Home.php" id="backButton">Back ></a>
    <button id="printQRButton">Print your QR </button>

    <div class="info-box">
        <p>Details</p>
        <p>Name: <?php echo $name; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <p>Phone: <?php echo $phone; ?></p>
        <p>Country: <?php echo $country; ?></p>
        <p>Address: <?php echo $address; ?></p>
        <p>Facebook: <?php echo $facebook; ?></p>
    </div>

    <script>
        function printQRCode() {
            const qrImage = document.getElementById('m_image');
            const printWindow = window.open('', '', 'width=600,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Print QR Code</title></head><body>');
            printWindow.document.write('<img src="' + qrImage.src + '" style="width: 250px; height: 250px;">');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
        const printQRButton = document.getElementById('printQRButton');
        printQRButton.addEventListener('click', printQRCode);
    </script>
</body>
</html>

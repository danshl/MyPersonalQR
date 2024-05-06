<?php

$qrcodeImage = $_POST['qrcode_image'];
$username = $_POST['username'];
$filename = $username . '.png';
$directory = 'info';

if (!is_dir($directory)) {
    if (!mkdir($directory, 0755, true)) {
        echo 'Failed to create the "info" directory.';
        exit;
    }
}

$savePath = $directory . '/' . $filename; 

if (file_put_contents($savePath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrcodeImage))) !== false) {
    echo 'QR code image saved as ' . $filename . ' in directory: ' . $savePath;
} 
else {
    echo 'Failed to save the QR code image. Directory: ' . $savePath;
}

sleep(5);

?>

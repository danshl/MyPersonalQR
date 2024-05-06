<?php
    session_start();
    $email = $_SESSION['user_email'];
    $phone = $_SESSION['user_phone'];
    $address = $_SESSION['user_address'];
    $country = $_SESSION['user_country'];
    $facebook = $_SESSION['user_facebook'];
    $name = $_SESSION['user_full_name'];
    $username_ = $_SESSION['user_username'];
    echo "<img src='../../info/$username_.png' id='m_image' alt='My Ima'>";
    require '../conf1.php';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="cssFiles/pattern_detailsdesign1.css">
    <link rel="icon" type="image/x-icon" href="images/fav.ico">
</head>

<body>
    <div class="title" id="title">#Helpfindmyitem</div>
    <a href="../../Home.php" id="backButton">Back ></a>
    <div class="buttons">
        <button id="printQRButton">Print your QR</button>
        <button id="editButton" onclick="toggleEditSave('editButton', 'saveButton')">Edit</button>
        <button id="saveButton" style="display: none;" onclick="toggleEditSave('saveButton', 'editButton')" method="post">Save</button>
    </div>
    <div class="info-box">
        <p>Details</p>
        <p><strong>Name:</strong> <span class="editable" id="name" contenteditable="false"><?php echo $name; ?></span></p>
        <p><strong>Email:</strong> <span class="editable" id="email" contenteditable="false"><?php echo $email; ?></span></p>
        <p><strong>Phone:</strong> <span class="editable" id="phone" contenteditable="false"><?php echo $phone; ?></span></p>
        <p><strong>Country:</strong> <span class="editable" id="country" contenteditable="false"><?php echo $country; ?></span></p>
        <p><strong>Address:</strong> <span class="editable" id="address" contenteditable="false"><?php echo $address; ?></span></p>
        <p><strong>Facebook:</strong> <span class="editable" id="facebook" contenteditable="false"><?php echo $facebook; ?></span></p>
    </div>

    <img src='../../info/<?php echo $username_; ?>.png' id='m_image' alt='My Image'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    const editableFields = document.querySelectorAll(".editable");
    let alertShown = false;
    function toggleEditSave(showButtonId, hideButtonId) {
        editableFields.forEach(field => {
            if (field.contentEditable === "true") {
                field.contentEditable = "false";
                field.classList.remove("edit-mode");
                document.getElementById(showButtonId).style.display = "none";
                document.getElementById(hideButtonId).style.display = "inline";
                if (!alertShown) {
                    showAlertOnSave();
                    alertShown = true;
                }
            } else {
                field.contentEditable = "true";
                field.classList.add("edit-mode");
                document.getElementById(showButtonId).style.display = "none";
                document.getElementById(hideButtonId).style.display = "inline";
                alertShown = false; 
            }
        });
    }

    function showAlertOnSave() {
        const name = editableFields[0].textContent;
        const email = editableFields[1].textContent;
        const phone = editableFields[2].textContent;
        const country = editableFields[3].textContent;
        const address = editableFields[4].textContent;
        const facebook = editableFields[5].textContent;
        $.ajax({
            type: 'POST',
            url: 'update.php',
            data: {
                name: name,
                email: email,
                phone: phone,
                country: country,
                address: address,
                facebook: facebook,
                username: '<?php echo $_SESSION['user_username']; ?>'
            },
            success: function(response) {
                console.log(response); 
                alert(response);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
        
    }

    function printQRCode() {
        const qrImage = document.getElementById('m_image');
        const printWindow = window.open('', '', 'width=600,height=600');
        printWindow.document.open();
        const squareFrameStyle = 'border: 5px solid #200; padding: 10px; display: inline-block;';
        printWindow.document.write('<div style="' + squareFrameStyle + '">');
        printWindow.document.write('<div style="text-align: center; margin-bottom: 10px; font-size:30px;">Who AM I?</div>');
        printWindow.document.write('<img src="' + qrImage.src + '" style="display: block; margin: 0 auto; width: 400px; height: 400px;">');
        printWindow.document.write('<div style="text-align: center; margin-top: 10px;">Want personal QR? <a href="http://www.helpfindmyitem.com" target="_blank">www.helpfindmyitem.com</a></div>');
        printWindow.document.write('</div>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    }

    const printQRButton = document.getElementById('printQRButton');
    printQRButton.addEventListener('click', printQRCode);
    </script>
</body>
</html>


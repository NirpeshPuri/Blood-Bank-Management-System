<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: index.html"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_SESSION['name']; 

    // Handle file upload
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
    }
    $targetFile = $targetDir . basename($_FILES["rec_card"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["rec_card"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>alert('File is not an image or PDF.'); window.location.href = 'receiver_dashboard.php';</script>";
        exit();
    }

    // Check file size
    if ($_FILES["rec_card"]["size"] > 5000000) { // Adjust the file size limit as needed 
        echo "<script>alert('Sorry, your file is too large.'); window.location.href = 'receiver_dashboard.php';</script>";
        exit();
    }

    // Allow only certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "pdf") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG, GIF, and PDF files are allowed.'); window.location.href = 'receiver_dashboard.php';</script>";
        exit();
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.'); window.location.href = 'receiver_dashboard.php';</script>";
        exit();
    } else {
        if (move_uploaded_file($_FILES["rec_card"]["tmp_name"], $targetFile)) {
            $conn = new mysqli("localhost", "root", "", "blood_bank");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $bloodType = $_POST["blood_type"];
            $quantity = $_POST["quantity"];
            $sqlUserId = "SELECT id FROM user WHERE name = '$user'";
            $resultUserId = $conn->query($sqlUserId);
            if ($resultUserId->num_rows > 0) {
                $row = $resultUserId->fetch_assoc();
                $userId = $row['id'];
        
                $sql = "INSERT INTO make_request (rec_id, user, blood_type, blood_quantity,rec_card_path) VALUES ('$userId', '$user', '$bloodType', '$quantity', '$targetFile')";
            $request_type = 'receiver'; // Set request type as 'receiver'
        
            $sqlInsert = "INSERT INTO request_detail (user, blood_type, blood_quantity, request_type) VALUES ('$user', '$bloodType', '$quantity', '$request_type')";
            if ($conn->query($sql) === TRUE && $conn->query($sqlInsert) === TRUE) {
                echo "<script>alert('Request submitted successfully.'); window.location.href = 'receiver_dashboard.php';</script>";
            } else {
                echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "'); window.location.href = 'receiver_dashboard.php';</script>";
            }

            $conn->close();
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href = 'receiver_dashboard.php';</script>";
        }
    }
}
} else {
    echo "<script>alert('Invalid request'); window.location.href = 'index.html';</script>";
}
?>

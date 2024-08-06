<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'donor') {
    header("Location: index.html"); 
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donorname = $_POST["name"];
    $bloodQuantity = $_POST["blood_quantity"];
    $bloodDateTime = date("Y-m-d H:i:s"); // Format: YYYY-MM-DD HH:MM:SS
    $donorPhone = $_POST["donor_phone"];
    $donorBloodType = $_POST["blood_type"];
    $request_type = 'donor';
    
    // Handle file upload
    $targetDir = "uploads/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
    }
    $targetFile = $targetDir . basename($_FILES["donor_card"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

   
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["donor_card"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>alert('File is not an image or PDF.'); window.location.href = 'donor_dashboard.php';</script>";
            exit();
        }
    }

    if ($_FILES["donor_card"]["size"] > 5000000) { // Adjust the file size limit as needed
        echo "<script>alert('Sorry, your file is too large.'); window.location.href = 'donor_dashboard.php';</script>";
        exit();
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" && $imageFileType != "pdf") {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG, GIF, and PDF files are allowed.'); window.location.href = 'donor_dashboard.php';</script>";
        exit();
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Sorry, your file was not uploaded.'); window.location.href = 'donor_dashboard.php';</script>";
        exit();
    } else {
        if (move_uploaded_file($_FILES["donor_card"]["tmp_name"], $targetFile)) {
            $conn = new mysqli("localhost", "root", "", "blood_bank");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sqlUserId = "SELECT id FROM user WHERE name = '$donorname'";
            $resultUserId = $conn->query($sqlUserId);
            if ($resultUserId->num_rows > 0) {
                $row = $resultUserId->fetch_assoc();
                $userId = $row['id'];

                $sql = "INSERT INTO donate_blood (donor_id, name, blood_quantity, blood_date_time, donor_phone, blood_type, donor_card_path) 
                        VALUES ('$userId', '$donorname', '$bloodQuantity', '$bloodDateTime', '$donorPhone', '$donorBloodType', '$targetFile')";
                $sqlInsert = "INSERT INTO request_detail (user, blood_type, blood_quantity, request_type) VALUES ('$donorname', '$donorBloodType', '$bloodQuantity', '$request_type')";

                if ($conn->query($sql) === TRUE && $conn->query($sqlInsert) === TRUE) {
                    echo "<script>alert('Donation recorded successfully.'); window.location.href = 'donor_dashboard.php';</script>";
                } else {
                    echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "'); window.location.href = 'donor_dashboard.php';</script>";
                }
            }

            $conn->close();
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.location.href = 'donor_dashboard.php';</script>";
            exit();
        }
    }
}
?>

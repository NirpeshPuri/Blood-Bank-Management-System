<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $requestId = $_GET["id"];

    $conn = new mysqli("localhost", "root", "", "blood_bank");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlSelectRequest = "SELECT * FROM donate_blood WHERE donate_id = $requestId";
    $result = $conn->query($sqlSelectRequest);

    if ($result->num_rows > 0) {
        $requestDetails = $result->fetch_assoc();
        $name = $requestDetails['name'];
        $bloodType = $requestDetails['blood_type'];
        $quantity = $requestDetails['blood_quantity'];
        $date_time = $requestDetails['blood_date_time'];
        $phone = $requestDetails['donor_phone'];
        
        $adminName = $_SESSION['name'];
        $sqlSelectAdminPhone = "SELECT phone FROM admin WHERE name = '$adminName'";
        $adminPhoneResult = $conn->query($sqlSelectAdminPhone);

        if ($adminPhoneResult->num_rows > 0) {
            $adminPhoneDetails = $adminPhoneResult->fetch_assoc();
            $adminPhone = $adminPhoneDetails['phone'];

            $sqlUpdateStatus = "UPDATE donate_blood SET status = 'approved' WHERE donate_id = $requestId";
            if ($conn->query($sqlUpdateStatus) === TRUE) {
                $sqlAcceptRequest = "INSERT INTO accepted_donor_requests (donate_id, name, blood_type, blood_quantity, blood_date_time, donor_phone, admin_phone) 
                                     VALUES ('$requestId', '$name', '$bloodType', '$quantity', '$date_time', '$phone', '$adminPhone')";

                if ($conn->query($sqlAcceptRequest) === TRUE) {
                    $sqlUpdateStock = "UPDATE stock_blood SET blood_quantity = blood_quantity + $quantity WHERE blood_type = '$bloodType'";
                    $conn->query($sqlUpdateStock);

                    echo "<script>alert('Donor request accepted successfully'); window.location.href = 'donor_requests.php';</script>";
                    exit();
                } else {
                    echo "<script>alert('Error accepting donor request: ".$conn->error."'); window.location.href = 'donor_requests.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Error updating donor request status: ".$conn->error."'); window.location.href = 'donor_requests.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Admin phone number not found'); window.location.href = 'donor_requests.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Invalid request ID');window.location.href = 'donor_requests.php?donate_id=$requestId'; </script>";
        exit();
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request'); window.location.href = 'donor_requests.php?donate_id=$requestId';</script>";
    exit();
}
?>

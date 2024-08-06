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

    $sqlSelectRequest = "SELECT * FROM make_request WHERE req_id = $requestId";
    $result = $conn->query($sqlSelectRequest);

    if ($result->num_rows > 0) {
        $requestDetails = $result->fetch_assoc();
        $bloodType = $requestDetails['blood_type'];
        $quantity = $requestDetails['blood_quantity'];

        $adminName = $_SESSION['name'];
        $sqlSelectAdminPhone = "SELECT phone FROM admin WHERE name = '$adminName'";
        $adminPhoneResult = $conn->query($sqlSelectAdminPhone);

        if ($adminPhoneResult->num_rows > 0) {
            $adminPhoneDetails = $adminPhoneResult->fetch_assoc();
            $adminPhone = $adminPhoneDetails['phone'];
            
            $sqlUpdateStatus = "UPDATE make_request SET status = 'approved' WHERE req_id = $requestId";
            if ($conn->query($sqlUpdateStatus) === TRUE) {
                $sqlAcceptRequest = "INSERT INTO accepted_requests (req_id, user, blood_type, blood_quantity, admin_phone) 
                                    VALUES ('$requestId', '{$requestDetails['user']}', '$bloodType', '$quantity', '$adminPhone')";
                
                if ($conn->query($sqlAcceptRequest) === TRUE) {
                    $sqlUpdateStock = "UPDATE stock_blood SET blood_quantity = blood_quantity - $quantity WHERE blood_type = '$bloodType'";
                    $conn->query($sqlUpdateStock);

                    echo "<script>alert('Receiver request accepted successfully'); window.location.href = 'admin_dashboard.php';</script>";
                } else {
                    echo "<script>alert('Error accepting receiver request: ".$conn->error."'); window.location.href = 'admin_dashboard.php';</script>";
                }
            } else {
                echo "<script>alert('Error updating request status: ".$conn->error."'); window.location.href = 'admin_dashboard.php';</script>";
            }
        } else {
            echo "<script>alert('Admin phone number not found'); window.location.href = 'admin_dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid request ID');window.location.href = 'admin_dashboard.php?req_id=$requestId'; </script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request'); window.location.href = 'admin_dashboard.php?req_id=$requestId';</script>";
}
?>

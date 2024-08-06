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

    $sqlUpdateStatus = "UPDATE donate_blood SET status = 'rejected' WHERE donate_id = $requestId";
    if ($conn->query($sqlUpdateStatus) === TRUE) {
        echo "<script>alert('Donor request rejected successfully'); window.location.href = 'donor_requests.php';</script>";
    } else {
        echo "<script>alert('Error rejecting donor request: ".$conn->error."'); window.location.href = 'donor_requests.php';</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request'); window.location.href = 'donor_requests.php?donate_id=$requestId';</script>";
}
?>

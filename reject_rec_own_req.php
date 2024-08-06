<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'receiver') {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["req_id"])) {
    $requestId = $_GET["req_id"];

    $conn = new mysqli("localhost", "root", "", "blood_bank");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sqlSelectRequest = "SELECT * FROM make_request WHERE req_id = $requestId AND status = 'pending'";
    $result = $conn->query($sqlSelectRequest);

    if ($result->num_rows > 0) {
        $sqlDeleteRequest = "DELETE FROM make_request WHERE req_id = $requestId";
        if ($conn->query($sqlDeleteRequest) === TRUE) {
            echo "<script>alert('Request delete successfully');</script>";
        } else {
            echo "<script>alert('Error deleting request: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('You cannot delete this request as it has already been approved or does not exist');</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request');</script>";
}

echo "<script>window.location.href = 'receiver_status.php';</script>";
?>

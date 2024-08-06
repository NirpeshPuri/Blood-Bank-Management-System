<?php
session_start();

if (!isset($_SESSION['name']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $userId = $_GET["id"];

    $conn = new mysqli("localhost", "root", "", "blood_bank");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM user WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Delete user successfully.'); window.location.href = 'user_details.php';</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $sql . "<br>" . $conn->error . "'); window.location.href = 'user_details.php';</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Invalid request'); window.location.href = 'admin_dashboard.php';</script>";
}
?>
